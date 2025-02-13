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
                        <p class="mb-1">Product Registration</p>
                    </div>
                </div>
            </div>
        @include('inc._message')
        <!-- row -->
            <div class="alert alert-danger " style="display: none" id="alert">
                <a href="#" class="close" aria-label="close" onclick="document.getElementById('alert').style.display = 'none';">&times;</a>
                <p style="margin: auto;width: 50%;"><strong>Danger!</strong> Purchase price can not be greater than bottom price.</p>
            </div>
            <div class="alert alert-danger " style="display: none" id="alert2">
                <a href="#" class="close" aria-label="close" onclick="document.getElementById('alert2').style.display = 'none';">&times;</a>
                <p style="margin: auto;width: 50%;"><strong>Danger!</strong> Bottom price can not be greater than retail price.</p>
            </div>


            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Product Registration</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-validation">
                                <form class="form-valide" id="form" action="{{route('product_registration.store')}}"
                                      method="post" onsubmit="return maincheckForm()">
                                    @csrf
                                    <div class="row">

                                        <div class="col-xl-6">


                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="part_name">Product Name
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="part_name"
                                                           name="product_name" placeholder="Enter a Product Name.."
                                                           autofocus>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="purchase_price">Purchase
                                                    Price
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="purchase_price"
                                                           name="purchase_price" placeholder="Enter a Purchase Price.."
                                                           onkeypress="return numbersOnly(event)">
                                                </div>
                                            </div>
{{--                                            <div class="form-group row">--}}
{{--                                                <label class="col-lg-4 col-form-label" for="bottom_price">Bottom Price--}}
{{--                                                    <span class="text-danger">*</span>--}}
{{--                                                </label>--}}
{{--                                                <div class="col-lg-8">--}}
{{--                                                    <input type="text" class="form-control" id="bottom_price"--}}
{{--                                                           name="bottom_price" placeholder="Enter a Bottom Price.."--}}
{{--                                                           onkeypress="return numbersOnly(event)">--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="retail_price">Retail Price
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="retail_price"
                                                           name="retail_price" placeholder="Enter a Retail Price.."
                                                           onkeypress="return numbersOnly(event)">
                                                </div>
                                            </div>

                                            <div class="form-group row" hidden>
                                                <label class="col-lg-4 col-form-label" for="retail_price">Opening
                                                    Quantity
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="qty"
                                                           name="qty" placeholder="Enter a Opening Quantity.." value="0"
                                                           onkeypress="return numbersOnly(event)">
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
            let part_name = document.getElementById("part_name"),
                purchase_price = document.getElementById("purchase_price"),
                bottom_price = document.getElementById("bottom_price"),
                retail_price = document.getElementById("retail_price"),
                qty = document.getElementById("qty"),
                validateInputIdArray = [
                    part_name.id,
                    purchase_price.id,
                    bottom_price.id,
                    retail_price.id,
                    qty.id
                ];

            if (parseFloat(purchase_price.value) > parseFloat(bottom_price.value)) {
                document.getElementById("alert").style.display = "block";
                return false;
            }
            if (parseFloat(bottom_price.value) > parseFloat(retail_price.value)) {
                document.getElementById("alert2").style.display = "block";
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

        $(document).ready(function () {

            $('#form').validate({ // initialize the plugin

                rules: {

                    part_name: {
                        // required: true,
                        // pattern: /^[A-Za-z0-9. ]{3,30}$/
                    },
                    purchase_price: {
                        // required: true,
                        // pattern:/^(\d+(,\d{1,2})?)?$/
                    },
                    bottom_price: {
                        // required: true,
                        // pattern:/^(\d+(,\d{1,2})?)?$/
                    },
                    retail_price: {
                        // required: true,
                        // pattern:/^(\d+(,\d{1,2})?)?$/
                    }
                },
                messages: {

                    part_name: {
                        // required: "Required"
                    },
                    purchase_price: {
                        // required: "Required",
                        // pattern:"Only Digits"
                    },
                    bottom_price: {
                        // required: "Required",
                        // pattern:"Only Digits"

                    },
                    retail_price: {
                        // required: "Required",
                        // pattern:"Only Digits"
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
