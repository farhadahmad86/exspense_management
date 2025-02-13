@extends('layouts.app', ['page' => '', 'section' => 'auth'])
<style>
     #eye{
         position: absolute;
         /* display: contents; */
         margin-left: 282px;
         margin-top: 12px;
         font-size: 16px;
     }
     @media (max-width: 991px) {
         #eye{
             margin-left: 312px
         }
     }
</style>
@section('content')
    <div class="col-lg-4 col-md-6 ml-auto mr-auto">
        <form class="form" method="post" action="{{ route('login') }}">
            @csrf
            <div class="card card-login card-white">
                <div class="card-header">
                    <img src="{{ asset('public/assets') }}/img/card-primary.png" alt="">
                    <h1 class="card-title">Login</h1>
                </div>
                @include('inc._message')
                <div class="card-body">
                    <div class="input-group{{ $errors->has('username') ? ' has-danger' : '' }}">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        <input type="text" name="username" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" placeholder="Username">
                        @include('alerts.feedback', ['field' => 'username'])
                    </div>
                    <div class="input-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </div>
                        </div>
                        <input type="password" placeholder="Password" name="password" id="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}">
                        <i class="fas fa-eye" onclick="showPassword()" id="eye"></i>
                        @include('alerts.feedback', ['field' => 'password'])
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-lg btn-block mb-3">Log in</button>
                    {{-- <div class="pull-left">
                        <h6>
                            <a href="{{ route('register') }}" class="link footer-link">Create Account</a>
                        </h6>
                    </div> --}}
                    {{-- <div class="pull-right">
                        <h6>
                            <a href="{{ route('password.request') }}" class="link footer-link">I forgot the password</a>
                        </h6>
                    </div> --}}
                </div>
            </div>
        </form>
    </div>
    <script>
        function showPassword() {
            var x = document.getElementById("password");
            var y = document.getElementById("eye");
            if (x.type == "password") {
                y.classList.add("fa-eye-slash");
                y.classList.remove("fa-eye");
                x.type = "text";
            } else {
                y.classList.add("fa-eye");
                y.classList.remove("fa-eye-slash");
                x.type = "password";
            }
        }
    </script>
@endsection
