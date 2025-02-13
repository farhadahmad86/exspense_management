@extends('layouts.app', ['page' => __('Edit Employee'), 'pageSlug' => 'users', 'section' => 'users'])

@section('content')

    <style>

        button, input {
            overflow: visible;
            border: none;
        }

        body {
            color: black;
        }

        <
        style >
        .form-group {
            position: relative;
        }

        .form-control {
            padding-right: 40px; /* Add padding to make room for the icon */
        }

        .form-group .fa-eye {
            position: absolute;
            top: 70%;
            right: 16px; /* Adjust this value as needed */
            transform: translateY(-50%);
            cursor: pointer;
        }

        .form-group .fa-eye-slash {
            position: absolute;
            top: 70%;
            right: 16px; /* Adjust this value as needed */
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style></style>


    <!--**********************************
            Content body start
        ***********************************-->
    <div class="content-body" style="margin-bottom: -30px">
        <div class="container-fluid">
            <div class="row page-titles mx-0" style="margin-top: -40px;margin-bottom: -4px">
                <div class="col-lg-12 p-md-0">
                    <div class="welcome-text" style="text-align: center">
                        <h1> Edit Employee</h1>

                    </div>
                </div>

            </div>
            @include('inc._message')
            <!-- row -->
            <div class="alert alert-danger " style="display: none" id="alert">
                <a href="#" class="close" aria-label="close"
                   onclick="document.getElementById('alert').style.display = 'none';">&times;</a>
                <p style="margin: auto;width: 50%;"><strong>Danger!</strong> Password not match.</p>
            </div>


            <div class="row">
                <div class="col-lg-12">
                    <div class="card">

                        <div class="card-body">
                            <div class="form-validation">
                                <form class="form-valide" id="form"
                                      action="{{ route('employee_registration.update', $employee_registration->id) }}"
                                      method="post" onsubmit="return maincheckForm()">
                                    @csrf
                                    @method("PUT")
                                    <div class="container">
                                        <h5 class="mb-3">Personal Information:</h5>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="name" name="name"
                                                           placeholder="Enter a Name.."
                                                           onkeypress="return lettersOnly(event)"
                                                           value="{{$employee_registration->name}}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="father_name">Father Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="father_name"
                                                           name="father_name" placeholder="Enter a Father Name.."
                                                           onkeypress="return lettersOnly(event)"
                                                          value="{{$employee_registration->f_name}}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="gender">Gender <span
                                                            class="text-danger">*</span></label>
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" value="Male"
                                                               id="male"
                                                               name="gender" {{  ($employee_registration->gender == "Male" ? ' checked' : '') }}>
                                                        <label class="form-check-label" for="male">Male</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" value="Female"
                                                               id="female"
                                                               name="gender" {{  ($employee_registration->gender == "Female" ? ' checked' : '') }}>
                                                        <label class="form-check-label" for="female">Female</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="cnic">CNIC <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="cnic" name="cnic"
                                                           placeholder="12345-1234567-1"
                                                           onkeypress="return cnicFormatter(event)"
                                                           value="{{$employee_registration->cnic}}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="number">Number <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="number" name="number"
                                                           placeholder="Enter Number.."
                                                           onkeypress="return numberFormatter(event)"
                                                           value="{{$employee_registration->number}}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="address">Address <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="address" name="address"
                                                           placeholder="Enter Address.."
                                                           value="{{$employee_registration->address}}">
                                                </div>
                                            </div>
                                        </div>

                                        <h5 class="mb-3">Status:</h5>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="roles">Select Role <span
                                                            class="text-danger">*</span></label>
                                                    <select id="roles" name="roles" class="form-control" required>
                                                        <option value="0">Select Role</option>
                                                        @foreach($roles as $role)
                                                            <option
                                                                value="{{ $role->id }}" {{$role->id == $employee_registration->role ? 'selected' : ''  }}>{{ $role->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Employee Status:</label>
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" value="1"
                                                               id="enable"
                                                               name="emp_status" {{  ($employee_registration->employee_status == 1 ? ' checked' : '') }}>
                                                        <label class="form-check-label" for="enable">Enable</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" value="0"
                                                               id="disable"
                                                               name="emp_status" {{  ($employee_registration->employee_status == 0 ? ' checked' : '') }}>
                                                        <label class="form-check-label" for="disable">Disable</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Login Status:</label>
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" value="1"
                                                               id="enable2"
                                                               name="log_status" {{  ($employee_registration->login_status == 1 ? ' checked' : '') }}>
                                                        <label class="form-check-label" for="enable2">Enable</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" value="0"
                                                               id="disable2"
                                                               name="log_status" {{  ($employee_registration->login_status == 0 ? ' checked' : '') }}>
                                                        <label class="form-check-label" for="disable2">Disable</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-center" style="margin-top: 20px;">
                                            <button type="submit" class="btn btn-primary">Register</button>
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
            let name = document.getElementById("name"),
                father_name = document.getElementById("father_name"),
                male = document.getElementById("male"),
                female = document.getElementById("female"),
                cnic = document.getElementById("cnic"),
                // number = document.getElementById("number"),
                // address = document.getElementById("address"),
                enable = document.getElementById("enable"),
                disable = document.getElementById("disable"),
                enable2 = document.getElementById("enable2"),
                disable2 = document.getElementById("disable2"),
                roles = document.getElementById("roles"),

                validateInputIdArray = [
                    name.id,
                    father_name.id,
                    male.id,
                    female.id,
                    cnic.id,
                    // number.id,
                    // address.id,
                    enable.id,
                    disable.id,
                    enable2.id,
                    disable2.id,
                    roles.id,

                ];

            // alert(male.checked)
            var ok = validateInventoryInputs(validateInputIdArray);

            if (male.checked == false && female.checked == false) {
                document.getElementById("male-l").style.color = "red"
                document.getElementById("female-l").style.color = "red"
                return false;
            } else {
                document.getElementById("male-l").style.color = ""
                document.getElementById("female-l").style.color = ""
            }
            if (enable.checked == false && disable.checked == false) {
                document.getElementById("enable-l").style.color = "red"
                document.getElementById("disable-l").style.color = "red"
                // .style.color = "red"
                return false;
            } else {
                document.getElementById("enable-l").style.color = ""
                document.getElementById("disable-l").style.color = ""
            }


            if (enable2.checked == false && disable2.checked == false) {
                document.getElementById("enable2-l").style.color = "red"
                document.getElementById("disable2-l").style.color = "red"
                // .style.color = "red"
                return false;
            } else {
                document.getElementById("enable2-l").style.color = ""
                document.getElementById("disable2-l").style.color = ""
            }

            if (roles.value == 0) {
                roles.nextSibling.childNodes[0].childNodes[0].style.border = "1px solid red"
                return false;
            }
            // if (female.value == "Female") {
            //     document.getElementById("female-l").style.color = "red"
            //     return false;
            // }
            // else{
            //     document.getElementById("female-l").style.color = ""
            // }

            // return validateInventoryInputs(validateInputIdArray);

            // var ok = validateInventoryInputs(validateInputIdArray);

            if (ok) {
                return true;
            } else {
                return false;
            }
        }

        $(document).ready(function () {
            $("#roles").select2();
            $("#model").select2();
            $("#category").select2();
            $("#role").select2();
            $('#form').validate({ // initialize the plugin

                // rules: {
                //     client_name: {
                //         required: true,
                //         pattern: /^[A-Za-z0-9. ]{3,30}$/
                //     },
                //     client_no: {
                //         required: true,
                //         pattern:/^((\+92-?)|(0092-?)|(0))3\d{2}-?\d{7}$/
                //     },
                //     warranty: {
                //         required: true,
                //     },
                //     delivery_time: {
                //         required: true,
                //     },
                //     job_id: {
                //         required: true,
                //     },
                //     brand: {
                //         required: true,
                //     },
                //     model: {
                //         required: true,
                //     },
                //     category: {
                //         required: true,
                //     },
                //     equipment: {
                //         required: true,
                //         pattern: /^[A-Za-z0-9. ]{3,30}$/
                //     },
                //     serial_no: {
                //         required: true,
                //     },
                //     estimated_cost: {
                //         required: true,
                //         pattern:/^(\d+(,\d{1,2})?)?$/
                //     },
                //     complain: {
                //         pattern: /^[A-Za-z0-9. ]{3,30}$/
                //     },
                //     accessories: {
                //         pattern: /^[A-Za-z0-9. ]{3,30}$/
                //     }
                // },
                // messages: {
                //     client_name: {
                //         required: "Required",
                //     },
                //     client_no: {
                //         required: "Required",
                //     },
                //     delivery_time: {
                //         required: "Required",
                //     },
                //     job_id: {
                //         required: "Required",
                //     },
                //     brand: {
                //         required: "Required",
                //     },
                //     model: {
                //         required: "Required",
                //     },
                //     category: {
                //         required: "Required",
                //     },
                //     equipment: {
                //         required: "Required",
                //     },
                //     serial_no: {
                //         required: "Required",
                //     },
                //     estimated_cost: {
                //         required: "Required",
                //     }
                //
                // },

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

        var counter = 0;
        var counter2 = 0;


        function add_complain() {

            if (complain_checkForm()) {
                counter++;

                var complain = $("#complain").val();

                add_complain_row(counter, complain);

            } else {

            }


        }

        function add_complain_row(counter, complain) {

            jQuery("#table_body").append(
                '<tr id="table_row' + counter + '">' +
                '<td>' + counter + '</td>' +
                '<td>' + '<input type="text" name="complain_data[]" id="complain_data' + counter + '" value="' + complain + '">' + '</td>' +

                '<td>' +
                '<span>' +
                '<a href="javascript:void()" data-toggle="tooltip" data-placement="top" title="Close"><i class="fa fa-close color-danger"></i></a>' +
                '</span>' +
                '</td>' +

                '</tr>');


            $("#complain").val('');


        }


        function add_accessories() {


            if (accessories_checkForm()) {

                counter2++;

                var accessories = $("#accessories").val();

                add_accessories_row(counter2, accessories);

            } else {

            }

        }

        function add_accessories_row(counter2, accessories) {

            jQuery("#table_body2").append(
                '<tr id="table_row' + counter2 + '">' +
                '<td>' + counter2 + '</td>' +
                '<td>' + '<input type="text" name="accessory_data[]" id="accessories_data' + counter2 + '" value="' + accessories + '">' + '</td>' +

                '<td>' +
                '<span>' +
                '<a href="javascript:void()" data-toggle="tooltip" data-placement="top" title="Close"><i class="fa fa-close color-danger"></i></a>' +
                '</span>' +
                '</td>' +

                '</tr>');


            $("#accessories").val('');


        }


    </script>

    <script type="text/javascript">


        function complain_checkForm() {
            let complain = document.getElementById("complain"),
                validateInputIdArray = [
                    complain.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }

        function accessories_checkForm() {
            let accessories = document.getElementById("accessories"),
                validateInputIdArray = [
                    accessories.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }

        function validateInventoryInputs(InputIdArray) {
            let i = 0,
                flag = false,
                getInput = '';


            for (i; i < InputIdArray.length; i++) {
                if (InputIdArray) {
                    getInput = document.getElementById(InputIdArray[i]);
                    if (getInput.value === '' || getInput.value === 0) {
                        getInput.focus();
                        getInput.classList.add('bg-danger');
                        flag = false;
                        break;
                    } else {
                        getInput.classList.remove('bg-danger');
                        flag = true;
                    }
                }
            }
            return flag;
        }


    </script>
@stop
