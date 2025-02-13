@extends('layouts.app', ['page' => __('Change Password'), 'pageSlug' => 'users', 'section' => 'users'])

@section('content')



    <style>

        button, input {
            overflow: visible;
            border: none;
        }
        .red-border {
            color: #495057;
            background-color: #fff;
            border-color: #ff8e9d;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgb(225 0 0 / 100%);
        }
        .fa-eye,.fa-eye-slash{
            position: absolute;
            right: 10px;
            padding: 9px;
            color: #056bcd;
        }
    </style>


    <!--**********************************
            Content body start
        ***********************************-->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <p class="mb-1">Change Password</p>
                    </div>
                </div>
            </div>
        @include('inc._message')
        <!-- row -->
            <div class="limiter">

                <div class="container-login100" style="background-image: url('{{asset('login_theme/images/img-01.jpg')}}');">
                    <div class="wrap-login100 p-t-60 p-b-30">
                        <form class="container mt-4" method="POST" action="{{ route('settings.update', $change_password->id) }}">
                            @csrf
                            @method('PUT')

                            <!-- Old Password -->
                            <div class="form-group position-relative mb-3">
                                <label for="old_password">Old Password</label>
                                <input id="old_password" name="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" required placeholder="Old Password">
                                <div class="position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;" onclick="showPassword()">
                                    <i class="fas fa-eye" id="eye"></i>
                                </div>
                                @error('old_password')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div class="form-group position-relative mb-3">
                                <label for="new_password">New Password</label>
                                <input id="new_password" name="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" required placeholder="New Password">
                                <div class="position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;" onclick="showPassword2()">
                                    <i class="fas fa-eye" id="eye2"></i>
                                </div>
                                @error('new_password')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="form-group position-relative mb-3">
                                <label for="confirm_password">Confirm Password</label>
                                <input id="confirm_password" name="confirm_password" type="password" class="form-control @error('confirm_password') is-invalid @enderror" required placeholder="Confirm Password">
                                <div class="position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;" onclick="showPassword3()">
                                    <i class="fas fa-eye" id="eye3"></i>
                                </div>
                                @error('confirm_password')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>

                            <!-- Error Message -->
                            <div id="message" class="text-danger mb-3" style="display: none;">
                                Passwords do not match
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" onclick="return check()">
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>



            </div>


        </div>
    </div>
    <script>
        var new_password = document.getElementById("new_password");
        var confirm_password = document.getElementById("confirm_password");
        function check() {
            if (new_password.value == confirm_password.value){
               return true;
            }
            $("#confirm_password").addClass("red-border");
            $("#massage").css("display","block");
            return false;
        }
        function showPassword() {
            var x = document.getElementById("old_password");
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
        function showPassword2() {
            var x = document.getElementById("new_password");
            var y = document.getElementById("eye2");
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
        function showPassword3() {
            var x = document.getElementById("confirm_password");
            var y = document.getElementById("eye3");
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
    <!--**********************************
        Content body end
    ***********************************-->
@endsection
@section('script')


@stop
