<link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
<nav class="navbar bg-body-tertiary navbar-expand-lg fixed-top" style="background-color: #FFA725 !important;">
    <div class="container-fluid">
        <!-- Brand -->
        <a href="/" class="navbar-brand text-dark">Alternate Arc Archive</a>

        <!-- Toggler/collapsible Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar content -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <!-- Search Form -->
            <form id="search" class="d-flex me-auto mb-2 mb-lg-0" role="search">
                <input class="form-control me-2" type="search"
                    style="background-color:#FFF5E4 !important;color:#6A9C89 !important;" placeholder="Search"
                    aria-label="Search">
            </form>

            <!-- Authenticated User Section -->
            @auth
                <div class="d-flex align-items-center">
                    <!-- Add Post Button -->
                    <button class="btn btn-outline-dark btn-sm me-2 d-flex align-items-center" type="button"
                        data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-plus-circle me-1" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                            <path
                                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                        </svg>
                        Create Story
                    </button>

                    <!-- User Dropdown -->
                    <div class="btn-group" role="group">
                        <button class="btn btn-outline-dark btn-sm dropdown-toggle d-flex align-items-center" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                class="bi bi-person-square me-1" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                <path
                                    d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z" />
                            </svg>
                            <span>{{ auth()->user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('user.show', ['id' => auth()->user()->id]) }}">My
                                    Profile</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a href="{{ route('logout.perform') }}" class="dropdown-item">Logout</a></li>
                        </ul>
                    </div>
                </div>
            @endauth

            <!-- Guest Section -->
            @guest
                <div class="text-end">
                    <a href="{{ route('login.perform') }}" class="btn btn-outline-dark me-2">Login</a>
                    <a href="{{ route('register.perform') }}" class="btn btn-primary">Sign-up</a>
                </div>
            @endguest
        </div>
    </div>
</nav>
@include('home.post.add')
