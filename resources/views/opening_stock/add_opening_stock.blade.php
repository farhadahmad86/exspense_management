@extends('layouts.theme')

@section('content')


    <style>

        button, input {
            overflow: visible;
            border: none;
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
                        <h4>Hi, welcome back!</h4>
                        <p class="mb-1">Openning_Stock</p>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Registration</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Issue Parts To Job</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Create Issue Parts To Job</a></li>
                    </ol>
                </div>
            </div>
        @include('inc._message')
        <!-- row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Form Issue Parts To Job</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-validation">
                                <form class="form-valide" id="form" action="{{route('issue_parts_to_job.store')}}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-12">


                                            <div class="form-group row">

                                                <div class="col-lg-12">

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered verticle-middle table-responsive-sm">
                                                                <thead>
                                                                <tr>
                                                                    <th scope="col">S#</th>
                                                                    <th scope="col">Part Name</th>
                                                                    <th scope="col">Part Quantity</th>
                                                                    <th scope="col">Actions</th>

                                                                </tr>
                                                                </thead>
                                                                <tbody id="table_body">

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>


                                                    <button type="submit" class="btn btn-primary">Submit</button>

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
            $("#select_job").select2();
            $("#select_parts").select2();
            $('#form').validate({ // initialize the plugin

                // rules: {
                //     select_job: {
                //         required: true,
                //     },
                //     qty: {
                //         required: true,
                //     },
                //     select_parts: {
                //         required: true,
                //     }
                // },
                // messages: {
                //     select_job: {
                //         required: "Required"
                //     },
                //     qty: {
                //         required: "Required"
                //     },
                //     select_parts: {
                //         required: "Required"
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

        function add_sale() {

            counter++;

            // alert("sale");
            var parts = document.getElementById('select_parts');
            var parts_name= parts.options[parts.selectedIndex].text;





            var qty = $("#qty").val();


            add_sale_row(counter, parts, qty, parts_name);

        }

        function add_sale_row(counter, parts, qty, parts_name){

            jQuery("#table_body").append(

                '<tr id="table_row' + counter + '">' +
                '<td>' + counter + '</td>' +

                '<td hidden>'+ '<input type="text" name="parts[]" id="parts'+ counter +'" value="'+ parts.value +'">' +'</td>' +
                '<td>'+ '<input readonly type="text" name="parts_name[]" id="parts_name'+ counter +'" value="'+ parts_name +'">' +'</td>' +
                '<td>'+ '<input type="text" name="qty[]" id="qty'+ counter +'" value="'+ qty +'">' +'</td>' +

                '<td>' +
                '<span>' +
                '<a href="javascript:void()" onclick="delete_sale('+counter+')" data-toggle="tooltip" data-placement="top" title="Close"><i class="fa fa-close color-danger"></i></a>' +
                '</span>' +
                '</td>' +

                '</tr>');



            $("#qty").val('');
            $("#rate").val('');
            $("#amount").val('');
            $("#discount").val('');


        }

        function delete_sale(current_item) {
            jQuery("#table_row" + current_item).remove();
        }



    </script>
@stop
