@extends('layouts.auth-master')

@section('content')
    <style>
        input {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .login-image {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: #fff;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
        }

        .brand-logo {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }
    </style>

    <body style="background-color: #eee">
        <div class="container d-flex justify-content-center align-items-center min-vh-100">
            <div class="row justify-content-center w-100">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card rounded-3 text-black w-100">
                        <div class="row g-0 justify-content-center">
                            <!-- Login Form -->
                            <div class="col-lg-12">
                                <div class="card-body p-md-5 mx-md-3 text-center">

                                    <form method="post" action="{{ route('login.perform') }}">
                                        @csrf
                                        <h3>Login</h3>

                                        <div class="form-outline mb-4">
                                            <br>
                                            <input type="text" id="username" class="form-control" name="username"
                                                value="{{ old('username') }}" placeholder="Username" required autofocus>

                                            @if ($errors->has('username'))
                                                <span class="text-danger text-left">{{ $errors->first('username') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-outline mb-4">
                                            <br>
                                            <input id="password-field" type="password" class="form-control" name="password"
                                                placeholder="Password" required>

                                            <span toggle="#password-field"
                                                class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                            @if ($errors->has('password'))
                                                <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                                            @endif
                                        </div>

                                        <div class="text-center pt-1 mb-5 pb-1" style="list-style: none;">
                                            <li>
                                                <button type="submit" class="btn btn-primary btn-block fa-lg mb-3">
                                                    Login
                                                </button>
                                            </li>
                                            <a class="text-muted" href="#">Forgot password?</a>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-center pb-4">
                                            <p class="mb-0 me-2">Don't have an account?</p>
                                            <a href="{{ route('register.perform') }}" class="btn btn-outline-danger">Create
                                                new</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </body>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.toggle-password').click(function() {
                $(this).toggleClass('fa-eye fa-eye-slash');
                var input = $($(this).attr('toggle'));
                if (input.attr('type') == 'password') {
                    input.attr('type', 'text');
                } else {
                    input.attr('type', 'password');
                }
            });
        });
    </script>
@endsection
