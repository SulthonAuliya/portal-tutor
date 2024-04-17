@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="album py-5 bg-body-tertiary my-5">
            <div class="container">
              <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 mb-5">
                  @foreach ($posts as $post)
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
                                    <div class="col-12 d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <a href="{{route('post.show', $post->id)}}" class="btn btn-sm btn-outline-secondary">View</a>
                                        </div>
                                        
                                    </div>
                                    <div class="col-12 mt-3 d-flex justify-content-between align-items-center">
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
    </div>
@endsection
    