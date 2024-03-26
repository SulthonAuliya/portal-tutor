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
                                  <p class="card-text">{!! $post->title !!}</p>
                                  <div class="d-flex justify-content-between align-items-center">
                                      <div class="btn-group">
                                          <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                                          @auth
                                              @if (Auth::user()->id === $post->user_id)
                                                  <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                                              @endif
                                          @endauth
                                      </div>
                                      <small class="text-body-secondary">{{ $post->created_at->format('d/m/Y') }}</small>
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
    