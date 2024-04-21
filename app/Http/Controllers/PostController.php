<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\Categories;
use App\Models\Kota;
use App\Models\Post;
use App\Models\PostCategories;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use stdClass;

class PostController extends Controller
{
    public function index(){
        $posts = Post::orderBy('created_at', 'desc');
        $user = Auth::user();
        if(!Auth::guest()){
            $posts = $posts->when($user->content_settings === 1, function($q) use($user){
                           $q->whereHas('categories.bidang', function($q) use($user){
                            $q->whereIn('bidang.id', $user->bidang->pluck('id'));
                        });
                    })
                    ->when($user->content_settings === 2 , function($q) use($user){
                        $q->whereHas('categories', function($q) use($user){
                            $q->whereIn('categories.id', $user->interest->pluck('id'));
                        });
                    });
        }

        $posts = $posts->get();
        return view('Posts.beranda', compact('posts'));
    }

    public function getKota(){
        $datas = Kota::get();

        return response()->json($datas);
    }

    public function getCourseUser(){
        $datas = Post::where('user_id', Auth::user()->id)->get();
        $allCourse = new stdClass();
        $allCourse->id = 0;
        $allCourse->title = "Select Course";

        // Prepend the new object to the beginning of the $datas array
        $datas->prepend($allCourse);
        return response()->json($datas);
    }

    public function getDetailCourse(Request $request){
        $post = Post::find($request->courseId);
        return response()->json($post);
    }

    public function getBidang(){
        $datas = Bidang::get();

        // Create a new object with id 0 and name "all"
        $allBidang = new stdClass();
        $allBidang->id = 0;
        $allBidang->name = "all";

        // Prepend the new object to the beginning of the $datas array
        $datas->prepend($allBidang);

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
        try{
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
            $message = "Post created successfully.";

            // Flash the message to the session
            Session::flash('success', $message);
            
        }catch(Exception $e){
            $message = "Failed to create post.";

            // Flash the message to the session
            Session::flash('error', $message);
            Log::info($e->getMessage());
        }
        return redirect()->route('profile.index', ['user' => $data['user_id']]);
    }

    public function update(Post $post,Request $request){
        try{
            $request->validate([
                'bidang_id'     =>'required',
                'category_id'   =>'required',
                'title'         =>'required',
                'tipe'          =>'required',
                'lokasi'        =>'required',
                'deskripsi'     =>'required',
                'old_image'     =>'required',
            ]);


            if ($request->hasFile('image_url')) {
                $image = $request->file('image_url');
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);
                $imagePath = asset('images/' . $imageName);
            }else{
                $imagePath = $post->img_url;
            }


            $data = [
                'user_id'       => Auth::user()->id,
                'title'         => $request->title,
                'description'   => $request->deskripsi,
                'tipe'          => $request->tipe,
                'lokasi'        => $request->lokasi,
                'img_url'       => $imagePath,
            ];

            $post->update($data);
            $post->categories()->attach($request->category_id);
         
            $message = "Post updated successfully.";

            // Flash the message to the session
            Session::flash('success', $message);
            
        }catch(Exception $e){
            $message = "Failed to update post.";

            // Flash the message to the session
            Session::flash('error', $message);
            Log::info($e->getMessage());
        }
        return redirect()->route('profile.index', ['user' => $data['user_id']]);
    }

    public function edit(Post $post){
        $bidangs = Bidang::get();
        $categories = Categories::get();
        $selectedCategories = $post->categories->pluck('id')->toArray();
        $kotas = Kota::get();
        return view('Posts.edit', compact('post', 'bidangs', 'categories', 'selectedCategories', 'kotas'));
    }

    public function delete(Post $post){
        try{
            PostCategories::where('post_id', $post->id)->delete();
            $post->delete();
            $message = "Post deleted successfully.";

            // Flash the message to the session
            Session::flash('success', $message);
            
        }catch(Exception $e){
            $message = "Failed to delete Post.";

            // Flash the message to the session
            Session::flash('error', $message);
            Log::info($e->getMessage());
        }
        return redirect()->back();
    }

    public function show(Post $post){
        $post->load('tutorSession.ulasan.user');
        return view('Posts.show', compact('post'));
    }

    public function search(Request $request){
        $bidang     = $request->bidang ?? null;
        $category   = $request->category ?? null;
        $search     = $request->search ?? null;
        $tipe       = $request->tipe ?? null;
        if($tipe != null){
            // dd("hello");
            $users = [];
            $posts = [];
            if($tipe === 'profiles'){
                $users = User::where('username', 'LIKE', '%' . $search . '%')->orWhere('full_name', 'LIKE', '%' . $search . '%')->get();
            }else if($tipe === 'posts'){
                $posts = Post::where('title', 'LIKE', '%' . $search . '%')
                    ->when($bidang != null && $bidang !=0 , function($q) use($bidang){
                        $q->whereHas('categories.bidang', function($q) use($bidang){
                            $q->where('bidang.id', $bidang);
                        });
                    })
                    ->when($category != null && $category !=0 , function($q) use($category){
                        $q->whereHas('categories', function($q) use($category){
                            $q->where('categories.id', $category);
                        });
                    })
                    ->get();
            }
        }else{
            $users = User::where('username', 'LIKE', '%' . $search . '%')->orWhere('full_name', 'LIKE', '%' . $search . '%')->limit(3)->get();
            $posts = Post::where('title', 'LIKE', '%' . $search . '%')
                    ->when($bidang != null && $bidang !=0 , function($q) use($bidang){
                        $q->whereHas('categories.bidang', function($q) use($bidang){
                            $q->where('bidang.id', $bidang);
                        });
                    })
                    ->when($category != null && $category !=0 , function($q) use($category){
                        $q->whereHas('categories', function($q) use($category){
                            $q->where('categories.id', $category);
                        });
                    })
                    ->limit(3)->get();
        }

        return view('Posts.berandaSearch', compact('users', 'posts'));
        
    }
}
