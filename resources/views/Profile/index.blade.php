@extends('layouts.app')

@section('content')
    <div class="container mb-5 mt-5">
        <main>
            <section class=" text-center container mb-3">
              <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <img src="{!! $user->profile_pic ?? 'https://www.silcharmunicipality.in/wp-content/uploads/2021/02/male-face.jpg' !!}" class="rounded-circle profile-pic" alt="Avatar" />
                  <h1 class="fw-light mt-2">{!! $user->username ?? '' !!}</h1>
                  <h5 class="fw-light">{!! $user->full_name !!}</h5>
                  @if ($user->role === 'Tutor')
                    <h5>Tutoring Session</h5>
                    <h1 class="text-primary fw-bolder">{{ count($user->tutoring->where('status', 2))}}</h1>
                  @endif
                  <div class="lead text-body-secondary" style="white-space: pre; width:100% !important">{!! $user->description !!}</div>
                    <div class="row">
                        @foreach ($user->sosmed as $sosmed)
                        <div class="col-md col-xs-3">
                            <a class="btn btn-icon" href="{!! $sosmed->link !!}" target="_blank">
                                @if($sosmed->type === 'instagram')
                                    <img class="img-fluid mw-30" src="https://www.cdnlogo.com/logos/i/92/instagram.svg" title="Instagram">
                                @elseif ($sosmed->type === 'whatsapp')
                                    <img class="img-fluid mw-30" src="https://www.cdnlogo.com/logos/w/35/whatsapp-icon.svg" title="Whatsapp">
                                @elseif ($sosmed->type === 'line')
                                    <img class="img-fluid mw-30" src="https://www.cdnlogo.com/logos/l/77/line.svg" title="Line">
                                @elseif ($sosmed->type === 'website')
                                    <i class="fa fa-list-alt" style="font-size:38px;" title="Website"></i>
                                @elseif ($sosmed->type === 'linkedin')
                                    <img class="img-fluid mw-30" src="https://www.cdnlogo.com/logos/l/66/linkedin-icon.svg" title="Linkedin">
                                @elseif ($sosmed->type === 'custom')
                                    <i class="fa fa-ellipsis-h" style="font-size:38px;" title="{{ $sosmed->link }}"></i>
                                @endif
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
              </div>
            </section>
          
            @if ($user->role === 'Tutor')
                @if ($user->post->isEmpty())
                <div class="col-12 text-center">
                    <h1 class="text-center">No activities have been done by the profile owner!</h1>
                </div>
                @else
                    <div class="album py-5 bg-body-tertiary mb-5">
                    <div class="container">
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 mb-5">
                            @foreach ($user->post as $post)
                                <div class="col mb-3">
                                    <div class="card shadow-sm">
                                        <img src="{!! $post->img_url !!}" class="bd-placeholder-img card-img-top" width="100%" height="225" role="img" aria-label="Placeholder: Thumbnail" alt="Post Image">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-10">
                                                    <p class="card-text">{!! $post->title !!}</p>
                                                </div>
                                                <div class="col-2">
                                                    <a href="{{route("profile.index", ["user" => $post->user->id])}}">
                                                        <img src="{!! $post->user->profile_pic !!}" class="rounded-circle profile-pic img-fluid" alt="Avatar" />
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-12">
                                                    <div class="btn-group">
                                                        <a href="{{route('post.show', $post->id)}}" class="btn btn-sm btn-outline-secondary mx-2">View</a>
                                                        @auth
                                                        @if (Auth::user()->id === $post->user_id)
                                                        <a href="{{route('post.edit', $post->id)}}" class="btn btn-sm btn-warning mx-2">Edit</a>
                                                        <a href="{{route('post.delete', $post->id)}}" class="btn btn-sm btn-danger mx-2" onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>
                                                        @endif
                                                        @endauth
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-12 mt-2 d-flex justify-content-between align-items-center">
                                                    <small class="text-body-secondary badge">{{ $post->tipe }} | {{ $post->lokasi }}</small>
                                                    <small class="text-body-secondary">{{ $post->created_at->format('d/m/Y') }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    </div>
                @endif
            @else
                @if ($user->pesertaTutor->where('status_kehadiran', 1)->isEmpty())
                    <div class="col-12 text-center">
                        <h1 class="text-center">No activities have been done by the profile owner!</h1>
                    </div>
                @else
                    <div class="album py-5 bg-body-tertiary mb-5 shadow">
                        <h1 class="text-center mb-5 text-primary fw-bold" style="text-shadow: 1px 1px 3px #489dff9f !important">User participation history</h1>
                    <div class="container">
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 mb-5">
                            @foreach ($user->pesertaTutor->where('status_kehadiran', 1) as $post)
                                @if ($post->tutoring->status === 2)
                                    <div class="col mb-3">
                                        <div class="card shadow-sm">
                                            <img src="{!! $post->tutoring->post->img_url !!}" class="bd-placeholder-img card-img-top" width="100%" height="225" role="img" aria-label="Placeholder: Thumbnail" alt="Post Image">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <p class="card-text">{!! $post->tutoring->post->title !!}</p>
                                                    </div>
                                                    <div class="col-2">
                                                        <a href="{{route("profile.index", ["user" => $post->tutoring->post->user->id])}}">
                                                            <img src="{!! $post->tutoring->post->user->profile_pic !!}" class="rounded-circle profile-pic img-fluid" alt="Avatar" />
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="row mt-2">
                                                    <div class="col-12">
                                                        <div class="btn-group">
                                                            <a href="{{route('post.show', $post->tutoring->post->id)}}" class="btn btn-sm btn-outline-secondary mx-2">View</a>
                                                            @auth
                                                            @if (Auth::user()->id === $post->tutoring->post->user_id)
                                                            <a href="{{route('post.edit', $post->tutoring->post->id)}}" class="btn btn-sm btn-warning mx-2">Edit</a>
                                                            <a href="{{route('post.delete', $post->tutoring->post->id)}}" class="btn btn-sm btn-danger mx-2" onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>
                                                            @endif
                                                            @endauth
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="col-12 mt-2 d-flex justify-content-between align-items-center">
                                                        <small class="text-body-secondary badge">{{ $post->tutoring->post->tipe }} | {{ $post->tutoring->post->lokasi }}</small>
                                                        <small class="text-body-secondary">{{ $post->tutoring->post->created_at->format('d/m/Y') }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    </div>
                @endif
            @endif
          
          </main>
    </div>
@endsection
    