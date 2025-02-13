@extends('layouts.app', ['page' => __('User Management'), 'pageSlug' => 'users', 'section' => 'users'])

@section('content')

    <!--**********************************
            Content body start
        ***********************************-->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Hi, welcome back!</h4>
                        <p class="mb-1">Edit Cash Account</p>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Registration</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Cash Account</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Cash Account</a></li>
                    </ol>
                </div>
            </div>
        @include('inc._message')
        <!-- row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Form Cash Account</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-validation">
                                <form class="form-valide" id="form" action="{{route('cash_account.update',$cash_account->ca_id)}}" method="post">
                                    @csrf
                                    @method("PUT")
                                    <div class="row">

                                        <div class="col-xl-8">



                                            <div class="form-group row">

                                                <label class="col-lg-4 col-form-label" for="cash_account">Cash Account Name
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control" id="cash_account"
                                                           name="cash_account" placeholder="Enter Account.." value="{{$cash_account->ca_name}}">
                                                </div>

                                            </div>
                                            <div class="form-group row">

                                                <label class="col-lg-4  col-form-label" for="opening_balance">Opening Balance
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control" id="opening_balance" onkeypress="return numbersOnly(event)"
                                                           name="opening_balance" placeholder="Enter Amount.." value="{{$cash_account->ca_balance}}">
                                                </div>

                                            </div>


                                            <div class="form-group row">
                                                <div class="col-lg-8 ml-auto">
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--**********************************
        Content body end
    ***********************************-->
@endsection
@section('script')


    <script>
        $(document).ready(function () {

            // $("#job_re_open").select2();

            $('#form').validate({ // initialize the plugin

                rules: {
                    cash_account: {
                        required: true,
                        pattern: /^[A-Za-z0-9. ]{3,30}$/
                    },
                    opening_balance: {
                        required: true,
                    }

                },
                messages: {
                    cash_account: {
                        required: "Required"
                    },
                    opening_balance: {
                        required: "Required"
                    }
                },

                ignore: [],
                errorClass: "invalid-feedback animated fadeInUp",
                errorElement: "div",
                errorPlacement: function (e, a) {
                    jQuery(a).parents(".form-group > div").append(e)
                },
                highlight: function (e) {
                    jQuery(e).closest(".form-group").removeClass("is-invalid").addClass("is-invalid")
                },
                success: function (e) {
                    jQuery(e).closest(".form-group").removeClass("is-invalid"), jQuery(e).remove()
                },

            });

        });
    </script>
@stop
