
@extends('layouts.app', ['page' => __('Cash Account'), 'pageSlug' => 'users', 'section' => 'users'])

@section('content')
    <!--**********************************
            Content body start
        ***********************************-->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <p class="mb-1">Cash Account</p>
                    </div>
                </div>
            </div>
        @include('inc._message')
        <!-- row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Cash Account</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-validation">
                                <form class="form-valide" id="form" action="{{route('cash_account.store')}}" method="post" onsubmit="return maincheckForm()">
                                    @csrf
                                    <div class="row">

                                        <div class="col-xl-8">



                                            <div class="form-group row">

                                                <label class="col-lg-4 col-form-label" for="cash_account">Cash Account Name
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control" id="cash_account"
                                                           name="cash_account" placeholder="Enter Account.." autofocus>
                                                </div>

                                            </div>
                                            <div class="form-group row">

                                                <label class="col-lg-4  col-form-label" for="opening_balance">Opening Balance
                                                   <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control" id="opening_balance"
                                                           name="opening_balance" placeholder="Enter Amount.." onkeypress="return numbersOnly(event)">
                                                </div>

                                            </div>


                                            <div class="form-group row">
                                                <div class="col-lg-8 ml-auto">
                                                    <button type="submit" class="btn btn-primary">Save</button>
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
         function maincheckForm() {
                    let cash_account = document.getElementById("cash_account"),
                    opening_balance = document.getElementById("opening_balance"),
                    validateInputIdArray = [
                        cash_account.id,
                        opening_balance.id
                        ];

                    // return validateInventoryInputs(validateInputIdArray);

                    var ok = validateInventoryInputs(validateInputIdArray);

                    if(ok){
                        if(counter == 0){
                            $("#complain").addClass('bg-danger');
                            return false;
                        }
                        else if(counter2 == 0){
                            $("#accessories").addClass('bg-danger');
                            return false;
                        }else{
                            return true;
                        }
                    }
                    else{
                        return false;
                    }
        }

        $(document).ready(function () {

            // $("#job_re_open").select2();

            $('#form').validate({ // initialize the plugin

                rules: {
                    cash_account: {
                        // required: true,
                        // pattern: /^[A-Za-z0-9. ]{3,30}$/
                    },
                    opening_balance: {
                        // required: true,
                    }

                },
                messages: {
                    cash_account: {
                        // required: "Required"
                    },
                    opening_balance: {
                        // required: "Required"
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
