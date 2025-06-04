@extends('layouts.auth-master')

@section('content')
<body>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
<title>Login Page</title>
    <div class="auth-container">
        <!-- Background Illustrations -->
        <div class="illustration-bg">
            <div class="illustration-item dots-1"></div>
            <div class="illustration-item dots-2"></div>
            <div class="illustration-item line-1"></div>
            <div class="illustration-item line-2"></div>
            <div class="illustration-item wave wave-1"></div>
            <div class="illustration-item wave wave-2"></div>
        </div>

        <div class="login-card shadow-sm">
            <div class="auth-header">
                <h2 class="auth-title">Login</h2>
                <p class="auth-subtitle">Hey, Enter your details to get sign in to your account</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    {{-- Cek jika error login gagal --}}
                    @if (
                        $errors->first() === 'These credentials do not match our records.' ||
                        $errors->first() === 'auth.failed'
                    )
                        Akun atau password salah.
                    @else
                        {{ $errors->first() }}
                    @endif
                </div>
            @endif

            <form method="post" action="{{ route('login.perform') }}">
                @csrf

                <div class="form-group">
                    <input type="text" id="username" class="form-control" name="username"
                        value="{{ old('username') }}" placeholder="Enter Email / Phone No" required autofocus>
                    @if ($errors->has('username'))
                        <span class="text-danger text-left">{{ $errors->first('username') }}</span>
                    @endif
                </div>

                <div class="form-group password-field-container">
                    <input id="password-field" type="password" class="form-control" name="password"
                        placeholder="Passcode" required>
                    <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    @if ($errors->has('password'))
                        <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                    @endif
                </div>


                <div class="form-group">
                    <button type="submit" class="btn btn-primary w-100">
                        Sign in
                    </button>
                </div>
            </form>



            <div class="auth-footer">
                Don't have an account? <a href="{{ route('register.perform') }}">Request Now</a>
            </div>
        </div>
    </div>
</body>

@endsection

@section('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
