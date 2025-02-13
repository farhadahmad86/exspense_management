@extends('layouts.app', ['page' => __('Roles List'), 'pageSlug' => 'users', 'section' => 'users'])

@section('content')

    <style>
        .col-lg-4,
        .col-lg-8 {
            margin-bottom: 20px;
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
                        <p class="mb-1">Cash Payment Voucher</p>
                    </div>
                </div>
            </div>
            @include('inc._message')
            <!-- row -->
            <div class="alert alert-danger " style="display: none" id="alert">
                <a href="#" class="close" aria-label="close"
                    onclick="document.getElementById('alert').style.display = 'none';">&times;</a>
                <p style="margin: auto;width: 50%;"><strong>Danger!</strong> Do not have enough cash in Account</p>
            </div>


            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Form Cash Payment Voucher</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-validation">
                                <form class="form-valide" type="submit" id="form"
                                    action="{{ route('cash_payment_voucher.store') }}" method="post"
                                    onsubmit="return maincheckForm()">
                                    @csrf
                                    <div class="row">

                                        <div class="col-xl-6">
                                            <div class="form-group row">

                                                <label class="col-lg-4 col-form-label" for="cash_account">Cash Account
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-lg-8">
                                                    <select id="cash_account" name="cash_account" tabindex="1">
                                                        <option value="" selected disabled>Select</option>
                                                        @foreach ($cash as $account)
                                                            <option value="{{ $account->ca_id }}" data-balance="{{$account->ca_balance}}">
                                                                {{ $account->ca_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>


                                                <label class="col-lg-4 col-form-label" for="received_by">Deliver To
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="received_by"
                                                        name="received_by" placeholder="Enter Cash Deliver To.."
                                                        onkeypress="return lettersOnly(event)" tabindex="2">
                                                </div>

                                                <label hidden class="col-lg-4 col-form-label" for="Account_Total">Account
                                                    Total
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div hidden class="col-lg-8">
                                                    <input readonly type="text" class="form-control" id="account_total"
                                                        name="account_total" placeholder="Account Total">
                                                </div>


                                                {{--                                                <label hidden class="col-lg-2 col-form-label" for="job_number">Job Number --}}
                                                {{--                                                    <span class="text-danger">*</span> --}}
                                                {{--                                                </label> --}}
                                                {{--                                                <div hidden class="col-lg-2"> --}}
                                                {{--                                                    <select id="job_number" name="job_number"> --}}
                                                {{--                                                        <option value="" selected disabled>Select</option> --}}
                                                {{--                                                        <option value="AL">Alabama</option> --}}
                                                {{--                                                        <option value="WY">Wyoming</option> --}}
                                                {{--                                                    </select> --}}
                                                {{--                                                </div> --}}




                                                {{--                                            <div class="form-group row"> --}}
                                                <input type="hidden" name="inv_id" value="{{ $count }}">
                                                <label class="col-lg-4 col-form-label" for="amount">Amount
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="amount" name="amount"
                                                        placeholder="Enter Amount.." tabindex="3"
                                                        onkeypress="return numbersOnly(event)">
                                                </div>
                                                <label class="col-lg-4 col-form-label" for="remarks">Remarks <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <div class="col-lg-8">
                                                    <textarea class="form-control" id="remarks" name="remarks" rows="2" placeholder="Remarks" tabindex="4"></textarea>
                                                </div>
                                                {{--                                            </div> --}}


                                                <div class="form-group row">
                                                    <div class="col-lg-8 ml-auto">
                                                        <button type="submit" class="btn btn-primary"
                                                            tabindex="5">Save</button>
                                                    </div>
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

            var total = $('#account_total').val();
            var amounti = $('#amount').val();

            if (parseFloat(total) < parseFloat(amounti)) {
                // alert("Do not have enough cash in Account");
                document.getElementById("alert").style.display = "block";
                return false;
            } else {

                let cash_account = document.getElementById("cash_account"),
                    received_by = document.getElementById("received_by"),
                    amount = document.getElementById("amount"),
                    remarks = document.getElementById("remarks"),
                    validateInputIdArray = [
                        cash_account.id,
                        received_by.id,
                        amount.id,
                        remarks.id,
                    ];

                if (cash_account.value == 0) {
                    cash_account.nextSibling.childNodes[0].childNodes[0].style.border = "1px solid red"
                    return false;
                } else {
                    cash_account.nextSibling.childNodes[0].childNodes[0].style.border = ""
                }
                if (parseFloat(amount.value) > parseFloat(document.getElementById("account_total").value)) {
                    document.getElementById("alert").style.display = "block";
                    return false;
                }

                // return validateInventoryInputs(validateInputIdArray);

                var ok = validateInventoryInputs(validateInputIdArray);

                if (ok) {
                    if (counter == 0) {
                        $("#complain").addClass('bg-danger');
                        return false;
                    } else if (counter2 == 0) {
                        $("#accessories").addClass('bg-danger');
                        return false;
                    } else {
                        return true;
                    }
                } else {
                    return false;
                }




            }


        }



        $(document).ready(function() {

            // $("#job_re_open").select2();
            $("#cash_account").select2();
            $(".select2-selection--single").focus();
            $("#job_number").select2();

            $('#form').validate({ // initialize the plugin

                rules: {
                    cash_account: {
                        // required: true,
                    },
                    received_by: {
                        // required: true,
                        pattern: /^[A-Za-z0-9. ]{3,30}$/
                    },
                    job_number: {
                        // required: true,
                    },
                    amount: {
                        // required: true,
                    },
                    remarks: {
                        // required: true,
                    }
                },
                messages: {
                    cash_account: {
                        // required: "Required",
                    },
                    received_by: {
                        // required: "Required",
                    },
                    job_number: {
                        // required: "Required",
                    },
                    amount: {
                        // required: "Required",
                    }


                },

                ignore: [],
                errorClass: "invalid-feedback animated fadeInUp",
                errorElement: "div",
                errorPlacement: function(e, a) {
                    jQuery(a).parents(".form-group > div").append(e)
                },
                highlight: function(e) {
                    jQuery(e).closest(".form-group").removeClass("is-invalid").addClass("is-invalid")
                },
                success: function(e) {
                    jQuery(e).closest(".form-group").removeClass("is-invalid"), jQuery(e).remove()
                },

            });

        });
        $("#cash_account").change(function () {
            var rate = jQuery('option:selected', this).attr('data-balance');
            $('#account_total').val(`${rate}`);
        });
    </script>
@stop
