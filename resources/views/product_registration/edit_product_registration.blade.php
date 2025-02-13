@extends('layouts.app', ['page' => __('Edit Product Management'), 'pageSlug' => 'users', 'section' => 'users'])

@section('content')

    <!--**********************************
            Content body start
        ***********************************-->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <p class="mb-1">Edit Part Registration</p>
                    </div>
                </div>
            </div>
        @include('inc._message')
        <!-- row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Form Part Registration</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-validation">
                                <form class="form-valide" id="form" action="{{route('product_registration.update',$product->par_id)}}" method="post">
                                    @csrf
                                    @method("PUT")
                                    <div class="row">

                                        <div class="col-xl-6">


                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="part_name">Part Name
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="part_name"
                                                           name="part_name" placeholder="Enter a Part Name.." value="{{$product->par_name}}" >
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="purchase_price">Purchase Price
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="purchase_price"
                                                           name="purchase_price" placeholder="Enter a Purchase Price.." value="{{$product->par_purchase_price}}">
                                                </div>
                                            </div>
{{--                                            <div class="form-group row">--}}
{{--                                                <label class="col-lg-4 col-form-label" for="bottom_price">Bottom Price--}}
{{--                                                    <span class="text-danger">*</span>--}}
{{--                                                </label>--}}
{{--                                                <div class="col-lg-8">--}}
{{--                                                    <input type="text" class="form-control" id="bottom_price"--}}
{{--                                                           name="bottom_price" placeholder="Enter a Bottom Price.." value="{{$product->par_bottom_price}}">--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="retail_price">Retail Price
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="retail_price"
                                                           name="retail_price" placeholder="Enter a Retail Price.." value="{{$product->par_sale_price}}">
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

            $('#form').validate({ // initialize the plugin

                rules: {

                    part_name:{
                        required: true,
                        pattern: /^[A-Za-z0-9. ]{3,30}$/
                    },
                    purchase_price: {
                        required: true,
                        pattern:/^(\d+(,\d{1,2})?)?$/
                    },
                    bottom_price:{
                        required: true,
                        pattern:/^(\d+(,\d{1,2})?)?$/
                    },
                    retail_price:{
                        required: true,
                        pattern:/^(\d+(,\d{1,2})?)?$/
                    }
                },
                messages: {

                    part_name: {
                        required: "Required"
                    },
                    purchase_price: {
                        required: "Required",
                        pattern:"Only Digits"
                    },
                    bottom_price: {
                        required: "Required",
                        pattern:"Only Digits"

                    },
                    retail_price: {
                        required: "Required",
                        pattern:"Only Digits"
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
