<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>

    
</head>
<body>
    <div id="app"> 
        @include('component.navbar')

        <main class="">
            <div class="container">
                <div class="mt-3">

                    @if (Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                    @elseif(Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>
                    @endif
                </div>
            </div>
            @yield('content')
        </main>
    </div>
    <!-- Modal Login-->
    <div class="modal fade" id="modalLogin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                {{-- <div class="card"> --}}
                                    <div class="card-header">{{ __('Login') }}</div>
                    
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf
                    
                                            <div class="row mb-3">
                                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                    
                                                <div class="col-md-6">
                                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                    
                                            <div class="row mb-3">
                                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                    
                                                <div class="col-md-6">
                                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                    
                                            <div class="row mb-3">
                                                <div class="col-md-6 offset-md-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    
                                                        <label class="form-check-label" for="remember">
                                                            {{ __('Remember Me') }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                    
                                            <div class="row mb-0">
                                                <div class="col-md-8 offset-md-4">
                                                    <button type="submit" class="btn btn-primary">
                                                        {{ __('Login') }}
                                                    </button>
                    
                                                    @if (Route::has('password.request'))
                                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                                            {{ __('Forgot Your Password?') }}
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @auth
        @if(Auth::user()->role === 'Tutee')
            <div class="fixed-button">
                <div class="btn-group dropup">
                    <button type="button" class="btn btn-primary btn-lg dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="true">
                        <i class="fa fa-plus"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-hover">
                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalJoinTutor">Join Tutoring Session</a></li>
                    </ul>
                </div>
            </div>
        @else
            <div class="fixed-button">
                <div class="btn-group dropup">
                    <button type="button" class="btn btn-primary btn-lg dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="true">
                        <i class="fa fa-plus"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-hover">
                        <li><a class="dropdown-item" href="{{ route('post.create') }}">Create Post</a></li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalCreateTutor" id="mdlSearch">Create Tutoring Session</a></li>
                    </ul>
                </div>
            </div>
        @endif
    @endauth

    <!-- Modal Register-->
    <div class="modal fade" id="modalRegist" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                {{-- <div class="card"> --}}
                                    <div class="card-header">{{ __('Register') }}</div>
                    
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('register') }}">
                                            @csrf
                    
                                            <div class="row mb-3">
                                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Full Name') }}</label>
                    
                                                <div class="col-md-6">
                                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="fullname" value="{{ old('fullname') }}" required autocomplete="fullname" autofocus>
                    
                                                    @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="username" class="col-md-4 col-form-label text-md-end">{{ __('Username') }}</label>
                    
                                                <div class="col-md-6">
                                                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                    
                                                    @error('username')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                    
                                            <div class="row mb-3">
                                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                    
                                                <div class="col-md-6">
                                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                    
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                    
                                            <div class="row mb-3">
                                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                    
                                                <div class="col-md-6">
                                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                    
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                    
                                            <div class="row mb-3">
                                                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>
                    
                                                <div class="col-md-6">
                                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                                </div>
                                            </div>
                    
                                            <div class="row mb-0">
                                                <div class="col-md-6 offset-md-4">
                                                    <button type="submit" class="btn btn-primary">
                                                        {{ __('Register') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Search-->
    <div class="modal fade" id="modalSearch"  aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="true" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-md-12 p-3">
                                <div class="card-header">
                                    <h1 class="text-center">Search Filter</h1>  
                                </div>
                                <div class="card-body">
                                    <form action="{{route('post.search')}}" method="GET">
                                        <div class="row">
                                            <div class="col-6 mt-3">
                                                <select name="bidang"  data-width="100%" id="select2-bidang">
                                                    <option value=""></option>
                                                    <option value="b">Select Bidang</option>
                                                </select>
                                            </div>
                                            <div class="col-6 mt-3">
                                                <select name="category[]" data-width="100%" multiple="multiple" id="select2-category">
                                                    <option value=""></option>
                                                    <option value="a">Select Category</option>
                                                    <option value="b">Select Category</option>
                                                </select>
                                            </div>
                                            <div class="col-12 mt-3">
                                                <input type="text" class="w-100" name="search">
                                            </div>
                                            <div class="col-12 mt-3">
                                                <input type="submit" value="Search" class="btn btn-primary pull-right">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Join Tutor-->
    <div class="modal fade" id="modalJoinTutor"  aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="true" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-md-12 p-3">
                                <div class="card-header">
                                    <h1 class="text-center">Join Tutoring Session</h1>  
                                </div>
                                <div class="card-body">
                                    <form action="{{route('tutor.joinSession')}}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-12 mt-3">
                                                <label for="form-control">Masukan Invitation Code</label>
                                                <input type="text" class="w-100 form-text" name="invite_code" required>
                                            </div>
                                            <div class="col-12 mt-3">
                                                <input type="submit" value="Search" class="btn btn-primary pull-right">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal create tutor sessions-->
    <div class="modal fade" id="modalCreateTutor"  aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="true" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-md-12 p-3">
                                <div class="card-header">
                                    <h1 class="text-center">Create Tutoring Session</h1>  
                                </div>
                                <div class="card-body">
                                    <form action="{{route('tutor.store')}}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-12 mt-3">
                                                <label for="course_id" class="form-group">Search Course</label>
                                                <select name="course_id"  data-width="100%" id="select2-course">
                                                    <option value=""></option>
                                                    <option value="b">Select Bidang</option>
                                                </select>
                                            </div>
                                            
                                            <div class="col-7 mx-auto" id="cardDetailPost" >
                                                <div class="card shadow-sm m-5 ">
                                                    <img src="" id="searchPostImg" class="bd-placeholder-img card-img-top" style="object-fit: cover;" width="100%" height="225" role="img" aria-label="Placeholder: Thumbnail" alt="Post Image">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-10">
                                                                <p class="card-text" id="searchPostTitle"></p>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-12 mt-3 d-flex justify-content-between align-items-center">
                                                                <small class="text-body-secondary badge" id="searchPostCategory"></small>
                                                                <small class="text-body-secondary" id="searchPostDate"></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-12 mt-3">
                                                <input type="submit" value="Create" class="btn btn-primary pull-right">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Function to populate Select2 with categories
            function populateCategories(bidangId = null) {
                $.ajax({
                    url: "{{ route('ajax.get-categories') }}",
                    type: "GET",
                    data: {
                        bidangId: bidangId // Pass selected bidang ID
                    },
                    success: function(data) {
                        // Clear existing options
                        $('#select2-category').empty();

                        // Populate Select2 with new options
                        $.each(data, function(index, option) {
                            $('#select2-category').append('<option value="' + option.id + '">' + option.name + '</option>');
                        });

                        // Reinitialize Select2
                        $('#select2-category').select2({
                            dropdownParent: $("#modalSearch"),
                            placeholder: "Select Categories"
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            function getDetailCourse(courseId = null) {
                $.ajax({
                    url: "{{ route('ajax.getDetailCourse') }}",
                    type: "GET",
                    data: {
                        courseId: courseId 
                    },
                    success: function(data) {
                        if(data && Object.keys(data).length > 0){
                            $('#cardDetailPost').show();
                            $('#searchPostImg').attr('src', data['img_url']);
                            $('#searchPostTitle').text(data['title']);
                            $('#searchPostCategory').text(data['tipe'] + '|' + data['lokasi']);
                            var createdAtDate = new Date(data['created_at']);
    
                            // Format the date to the desired format (d/m/Y)
                            var formattedDate = createdAtDate.toLocaleDateString('en-GB', {
                                day: '2-digit',
                                month: '2-digit',
                                year: 'numeric'
                            });
                            $('#searchPostDate').text(formattedDate);
                        }else{
                            $('#cardDetailPost').hide();
                        }
                        
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            // Function to populate Select2 with bidang
            function populateBidang() {
                $.ajax({
                    url: "{{ route('ajax.get-bidang') }}",
                    type: "GET",
                    success: function(data) {
                        // Clear existing options
                        $('#select2-bidang').empty();

                        // Populate Select2 with new options
                        $.each(data, function(index, option) {
                            $('#select2-bidang').append('<option value="' + option.id + '">' + option.name + '</option>');
                        });

                        // Reinitialize Select2
                        $('#select2-bidang').select2({
                            dropdownParent: $("#modalSearch"),
                            placeholder: "Select Categories"
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            function searchCourse() {
                $.ajax({
                    url: "{{ route('ajax.getCourseUser') }}",
                    type: "GET",
                    success: function(data) {
                        // Clear existing options
                        $('#select2-course').empty();

                        // Populate Select2 with new options
                        $.each(data, function(index, option) {
                            $('#select2-course').append('<option value="' + option.id + '">' + option.title + '</option>');
                        });

                        // Reinitialize Select2
                        $('#select2-course').select2({
                            dropdownParent: $("#modalCreateTutor"),
                            placeholder: "Select Course"
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            // Initialize Select2 for bidang dropdown
            $('#select2-bidang').select2({
                dropdownParent: $("#modalSearch"),
                placeholder: "Select Bidang"
                
            });
            
            // Initialize Select2 for course dropdown
            $('#select2-course').select2({
                dropdownParent: $("#modalCreateTutor"),
                placeholder: "Select Course"
                
            });

            // Initialize Select2 for categories dropdown
            $('#select2-category').select2({
                dropdownParent: $("#modalSearch"),
                placeholder: "Select Categories",
            });

            // Event listener for change in bidang dropdown
            $('#select2-bidang').on('change', function() {
                var selectedBidangId = $(this).val();
                populateCategories(selectedBidangId);
            });

            $('#select2-course').on('change', function() {
                var selectedCourseId = $(this).val();
                getDetailCourse(selectedCourseId);
            });

            $('#mdlSearch').on('click', function() {
                searchCourse();
                $('#cardDetailPost').hide();
            });

            // Populate bidang and categories initially
            populateBidang();
            populateCategories();
        });
    </script>
    @stack('addon-script')
</body>
</html>
