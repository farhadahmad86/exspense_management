@extends('layouts.app', ['page' => __('Add Product Loss'), 'pageSlug' => 'users', 'section' => 'users'])

@section('content')

    <!--**********************************
                Content body start
            ***********************************-->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <p class="mb-1">Add Product Loss</p>
                    </div>
                </div>
            </div>
            @include('inc._message')
            <!-- row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Add Product Loss</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-validation">
                                <form class="form-valide" id="form" action="{{ route('product_loss.store') }}"
                                    method="post" onsubmit="return maincheckForm()">
                                    @csrf
                                    <div class="row">

                                        <div class="col-xl-6">


                                            <div class="form-group row">
                                                <input type="hidden" name="inv_id" value="{{ $count }}">
                                                <label class="col-lg-4 col-form-label" for="part_name">Product Name
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-lg-8">
                                                    <span id="showStock" style="color: red">(Stock)</span>
                                                    <select id="part_name" name="part_name">
                                                        <option value="0">Select Product</option>
                                                        @foreach ($parts as $account)
                                                            <option value="{{ $account->par_id }}"
                                                                data-stock="{{ $account->par_total_qty }}" data-stock="{{$account->par_total_qty}}">
                                                                {{ $account->par_name }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="parts_qty">Products Quantity
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="parts_qty"
                                                        name="parts_qty" placeholder="Enter a Products Quantity.."
                                                        onkeypress="return numbersOnly(event)">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="remarks">Remarks <span
                                                        class="text-danger"></span>
                                                </label>
                                                <div class="col-lg-8">
                                                    <textarea class="form-control" id="remarks" name="remarks" rows="5" placeholder="Remarks"></textarea>
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
                parts_qty = document.getElementById("parts_qty"),
                validateInputIdArray = [
                    part_name.id,
                    parts_qty.id
                ];

            if (part_name.value == 0) {
                part_name.nextSibling.childNodes[0].childNodes[0].style.border = "1px solid red"
                return false;
            } else {
                part_name.nextSibling.childNodes[0].childNodes[0].style.border = ""
            }

            // return validateInventoryInputs(validateInputIdArray);

            var ok = validateInventoryInputs(validateInputIdArray);

            if (ok) {

                var qty = $("#parts_qty").val();
                var st_qty = $("#st_qty").val();

                if (parseFloat(qty) > parseFloat(st_qty)) {
                    alert("Do not have enough quantity");
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        }
        $(document).ready(function() {
            $("#part_name").select2();
            $(".select2-selection--single").focus();
            $("#category").select2();
        });

            $("#part_name").change(function () {
                var stock = jQuery('option:selected', this).attr('data-stock');
                $('#showStock').text(`(${stock})`);
        });
    </script>
@stop
