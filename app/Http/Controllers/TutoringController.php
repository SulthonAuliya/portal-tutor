<?php

namespace App\Http\Controllers;

use App\Models\TutorSession;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
}
