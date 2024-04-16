<?php

namespace App\Http\Controllers;

use App\Models\Sosmed;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index($id){
        $user = User::with('post', 'sosmed')->find($id);
        return view('Profile.index', compact('user'));
    }

    public function edit($id){
        $user = User::with('post', 'sosmed')->find($id);
        return view('Profile.edit', compact('user'));
    }

    public function update(User $user, Request $request){
        $request->validate([
            'username'      => 'required|unique:users,username,'.$user->id,
            'email'         => 'required',
            'full_name'     => 'required',
            'description'   => 'nullable'
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
            'profile_pic'       => $imagePath,
        ];

        $user->update($data);
        // Loop through the sosmed data
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
        
        return redirect()->route('profile.index', ['user' => $user->id]);
    }
    
}
