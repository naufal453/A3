<link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
<nav class="navbar bg-body-tertiary navbar-expand-lg fixed-top shadow-sm p-3 mb-5" style="z-index: 1000;"
    style="background-color: #6A9C89 !important; border-radius: 0px !important;">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand d-flex align-items-center text-white" href="/">
            <img src="{{ asset('icon/book.png') }}" alt="Logo" class="brand-logo">
            <span class="logo-text ms-2">
                Alternate<br>
                Arc<br>
                Archive
            </span>
        </a>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <!-- Toggler/collapsible Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar content -->


        <div class="collapse navbar-collapse" id="navbarContent">
            <!-- Search Form (only on index.blade.php) -->
            @if (Route::is('home.index'))
                <form id="search" class="d-flex me-auto mb-2 mb-lg-0" role="search"
                    action="{{ route('search.results') }}" method="GET">
                    <input class="form-control me-2" type="search" name="query"
                        style="background-color:#FFF5E4 !important;color:#6A9C89 !important;" placeholder="Search"
                        aria-label="Search" value="{{ request('query') }}">
                    {{-- <button class="btn btn-outline-dark" type="submit">Search</button> --}}
                </form>
            @endif

            <!-- Authenticated User Section -->
            @auth
                <div class="d-flex align-items-center ms-auto"> <!-- Add ms-auto to align to the right -->
                    <!-- Add Post Button -->
                    @if (Route::is('user.show') && isset($user) && auth()->id() === $user->id)
                        <button id="createstory"
                            class="btn btn-primary btn-sm me-2 d-flex align-items-center create-story-btn" type="button"
                            data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-plus-circle me-1" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                <path
                                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                            </svg>
                            <span>Create Story</span>
                        </button>
                    @endif

                    <!-- User Dropdown -->
                    <div class="btn-group user-dropdown ms-auto" role="group">
                        <!-- Dropdown Button -->
                        <button class="btn btn-outline-dark btn-sm dropdown-toggle d-flex align-items-center" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                class="bi bi-person-square me-2" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                <path
                                    d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z" />
                            </svg>
                            <span style="font-size: 15px" class="username">{{ auth()->user()->username }}</span>
                        </button>

                        <!-- Dropdown Menu -->
                        <ul class="dropdown-menu dropdown-menu-end shadow" style="min-width: 125px;">
                            <li>
                                <a style="font-size: 15px" class="dropdown-item"
                                    href="{{ route('user.show', ['username' => auth()->user()->username]) }}">
                                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                                </a>
                            </li>
                            <li>
                                <a style="font-size: 15px" class="dropdown-item" href="{{ route('posts.saved') }}">
                                    <i class="bi bi-bookmark me-2"></i> Saved
                                </a>
                            </li>
                            <li>
                                <a style="font-size: 15px" class="dropdown-item" href="{{ route('posts.archived') }}">
                                    <i class="bi bi-archive me-2"></i> Archived
                                </a>
                            </li>
                            <li>
                                <a style="font-size: 15px" class="dropdown-item"
                                    href="{{ route('user.usersettings', ['username' => auth()->user()->username]) }}">
                                    <i class="bi bi-gear me-2"></i> Settings
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a style="font-size: 15px" href="{{ route('logout.perform') }}"
                                    class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            @endauth

            <!-- Guest Section -->
            @guest
                <div class="text-end ms-auto"> <!-- Add ms-auto to align to the right -->
                    <a href="{{ route('login.perform') }}" class="btn btn-primary me-2">Login</a>
                    <a href="{{ route('register.perform') }}" class="btn btn-primary">Sign-up</a>
                </div>
            @endguest
        </div>
    </div>
</nav>
@include('home.post.add')
