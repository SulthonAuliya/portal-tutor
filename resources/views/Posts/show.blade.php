@extends('layouts.app')

@section('content')
    <main class="container my-5">
        
        <div class="row">
            <img class="bd-placeholder-img rounded shadow-lg"   src="{!! $post->img_url !!}"aria-hidden="true" alt="Post Image">
        </div>
        <div class="row g-5 mt-4">
            <div class="col-md-8">
            <h3 class="pb-4 mb-4 fst-italic border-bottom">
                @if(count($post->categories) > 0)
                    {{ $post->categories[0]->bidang->name}} |  
                    @foreach ($post->categories as $category)
                        <span>{{$category->name}}@if (!$loop->last), @endif</span>
                    @endforeach
                @endif
            </h3>
        
            <article class="blog-post">
                <h2 class="display-5 link-body-emphasis mb-1">{{$post->title}}</h2>
                <p class="blog-post-meta">{{$post->created_at->format('F j, Y')}} by <a href="{{route('profile.index', $post->user_id)}}">{{$post->user->username}}</a></p>
                <hr>
                {!! $post->description !!}

            </article>
        
            </div>
        
            <div class="col-md-4">
            <div class="position-sticky" style="top: 2rem;">
                <div class="p-4 mb-3 bg-body-tertiary rounded">
                <h4><span class="fst-italic">About </span><a class="link-primary" href="{{route('profile.index', $post->user_id)}}">{{$post->user->username}}</a></h4>
                <p class="mb-0">{{ $post->user->description}}</p>
                </div>
        
                <div>
                <h4 class="fst-italic">Recent courses by the same tutor</h4>
                <ul class="list-unstyled">
                    @php
                        $maxIterations = 3;
                        $counter = 0;
                    @endphp
                    @foreach ($post->user->post as $posts)
                    <li>
                        <a class="d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center py-3 link-body-emphasis text-decoration-none border-top" href="#">
                            <img class="bd-placeholder-img"  height="96" src="{!! $posts->img_url !!}"aria-hidden="true" alt="Post Image">
                            <div class="col-lg-8">
                                <h6 class="mb-0">{{$posts->title}}</h6>
                                <small class="text-body-secondary">{{$posts->created_at->format('F j, Y')}}</small>
                            </div>
                        </a>
                    </li>
                    @php
                        $counter++;
                        if ($counter >= $maxIterations) {
                            break;
                        }
                    @endphp
                    @endforeach
                </ul>
                </div>
        
                <div class="p-4">
                <h4 class="fst-italic">tutor's contacts</h4>
                <ol class="list-unstyled mb-0">
                    @foreach ($post->user->sosmed as $sosmed )
                        <li>
                            <a class="btn btn-icon" href="{!! $sosmed->link !!}" target="_blank">
                                <div class="row">
                                    <div class="col-4 mt-3">
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
                                    </div>
                                    <div class="col-7">
                                        <span class="link-primary">&nbsp; {{$sosmed->name}}</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ol>
                </div>
        
            </div>
            </div>
        </div>
        
        </main>
@endsection