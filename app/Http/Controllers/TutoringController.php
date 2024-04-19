<?php

namespace App\Http\Controllers;

use App\Models\PesertaTutoring;
use App\Models\TutorSession;
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
            $codeLength = 3;
            
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
        try{
            $tutorSession = TutorSession::where(DB::raw('BINARY `invitation_code`'), $code)->first();
            if ($tutorSession){
                $user = Auth::user();
                PesertaTutoring::create([
                    'user_id'       => $user->id,
                    'tutoring_id'   => $tutorSession->id,
                ]);
                $message = "Berhasil bergabung kedalam tutoring session!";
                Session::flash('success', $message);
            }else{
                $message = "Tutoring session yang anda cari tidak ditemukan!";
                Session::flash('error', $message);
            }
            return redirect()->back();
        }catch(Exception $e){
            $message = "Terjadi kesalahan dalam proses bergabung dengan tutoring session!";
            Session::flash('error', $message);
            Log::info($e->getMessage());
            return redirect()->back();
        }
    }
    public function show(TutorSession $session){
        $session->load('pesertaTutor', 'post', 'tutor');
        return view('tutor.detail', compact('session'));
    }
}
