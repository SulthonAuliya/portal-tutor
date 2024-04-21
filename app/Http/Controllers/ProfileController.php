<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\Categories;
use App\Models\Sosmed;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function index($id){
        $user = User::with('post', 'sosmed', 'pesertaTutor.tutoring')->find($id);
        return view('Profile.index', compact('user'));
    }

    public function edit($id){
        $user = User::with('post', 'sosmed')->find($id);
        return view('Profile.edit', compact('user'));
    }

    public function update(User $user, Request $request){
        try{
            $request->validate([
                'username'      => 'required|unique:users,username,'.$user->id,
                'email'         => 'required',
                'full_name'     => 'required',
                // 'description'   => 'nullable'
            ]);
            // dd($request->all());

            if ($request->hasFile('profile_pic')) {
                $image = $request->file('profile_pic');
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);
                $imagePath = asset('images/' . $imageName);
            }else{
                $imagePath = $user->profile_pic;
            }

            $data = [
                'email'             => $request->email,
                'username'          => $request->username,
                'description'       => $request->description,
                'full_name'         => $request->full_name,
                'city'              => $request->city,
                'phone_number'      => $request->phone_number,
                'role'              => $request->role,
                'profile_pic'       => $imagePath,
            ];

            $user->update($data);
            // Loop through the sosmed data
            if($request->sosmed !== null){
                foreach ($request->sosmed as $data) {
                    if (isset($data['id'])) {
                        // If the record has an ID
                        if (!empty($data['name']) && !empty($data['link'])) {
                            // If name and link are not empty, update the existing record
                            $sosmed = Sosmed::find($data['id']);
                            $sosmed->update([
                                'type' => $data['type'],
                                'name' => $data['name'],
                                'link' => $data['link']
                            ]);
                        } else {
                            // If name or link is empty, delete the record
                            Sosmed::destroy($data['id']);
                        }
                    } else {
                        // If the record doesn't have an ID, create a new record
                        $user->sosmed()->create([
                            'user_id'   => $user->id,
                            'type'      => $data['type'],
                            'name'      => $data['name'],
                            'link'      => $data['link']
                        ]);
                    }
            }
        }
            $message = "Profile updated successfully.";

            // Flash the message to the session
            Session::flash('success', $message);
            
        }catch(Exception $e){
            $message = "Failed to update Profile.";

            // Flash the message to the session
            Session::flash('error', $message);
            Log::info($e->getMessage());
        }
        
        return redirect()->route('profile.index', ['user' => $user->id]);
    }

    public function editPreferences($id){
        $user = User::with('post', 'sosmed')->find($id);
        $bidangs = Bidang::get();
        $categories = Categories::get();
        $selectedCategories = $user->interest->pluck('id')->toArray();
        $selectedBidangs = $user->bidang->pluck('id')->toArray();
        return view('Profile.editPreferences', compact('user', 'bidangs', 'categories', 'selectedBidangs', 'selectedCategories'));
    }

    public function updatePreferences(User $user, Request $request){
        try{
            if ($user->bidang()->exists()) {
                $user->bidang()->detach();
            } 
            if ($user->interest()->exists()) {
                $user->interest()->detach();
            } 

            $user->bidang()->attach($request->bidang_id);
            $user->interest()->attach($request->category_id);
            // dd((int)$request->content_settings);
            $user->update(['content_settings' => (int)$request->content_settings]);
            $message = "Preferences updated successfully.";

            // Flash the message to the session
            Session::flash('success', $message);
            
        }catch(Exception $e){
            $message = "Failed to update preferences.";

            // Flash the message to the session
            Session::flash('error', $message);
            Log::info($e->getMessage());
        }

        return redirect()->route('profile.index', ['user' => $user->id]);
    }
    
}
