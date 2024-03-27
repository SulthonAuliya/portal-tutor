<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\Categories;
use App\Models\Kota;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(){
        $posts = Post::orderBy('created_at');
        if(!Auth::guest()){

        }

        $posts = $posts->get();
        return view('Posts.beranda', compact('posts'));
    }

    public function getKota(){
        $datas = Kota::get();

        return response()->json($datas);
    }

    public function getBidang(){
        $datas = Bidang::get();

        return response()->json($datas);
    }

    public function getCategories(Request $request){
        $req = $request->all();
        $bidangId = $req['bidangId'];
        if($bidangId === null){
            $datas = Categories::get();
        }else{
            $datas = Categories::where('bidang_id', $bidangId)->get();
        }

        return response()->json($datas);
    }

    public function create(Request $request){
        return  view('Posts.create');
    }
}
