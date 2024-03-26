<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index($id){
        $user = User::with('post', 'sosmed')->find($id);
        return view('Profile.index', compact('user'));
    }
}
