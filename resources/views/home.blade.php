@extends('layouts.app')

@section('content')
<div class="container-jumbotron">
    <div class="container">
        <div class="jumbotron py-2 pb-5">
            <div class="row my-2 mb-5">
                <div class="col-6 d-flex">
                    <div class="text justify-content-center align-self-center">
                        <h1>Learn From Anyone, Anywhere, Anytime</h1>
                        <p>PortalTutor menyediakan informasi tutor disekitar anda untuk membantu anda dalam mencari mentor yang tepat.</p>
                    </div>
                </div>
                <div class="col-6">
                    <img class="img-fluid" src="{{ asset('storage/image/tutor-img.png') }}" alt="tutor-illustration">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-search py-5">
    <div class="container py-2">
        <div class="row">
            <div class="col-12">
                <div class="title">
                    <h1 class="text-center"><b> What Are You Waiting For? </b></h1>
                </div>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <img class="img-fluid " src="{{ asset('storage/image/search.svg') }}" alt="tutor-search" style="width:25vw">
            </div>
            <div class="col-12 d-flex justify-content-center mt-3">
                <button class="btn btn-primary p-4 fw-4" style="colos:#fff">Lets Begin!</button>
            </div>
        </div>

    </div>
</div>
@endsection
