@extends('layouts.app', ['page' => __('Add Company'), 'pageSlug' => 'users', 'section' => 'users'])

@section('content')

    <!--**********************************
                        Content body start
                    ***********************************-->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <p class="mb-1">Add Company</p>
                    </div>
                </div>
            </div>
            @include('inc._message')
            <!-- row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Add Company</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-validation">
                                <form class="form-valide" id="form" action="{{ route('store_company') }}"
                                    method="post" onsubmit="return maincheckForm()">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="form-group row">
                                                <div class="col-md-3">
                                                    <label class="col-form-label col-form-label-sm" for="company_name">Company
                                                        Name<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="company_name" name="company_name" placeholder="Enter a company Name..">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="col-form-label col-form-label-sm" for="number">Company
                                                        Contact<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="number" name="number" placeholder="Enter a Number.."
                                                        onkeypress="return numberFormatter(event)">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-8 ml-auto">
                                                <button type="submit" class="btn btn-primary">Save</button>
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
            let company_name = document.getElementById("company_name"),
                number = document.getElementById("number"),
                validateInputIdArray = [
                    company_name.id,
                    number.id
                ];

            // if (select_job.value == 0) {
            //     select_job.nextSibling.childNodes[0].childNodes[0].style.border = "1px solid red"
            //     return false;
            // } else {
            //     select_job.nextSibling.childNodes[0].childNodes[0].style.border = ""
            // }
            // if (select_reason.value == 0) {
            //     select_reason.nextSibling.childNodes[0].childNodes[0].style.border = "1px solid red"
            //     return false;
            // }
            // else{
            //     select_reason.nextSibling.childNodes[0].childNodes[0].style.border = ""
            // }

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
        $(document).ready(function() {

            // $("#job_re_open").select2();
            $("#select_job").select2();
            $(".select2-selection--single").focus();
            // $("#select_reason").select2();
            $('#form').validate({ // initialize the plugin

                rules: {
                    select_job: {
                        required: true,
                    },
                    select_reason: {
                        required: true,
                    }

                },
                messages: {
                    select_job: {
                        required: "Required"
                    },
                    select_reason: {
                        required: "Required"
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
    </script>
@stop
