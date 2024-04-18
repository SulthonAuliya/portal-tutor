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
                                        <!-- Button -->
                                        @guest
                                            <li class="button-header d-none d-lg-inline-block">
                                                <a href="#" class="btn btns btn3" data-bs-toggle="modal" data-bs-target="#modalLogin">Login</a>
                                            </li>
                                            <li class="button-header d-none d-lg-inline-block">
                                                <a href="#" class="btn btns btn3" data-bs-toggle="modal" data-bs-target="#modalRegist">Sign Up</a>
                                            </li>
                                            <li class="button-header d-lg-none"><a href="{{ route('register') }}" class="btn btns btn3">Sign Up</a></li>
                                            <li class="button-header d-lg-none"><a href="{{ route('login') }}" class="btn btns btn3">Log in</a></li>
                                        @else
                                        <li>
                                            <a href="#">{{ Auth::user()->username }}</a>
                                            <ul class="submenu">
                                                <li>
                                                    <a class="" href="{{ route('profile.index', Auth::user()->id) }}">
                                                        Profile
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="" href="{{ route('profile.edit', Auth::user()->id) }}">
                                                        Edit Profile
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="" href="{{ route('profile.editPreferences', Auth::user()->id) }}">
                                                        Preferences
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="" href="{{ route('logout') }}"
                                                    onclick="event.preventDefault();
                                                                    document.getElementById('logout-form').submit();">
                                                        {{ __('Logout') }}
                                                    </a>

                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                        @csrf
                                                    </form>
                                                </li>
                                            </ul>
                                        </li>
                                            {{-- <li class="nav-item dropdown">
                                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                    {{ Auth::user()->name }}
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                                    onclick="event.preventDefault();
                                                                    document.getElementById('logout-form').submit();">
                                                        {{ __('Logout') }}
                                                    </a>

                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                        @csrf
                                                    </form>
                                                </div>
                                            </li> --}}
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