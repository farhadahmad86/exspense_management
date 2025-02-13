@extends('layouts.app', ['page' => __('Roles'), 'pageSlug' => 'users', 'section' => 'users'])

@section('content')
    <!--**********************************
            Content body start
        ***********************************-->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <p class="mb-1">Roles</p>
                    </div>
                </div>
            </div>
        @include('inc._message')
        <!-- row -->
            <div class="row">
                <div class="col-xl-4 col-xxl-6 col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Permissions</h4>
                        </div>
                        <div class="card-body">
                            <div class="basic-list-group">
                                <ul class="list-group">
                                    <li class="list-group-item active">   {{ $role->name }}</li>

                                    @if(!empty($rolePermissions))
                                        @foreach($rolePermissions as $v)
                                            <li class="list-group-item">{{ $v->name }}</li>
{{--                                            <label class="label label-success">{{ $v->name }},</label>--}}
                                        @endforeach
                                    @endif

{{--                                    <li class="list-group-item">Dapibus ac facilisis in</li>--}}
{{--                                    <li class="list-group-item">Morbi leo risus</li>--}}
{{--                                    <li class="list-group-item">Porta ac consectetur ac</li>--}}
{{--                                    <li class="list-group-item">Vestibulum at eros</li>--}}
                                </ul>
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

            let roles = document.getElementById("roles")
            validateInputIdArray = [
                roles.id
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
            }else{
                return false;
            }
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
        $(document).ready(function () {
            $('#form').validate({ // initialize the plugin

                rules: {
                    roles: {
                        // required: true,
                        // pattern: /^[A-Za-z0-9. ]{3,30}$/
                    }
                },
                messages: {
                    roles: {
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
