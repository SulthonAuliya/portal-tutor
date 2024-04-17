@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h1 class="text-center mt-5">Search</h1>
        <div class="album py-5 bg-body-tertiary my-3">
            <div class="container">
                @if (Request::get('tipe') != 'posts')
                    <div class="row">
                        <div class="col-6">
                            <h3>Profiles </h3>
                        </div>
                        @if (Request::get('tipe') != 'profiles')
                            <div class="col-6 text-end">
                                <a href="" class="search-link profile-link">
                                    <h3>Show More <i class="fa fa-chevron-right"></i></h3>
                                </a>
                            </div>
                        @endif
                    </div>
                    <hr>
                    @if (count($users) > 0)
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 mb-5">
                            @foreach ($users as $user)
                                <div class="col-3 mb-3">
                                    <div class="card shadow-sm text-center p-5">
                                        <img src="{!! $user->profile_pic !!}" class="rounded-circle profile-pic mx-auto" alt="Avatar" />
                                        <h1 class="fw-light mt-5">{!! $user->username !!}</h1>
                                        <h5 class="fw-light">{!! $user->full_name !!}</h5>
                                        <a href="{{route("profile.index", ["user" => $user->id])}}" class="btn btn-sm btn-outline-secondary mt-2">See Profile</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="col-12 text-center mt-5">
                            <h3>No profiles found!</h3>
                        </div>
                    @endif
                @endif
                @if (Request::get('tipe') != 'profiles')
                    
                    <div class="row mt-5">
                        <div class="col-6">
                            <h3>Post's </h3>
                        </div>
                        @if (Request::get('tipe') != 'posts')
                            <div class="col-6 text-end">
                                <a href="" class="search-link post-link">
                                    <h3>Show More <i class="fa fa-chevron-right"></i></h3>
                                </a>
                            </div>
                        @endif
                    </div>
                    <hr>
                    @if (count($posts) > 0)
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
                    @else
                        <div class="col-12 text-center mt-5">
                            <h3>No posts found!</h3>
                        </div>
                    @endif
                @endif
            </div>
          </div>
    </div>
@endsection
@push('addon-script')
<script>
    $(document).ready(function() {
        // Get the current URL
        var currentUrl = window.location.href;
    
        // Add the 'tipe=profiles' parameter to the URL
        var newUrlProfile = currentUrl + (currentUrl.indexOf('?') !== -1 ? '&' : '?') + 'tipe=profiles';
        var newUrlPost = currentUrl + (currentUrl.indexOf('?') !== -1 ? '&' : '?') + 'tipe=posts';
    
        // Update the href attribute of the profile-link
        $('.profile-link').attr('href', newUrlProfile);
        $('.post-link').attr('href', newUrlPost);
    });
</script>
@endpush
    