<?php

namespace App\Http\Controllers;

use App\Models\BuktiTutoring;
use App\Models\PesertaTutoring;
use App\Models\TutorSession;
use App\Models\UlasanTutoring;
use App\Models\User;
use App\Notifications\UserSystemNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class TutoringController extends Controller
{
    public function storeTutorSession(Request $request){
        try{
            $codeLength = 5;
            
            do {
                // Generate a random string of specified length
                $invitationCode = Str::random($codeLength);
                
                // Check if the generated code already exists in the database
                $existingCode = TutorSession::where('invitation_code', $invitationCode)->exists();
                
                // If the code already exists or all possibilities are exhausted for this code length, increase the code length
                if ($existingCode || pow(36, $codeLength) - TutorSession::count() <= 0) {
                    $codeLength++; // Increase code length
                    $existingCode = false; // Reset existingCode to generate new code with the increased length
                }
            } while ($existingCode);
            
            // Create the session with the generated invitation code
            $data = [
                'tutor_id'          => Auth::user()->id,
                'post_id'           => $request->course_id,
                'invitation_code'   => $invitationCode,
                'status'            => 0
            ];
            
            TutorSession::create($data);

            $message = "Tutor session created successfully.";

            // Flash the message to the session
            Session::flash('success', $message);
            
        }catch(Exception $e){
            $message = "Failed to create tutor session.";

            // Flash the message to the session
            Session::flash('error', $message);
            Log::info($e->getMessage());
        }
        return redirect()->back();
    }

    public function manageTutorSession(){
        $tutors = TutorSession::when(Auth::user()->role === 'Tutor', function($q) {
                                $q->where('tutor_id', Auth::user()->id);
                            })->when(Auth::user()->role === 'Tutee', function($q) {
                                $q->whereHas('pesertaTutor', function($q){
                                    $q->where('user_id', Auth::user()->id);
                                });
                            })->orderBy('created_at', 'asc')->get();

        return view('tutor.index', compact('tutors'));
    }

    public function joinSession(Request $request){
        $code = $request->invite_code;
        DB::beginTransaction();
        try{
            $tutorSession = TutorSession::where(DB::raw('BINARY `invitation_code`'), $code)->first();
            if ($tutorSession){
                $user = Auth::user();
                if($user->id != $tutorSession->tutor_id){
                    if($tutorSession->status != 2){

                        $create = PesertaTutoring::firstOrCreate([
                            'user_id'       => $user->id,
                            'tutoring_id'   => $tutorSession->id,
                        ]);
                        if ($create->wasRecentlyCreated) {
                            $message = "Berhasil bergabung ke dalam tutoring session!";
                            Session::flash('success', $message);

                            $recipient = User::find($tutorSession->tutor_id);
                            $title = 'Seseorang baru saja bergabung dengan tutoring session anda!';
                            $msg = $user->full_name . ' baru saja bergabung dengan tutoring session anda melalui invitation code!';
                            $url = route('tutor.detail', ['session' => $tutorSession->id]);
                            $recipient->notify(new UserSystemNotification(['title' => $title, 'message' => $msg, 'url' => $url]));
                            DB::commit();
                        } else {
                            $message = "Anda sudah terdaftar dalam tutoring session ini!";
                            Session::flash('error', $message);
                        }
                    }else{
                        $message = "Anda tidak bisa bergabung dengan tutor yang sudah selesai / dibatalkan!";
                        Session::flash('error', $message);
                    }
                }else{
                    $message = "Anda tidak bisa bergabung dengan tutor session anda sendiri!";
                    Session::flash('error', $message);
                }
            }else{
                $message = "Tutoring session yang anda cari tidak ditemukan!";
                Session::flash('error', $message);
            }
            return redirect()->route('tutor.detail', ['session' => $tutorSession]);
        }catch(Exception $e){
            DB::rollBack();
            $message = "Terjadi kesalahan dalam proses bergabung dengan tutoring session!";
            Session::flash('error', $message);
            Log::info($e->getMessage());
            return redirect()->back();
        }
    }
    public function show(TutorSession $session){
        $session->load('pesertaTutor', 'post', 'tutor', 'buktiTutor');
        $peserta = [];
        $buktiTutoring = [];
        if($session->status === 2){
            $peserta = PesertaTutoring::where('tutoring_id', $session->id)->where('status_kehadiran', 1)->get();
            $buktiTutoring = BuktiTutoring::where('tutoring_id', $session->id)
                                         ->get()
                                         ->keyBy('user_id');
        }
        return view('tutor.detail', compact('session', 'peserta', 'buktiTutoring'));
    }

    public function mulaiSession(TutorSession $session){
        try{
            $session->update([
                'status'    => 1,
                'start_time'=> now()
            ]);
            $message = "Tutoring session dimulai!";
            Session::flash('success', $message);

            $recipient = User::find($session->tutor_id);
            $title = 'Session yang anda ikuti sudah dimulai!';
            $msg = 'Session anda dengan materi ' . $session->post->title . ' sudah dimulai!';
            $url = route('tutor.detail', ['session' => $session->id]);
            $recipient->notify(new UserSystemNotification(['title' => $title, 'message' => $msg, 'url' => $url]));
            $broadcast = PesertaTutoring::where('tutoring_id', $session->id)->get();
            foreach ($broadcast as $penerima){
                $user = $penerima->user;
                $user->notify(new UserSystemNotification(['title' => $title, 'message' => $msg, 'url' => $url]));
            }

            return redirect()->back();
        }catch(Exception $e){
            $message = "Terjadi kesalahan dalam proses memulai tutoring session!";
            Session::flash('error', $message);
            Log::info($e->getMessage());
            return redirect()->back();
        }
    }

    public function endSession(TutorSession $session){
        try{
            $session->update([
                'status'    => 2,
                'end_time'=> now()
            ]);
            $message = "Tutoring session diselesaikan!";
            Session::flash('success', $message);

            $recipient = User::find($session->tutor_id);
            $title = 'Session yang anda ikuti telah selesai!';
            $msg = 'Session anda dengan materi ' . $session->post->title . ' telah selesai!';
            $url = route('tutor.detail', ['session' => $session->id]);
            $recipient->notify(new UserSystemNotification(['title' => $title, 'message' => $msg, 'url' => $url]));
            $broadcast = PesertaTutoring::where('tutoring_id', $session->id)->get();
            foreach ($broadcast as $penerima){
                $user = $penerima->user;
                $user->notify(new UserSystemNotification(['title' => $title, 'message' => $msg, 'url' => $url]));
            }
            return redirect()->back();
        }catch(Exception $e){
            $message = "Terjadi kesalahan dalam proses menyelesaikan tutoring session!";
            Session::flash('error', $message);
            Log::info($e->getMessage());
            return redirect()->back();
        }
    }

    public function batalSession(TutorSession $session){
        try{
            $session->update([
                'status'    => 3
            ]);
            $message = "Tutoring session dibatalkan!";
            Session::flash('success', $message);

            $recipient = User::find($session->tutor_id);
            $title = 'Session yang anda ikuti telah dibatalkan';
            $msg = 'Session anda dengan materi ' . $session->post->title . ' telah dibatalkan';
            $url = route('tutor.detail', ['session' => $session->id]);
            $recipient->notify(new UserSystemNotification(['title' => $title, 'message' => $msg, 'url' => $url]));
            $broadcast = PesertaTutoring::where('tutoring_id', $session->id)->get();
            foreach ($broadcast as $penerima){
                $title = $title . ' oleh pihak mentor!';
                $msg = $msg . ' oleh pihak mentor!';
                $user = $penerima->user;
                $user->notify(new UserSystemNotification(['title' => $title, 'message' => $msg, 'url' => $url]));
            }
            return redirect()->back();
        }catch(Exception $e){
            $message = "Terjadi kesalahan dalam proses membatalkan tutoring session!";
            Session::flash('error', $message);
            Log::info($e->getMessage());
            return redirect()->back();
        }
    }
    public function deleteSession(TutorSession $session){
        try{
            $session->delete();
            $message = "Tutoring session dihapus!";
            Session::flash('success', $message);
            return redirect()->back();
        }catch(Exception $e){
            $message = "Terjadi kesalahan dalam proses menghapus tutoring session!";
            Session::flash('error', $message);
            Log::info($e->getMessage());
            return redirect()->back();
        }
    }

    public function uploadBuktiTutor(Request $request){
        try{
            $request->validate([
                'img_url'   => 'required'
            ]);
            
            if ($request->hasFile('img_url')) {
                $image = $request->file('img_url');
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);
                $imagePath = asset('images/' . $imageName);
            }

            BuktiTutoring::create([
                'user_id'       => Auth::user()->id,
                'tutoring_id'   => $request->tutor_id,
                'img_url'       => $imagePath
            ]);
            $message = "Bukti tutoring session berhasil di upload!";
            Session::flash('success', $message);

            $session = TutorSession::find($request->tutor_id);
            $attendees = $session->pesertaTutor()->where('status_kehadiran', 1)->get();
            $attendeeIds = $attendees->pluck('user_id');
            $attendeeIds->push($session->tutor_id);
            $proofs = $session->buktiTutor()->whereIn('user_id', $attendeeIds)->get();
            $uploadedProofIds = $proofs->pluck('user_id');
            $allUploaded = $attendeeIds->diff($uploadedProofIds)->isEmpty();
            if($allUploaded){
                $recipient = User::find($session->tutor_id);
                $title = 'Semua partisipan telah mengupload bukti tutor!';
                $msg = 'Semua partisipan dari tutoring session dengan materi ' . $session->post->title . ' telah mengupload bukti tutor.';
                $url = route('tutor.detail', ['session' => $session->id]);
                $recipient->notify(new UserSystemNotification(['title' => $title, 'message' => $msg, 'url' => $url]));
                $broadcast = PesertaTutoring::where('tutoring_id', $session->id)->get();
                foreach ($broadcast as $penerima){
                    $title = $title . ' Silahkan berikan penilaian atas pengalaman anda.';
                    $msg = $msg . ' Silahkan berikan penilaian atas pengalaman anda dalam melaksanakan seluruh rangkataian mentoring dengan mentor ' . $recipient->full_name;
                    $user = $penerima->user;
                    $user->notify(new UserSystemNotification(['title' => $title, 'message' => $msg, 'url' => $url]));
                }
            }

            return redirect()->back();
        }catch(Exception $e){
            $message = "Terjadi kesalahan dalam proses mengupload bukti tutoring!";
            Session::flash('error', $message);
            Log::info($e->getMessage());
            return redirect()->back();
        }
    }

    public function kehadiran(PesertaTutoring $peserta, Request $request){
        if(Auth::user()->role === 'Tutor'){
            try{
                $request->validate([
                    'status'   => 'required'
                ]);

                $peserta->update([
                    'status_kehadiran' => $request->status
                ]);
                $message = "Presensi tutoring berhasil di lakukan!";
                Session::flash('success', $message);

                $session = TutorSession::find($peserta->tutoring_id);
                switch($request->status) {
                    case 1:
                        $status = 'Hadir';
                        break;
                    case 2:
                        $status = 'Sakit';
                        break;
                    case 3:
                        $status = 'Izin';
                        break;

                    }
                $title = 'Anda telah ditetapkan '. $status .' dalam tutoring session!';
                $msg = 'Anda telah ditetapkan '. $status .' dalam tutoring session dengan materi ' . $session->post->title . '!';
                $url = route('tutor.detail', ['session' => $session->id]);
                $broadcast = PesertaTutoring::where('tutoring_id', $session->id)->get();
                foreach ($broadcast as $penerima){
                    $user = $penerima->user;
                    $user->notify(new UserSystemNotification(['title' => $title, 'message' => $msg, 'url' => $url]));
                }
                return redirect()->back();
            }catch(Exception $e){
                $message = "Terjadi kesalahan dalam proses presensi tutoring!";
                Session::flash('error', $message);
                Log::info($e->getMessage());
                return redirect()->back();
            }
        }else{
            $message = "Anda tidak dapat mengisis presensi tutoring!";
            Session::flash('error', $message);
            return redirect()->route('beranda');
        }
    }

    public function listTutoringByAuthor(User $user){
        $user = $user->load('tutoring');
        return view('Profile.listTutoring', compact('user'));
    }

    public function reviewTutor(Request $request){
        try{
            $request->validate([
                'description'   => 'required|max:300'
            ]);
    
            $data = [
                'user_id'       => Auth::user()->id,
                'tutoring_id'   => $request->tutor_id,
                'rating'        => $request->rating,
                'description'   => $request->description
            ];

            UlasanTutoring::create($data);
            $message = "Review tutoring berhasil di submit! Terimakasih atas penilaian anda.";
            Session::flash('success', $message);

            $session = TutorSession::find($request->tutor_id)->first();
            $recipient = User::find($session->tutor_id);
            $title = Auth::user()->full_name . ' Telah menulis review untuk tutoring session anda!';
            $msg =  Auth::user()->full_name . ' Telah menulis review untuk anda pada tutoring session dengan materi ' . $session->post->title . '!';
            $url = route('tutor.detail', ['session' => $session->id]);
            $recipient->notify(new UserSystemNotification(['title' => $title, 'message' => $msg, 'url' => $url]));

            return redirect()->back();
        }catch(Exception $e){
            $message = "Terjadi kesalahan dalam proses review tutoring!";
            Session::flash('error', $message);
            Log::info($e->getMessage());
            return redirect()->back();
        }

    }

}
