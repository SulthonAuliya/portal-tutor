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

    public function create(){
        $bidangs = Bidang::get();
        $categories = Categories::get();
        return view('Posts.create', compact('bidangs', 'categories'));
    }

    public function store(Request $request){
        $request->validate([
            'bidang_id'     =>'required',
            'category_id'   =>'required',
            'title'         =>'required',
            'tipe'          =>'required',
            'lokasi'        =>'required',
            'deskripsi'     =>'required',
            'image_url'     =>'required',
        ]);

        

        if ($request->hasFile('image_url')) {
            $image = $request->file('image_url');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $imagePath = asset('images/' . $imageName);
        }

        $data = [
            'user_id'       => Auth::user()->id,
            'title'         => $request->title,
            'description'   => $request->deskripsi,
            'tipe'          => $request->tipe,
            'lokasi'        => $request->lokasi,
            'img_url'       => $imagePath,
        ];

        $post = Post::create($data);
        $post->categories()->attach($request->category_id);
        return redirect('beranda');
    }

    public function edit(Post $post){
        $bidangs = Bidang::get();
        $categories = Categories::get();
        $selectedCategories = $post->categories->pluck('id')->toArray();
        $kotas = Kota::get();
        return view('Posts.edit', compact('post', 'bidangs', 'categories', 'selectedCategories', 'kotas'));
    }

    public function show(Post $post){
        return view('Posts.show', compact('post'));
    }
}
