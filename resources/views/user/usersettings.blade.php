@include('layouts.app')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
{{-- <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css"> --}}


<body>


    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <div class="well profile">
                    <img class="user img-circle pull-left" height="54" src="https://bootdey.com/img/Content/user_1.jpg"
                        alt="">
                    <h3 class="name">{{ $user->username }}</h3>
                    <p class="text-muted">{{ $user->email }}</p>
                    <hr>
                    <form action="{{ route('users.update', ['username' => auth()->user()->username]) }}" method="POST"
                        class="form-horizontal">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            {{-- Tampilkan error password salah --}}
                            @if ($errors->has('current_password'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('current_password') }}
                                </div>
                            @endif

                            {{-- Tampilkan error password dan konfirmasi tidak sama --}}
                            @if ($errors->has('password'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif

                            <label for="username" class="control-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username"
                                value="{{ auth()->user()->username }}" required>
                        </div>
                        <div class="form-group" style="display: none;visibility: hidden;">
                            <label for="email" class="control-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ auth()->user()->email }}" required>
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation" class="control-label">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

<style>
    .breadcrumb {
        background: none;
        padding: 0;
        margin-bottom: 20px;
    }

    .profile {
        background: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .profile img.user {
        margin-right: 20px;
    }

    .profile h3.name {
        /* margin-top: 0; */
        margin-bottom: 5px;
    }

    .profile p.text-muted {
        margin-bottom: 15px;
        color: #6c757d;
    }

    .form-control {
        margin-bottom: 15px;
        border-radius: 4px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
</style>
