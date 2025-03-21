@extends("layouts.auth-master")

@section("content")
    <style>
        input {
            margin-top: 10px;
            margin-bottom: 10px;
        }
    </style>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    <h2 class="heading-section">Login</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">
                    <div class="wrap">
                        <div class="img" style="background-image: url('{{ asset("images/bg-1.jpg") }}');"></div>
                        <div class="login-wrap p-4 p-md-5">
                            <div class="d-flex">
                                <div class="w-100">
                                    <p class="social-media d-flex justify-content-end">
                                        <a href="#"
                                            class="social-icon d-flex align-items-center justify-content-center"><span
                                                class="fa fa-facebook"></span></a>
                                        <a href="#"
                                            class="social-icon d-flex align-items-center justify-content-center"><span
                                                class="fa fa-twitter"></span></a>
                                    </p>
                                </div>
                            </div>
                            <form method="post" action="{{ route("login.perform") }}" class="signin-form">
                                @csrf
                                <div class="form-group mt-3">
                                    <input type="text" class="form-control" name="username" value="{{ old("username") }}"
                                        placeholder="Username" required="required" autofocus>

                                    @if ($errors->has("username"))
                                        <span class="text-danger text-left">{{ $errors->first("username") }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input id="password-field" type="password" class="form-control" name="password"
                                        value="{{ old("password") }}" placeholder="Password" required="required">

                                    <span toggle="#password-field"
                                        class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                    @if ($errors->has("password"))
                                        <span class="text-danger text-left">{{ $errors->first("password") }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="form-control btn btn-primary rounded submit px-3">Sign
                                        In</button>
                                </div>
                                <div class="form-group d-md-flex">
                                    <div class="w-50 text-left">
                                        <label class="checkbox-wrap checkbox-primary mb-0">Remember Me
                                            <input type="checkbox" name="remember" checked>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="w-50 text-md-right">
                                        <a href="#">Forgot Password</a>
                                    </div>
                                </div>
                            </form>
                            <p class="text-center">Not a member? <a href="{{ route("register.perform") }}">Sign Up</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section("scripts")
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
