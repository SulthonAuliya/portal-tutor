<div class="header-area">
    <div class="main-header">
        <div class="header-bottom  header-sticky">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <!-- Logo -->
                    <div class="col-xl-2 col-lg-2">
                        <div class="logo">
                            <a href="{{ route('default') }}">PortalTutor</a>
                        </div>
                    </div>
                    <div class="col-xl-10 col-lg-10">
                        <div class="menu-wrapper d-flex align-items-center justify-content-end">
                            <!-- Main-menu -->
                            <div class="main-menu d-none d-lg-block">
                                <nav>
                                    <ul id="navigation">                                                                                          
                                        <li class="active"><a href="{{ route('beranda') }}">Beranda</a></li>
                                        <li>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalSearch">Search</a>
                                        </li>
                                        <!-- Notification Dropdown -->
                                        @auth
                                            <li class="nav-item dropdown notification-dropdown">
                                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" id="notification-dropdown-link">
                                                    <i class="fa fa-bell"></i>
                                                    <span class="bg-danger rounded px-3 text-light" id="notification-count">0</span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-start pb-4" style="min-width: 300px; max-height: 500px; overflow-y: auto; overflow-x: hidden" aria-labelledby="navbarDropdown">
                                                    <div class="row p-2">
                                                        <div class="col-5">
                                                            <h6 class="">Notifications</h6>
                                                        </div>
                                                        <div class="col-7">
                                                            <a href="{{route('listNotif')}}" class="text-end normal-href">Show All Notifications</a>
                                                        </div>
                                                    </div>
                                                    <ul id="notification-list" class="list-group">
                                                        <!-- Notifications will be appended here -->
                                                    </ul>
                                                </div>
                                            </li>
                                        @endauth
                                        <!-- Button -->
                                        @guest
                                            <li class="button-header d-none d-lg-inline-block">
                                                <a href="#" class="btn btns btn3" data-bs-toggle="modal" data-bs-target="#modalLogin">Login</a>
                                            </li>
                                            <li class="button-header d-none d-lg-inline-block">
                                                <a href="#" class="btn btns btn3" data-bs-toggle="modal" data-bs-target="#modalRegist">Sign Up</a>
                                            </li>
                                            <li class="button-header d-lg-none">
                                                <a href="{{route('login')}}" class="btn btns btn3" >Login</a>
                                            </li>
                                            <li class="button-header d-lg-none">
                                                <a href="{{route('register')}}" class="btn btns btn3" >Sign Up</a>
                                            </li>
                                        @else
                                            <li class="active"><a href="{{ route('tutor.manage') }}">Tutor Session</a></li>
                                            <li>
                                                <a href="#">{{ Auth::user()->username }}</a>
                                                <ul class="submenu">
                                                    <li>
                                                        <a class="" href="{{ route('profile.index', Auth::user()->id) }}">
                                                            Profile
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="" href="{{ route('profile.editPreferences', Auth::user()->id) }}">
                                                            Preference
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="" href="{{ route('profile.edit', Auth::user()->id) }}">
                                                            Edit Profile
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="" href="{{ route('logout') }}"
                                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                           {{ __('Logout') }}
                                                        </a>
                                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                            @csrf
                                                        </form>
                                                    </li>
                                                </ul>
                                            </li>
                                        @endguest
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div> 
                    <!-- Mobile Menu -->
                    <div class="col-12">
                        <div class="mobile_menu d-block d-lg-none"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
