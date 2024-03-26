@extends('layouts.app')

@section('content')
    <div class="container mb-5">
        <main>

            <section class=" text-center container">
              <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <img src="{!! $user->profile_pic !!}" class="rounded-circle" style="width: 150px;" alt="Avatar" />
                  <h1 class="fw-light mt-5">{!! $user->username !!}</h1>
                  <h5 class="fw-light">{!! $user->full_name !!}</h5>
                  <p class="lead text-body-secondary">{!! $user->description !!}</p>
                    <div class="row">
                        @foreach ($user->sosmed as $sosmed)
                        <div class="col-mds col-xss-3">
                            <a class="btn btn-icon" href="{!! $sosmed->link !!}" target="_blank">
                                @if($sosmed->type === 'instagram')
                                    <img class="img-fluid mw-30" src="https://www.cdnlogo.com/logos/i/92/instagram.svg">
                                @elseif ($sosmed->type === 'whatsapp')
                                    <img class="img-fluid mw-30" src="https://www.cdnlogo.com/logos/w/35/whatsapp-icon.svg">
                                @elseif ($sosmed->type === 'line')
                                    <img class="img-fluid mw-30" src="https://www.cdnlogo.com/logos/l/77/line.svg">
                                @elseif ($sosmed->type === 'website')
                                    <i class="fa fa-list-alt" style="font-size:38px;"></i>
                                @elseif ($sosmed->type === 'linkedin')
                                    <img class="img-fluid mw-30" src="https://www.cdnlogo.com/logos/l/66/linkedin-icon.svg">
                                @elseif ($sosmed->type === 'custom')
                                    <i class="fa fa-ellipsis-h" style="font-size:38px;"></i>
                                @endif
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
              </div>
            </section>
          
            <div class="album py-5 bg-body-tertiary mb-5">
              <div class="container">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 mb-5">
                    @foreach ($user->post as $post)
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
          
          </main>
    </div>
@endsection
    