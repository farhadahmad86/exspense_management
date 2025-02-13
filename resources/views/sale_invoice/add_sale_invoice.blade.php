@extends('layouts.app', ['page' => __('Add Sale Invoice'), 'pageSlug' => 'users', 'section' => 'users'])

@section('content')

    <style>
        tbody::-webkit-scrollbar {

            width: 0px;

        }

        th,
        td {

            width: 100px !important;

        }

        button,
        input {

            overflow: visible;

            border: none;

        }


        tbody {

            overflow-y: scroll;

            overflow-x: hidden;

            max-height: 180px;

            width: fit-content;

        }

        tfoot {

            overflow-x: hidden;

            max-height: 180px;

            width: fit-content;

        }


        thead {

            width: 100%;

        }

        /*.table-container {*/

        /*    height: 10em;*/

        /*}*/

        .table-responsive {

            /*overflow: hidden;*/

        }


        table {

            display: flex;

            flex-flow: column;

            /*height: 100%;*/

            width: 100%;

        }


        table thead {

            /* head takes the height it requires,

                    and it's not scaled when table is resized */

            flex: 0 0 auto;

            /*width: calc(100% - 0.9em);*/

        }


        th {

            width: 100px;

        }


        table tbody {

            /* body takes all the remaining available space */

            flex: 1 1 auto;

            display: block;

            overflow-y: scroll;

        }


        table tbody tr,
        table tfoot tr {

            width: 100%;

        }


        table thead,
        table tbody tr,
        table tfoot tr {

            display: table;

            table-layout: fixed;

        }


        td input {

            width: 100%;

        }


        thead {

            /*width: 98.3%;*/

        }

        @media screen and (max-width: 1000px) {


            tfoot {

                width: min-content;

            }

        }
        .table .table {
            background-color: white !important;
        }
        .cancel_button {
            color: white !important;
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
                        <p class="mb-1"> Add Sale Invoice</p>

                    </div>

                </div>

                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">

                </div>

            </div>

            @include('inc._message')

            <!-- row -->

            <div class="alert alert-danger " style="display: none" id="alert">

                <a href="#" class="close" aria-label="close"
                   onclick="document.getElementById('alert').style.display = 'none';">&times;</a>

                <p style="margin: auto;width: 50%;"><strong>Danger!</strong> Add Parts to Sale Them</p>

            </div>


            <div class="row">

                <div class="col-lg-12">

                    <div class="card">

                        <div class="card-header">

                            <h4 class="card-title"> Add Sale Invoice</h4>

                        </div>

                        <div class="card-body">
                            <span class="float-right">
                                <button type="button" class="btn btn-primary" id="refreshData"><i class="fas fa-sync-alt"></i>
                                </button>
                            </span>
                            <div class="form-validation">

                                <form class="form-valide" id="form" action="{{ route('sale_invoice.store') }}"
                                      method="post" onsubmit="return checkform()">

                                    @csrf

                                    <div class="row">

                                        <div class="col-xl-12">

                                            <div class="form-group row">


                                                <label class="col-lg-1 col-form-label col-form-label-sm"
                                                       for="account">Account

                                                    <span class="text-danger">*</span>

                                                </label>

                                                <div class="col-lg-2">

                                                    <select id="account" name="account" tabindex="1">

                                                        <option value="" selected disabled>Select Account</option>

                                                        @foreach ($cash as $account)
                                                            <option value="{{ $account->ca_id }}">

                                                                {{ $account->ca_name }}</option>
                                                        @endforeach

                                                    </select>

                                                </div>


                                                <label class="col-lg-1 col-form-label col-form-label-sm"
                                                       for="account">Party

                                                    <span class="text-danger">*</span>

                                                </label>

                                                <div class="col-lg-2">

                                                    <select id="party" name="party" tabindex="1">

                                                        <option value="" selected disabled>Select Party</option>

                                                        @foreach ($party as $account)
                                                            <option value="{{ $account->party_id }}">

                                                                {{ $account->party_name }}</option>
                                                        @endforeach

                                                    </select>

                                                </div>


                                                <label class="col-lg-1 col-form-label col-form-label-sm"
                                                       for="remarks">Remarks <span class="text-danger"></span>

                                                </label>

                                                <div class="col-lg-5">

                                                    <textarea class="form-control form-control-sm" id="remarks"
                                                              name="remarks" rows="2" placeholder="Remarks"
                                                              tabindex="2"></textarea>

                                                </div>


                                            </div>


                                            <div class="form-group row">

                                                <label class="col-lg-1 col-form-label col-form-label-sm"
                                                       for="parts">Products

                                                    <span class="text-danger">*</span>

                                                </label>

                                                <div class="col-lg-2">

                                                    <select id="parts" name="parts" tabindex="3">

                                                        <option value="0" selected disabled>Select Products</option>

                                                        @foreach ($parts as $account)
                                                            <option value="{{ $account->par_id }}" data-stock="{{$account->par_total_qty}}" data-rate="{{$account->par_sale_price}}">

                                                                {{ $account->par_name }}</option>
                                                        @endforeach

                                                    </select>

                                                </div>

                                                <label class="col-lg-1 col-form-label col-form-label-sm"
                                                       for="qty">Quantity

                                                    <span class="text-danger">*</span>

                                                </label>

                                                <div class="col-lg-2">

                                                    <input type="text" class="form-control form-control-sm"
                                                           id="qty" name="qty" onkeyup="calculation()"
                                                           placeholder="Enter a Quantity.." tabindex="4"
                                                           onkeypress="return numbersOnly(event)">

                                                </div>

                                                <label class="col-lg-1 col-form-label col-form-label-sm" for="rate">Rate

                                                    <span class="text-danger">*</span>

                                                </label>

                                                <div class="col-lg-2">

                                                    <input type="text" onkeyup="calculation()"
                                                           class="form-control form-control-sm" id="rate" name="rate"
                                                           placeholder="Enter a Rate.." tabindex="5"
                                                           onkeypress="return numbersOnly(event)">

                                                </div>


                                                <label class="col-lg-1 col-form-label col-form-label-sm"
                                                       for="rate">Stock

                                                    <span class="text-danger">*</span>

                                                </label>

                                                <div class="col-lg-2">

                                                    <input type="text" class="form-control form-control-sm"
                                                           id="stock" readonly name="stock"
                                                           placeholder="Enter a Rate.." tabindex="5"
                                                           onkeypress="return numbersOnly(event)">

                                                </div>

                                            </div>


                                            <div class="form-group row">

                                                <label class="col-lg-1 col-form-label col-form-label-sm"
                                                       for="amount">Amount


                                                </label>

                                                <div class="col-lg-2">

                                                    <input type="text" readonly class="form-control form-control-sm"
                                                           id="amount" name="amount" placeholder="Enter a Amount..">

                                                </div>

                                                <label class="col-lg-1 col-form-label col-form-label-sm"
                                                       for="discount">Discount


                                                </label>

                                                <div class="col-lg-2">

                                                    <input type="text" class="form-control form-control-sm"
                                                           id="discount" name="discount" onkeyup="calculation()"
                                                           placeholder="Enter a Discount.." tabindex="6"
                                                           onkeypress="return numbersOnly(event)">

                                                </div>


                                                <label class="col-lg-1 col-form-label col-form-label-sm"
                                                       for="discount">Total


                                                </label>

                                                <div class="col-lg-2">

                                                    <input type="number" readonly class="form-control form-control-sm"
                                                           id="tamount" name="tamount" placeholder="Enter a Discount.."
                                                           onkeypress="return numbersOnly(event)">

                                                </div>


                                                <div class="col-lg-1 mr-auto">

                                                    <button type="button" onclick="return maincheckForm()"
                                                            class="btn btn-primary btn-sm" style="width: 137px"
                                                            tabindex="7">Add

                                                    </button>

                                                </div>

                                            </div>


                                            <div class="form-group row">


                                                <div class="col-lg-12">


                                                    <div class="card-body">

                                                        <div class="table-responsive">

                                                            <table
                                                                class="table table-bordered verticle-middle table-responsive-sm">

                                                                <thead>

                                                                <tr>

                                                                    <th scope="col">S#</th>

                                                                    <th scope="col">Parts</th>

                                                                    <th scope="col">Quantity</th>

                                                                    <th scope="col">Rate</th>

                                                                    <th scope="col">Amount</th>

                                                                    <th scope="col">Discount</th>

                                                                    <th scope="col">Total</th>

                                                                    <th scope="col">Action</th>

                                                                </tr>

                                                                </thead>

                                                                <tbody id="table_body">

                                                                {{--                                                                                                                                <tr> --}}

                                                                {{--                                                                                                                                    <td>1</td> --}}

                                                                {{--                                                                                                                                    <td>Parts Parts Parts</td> --}}

                                                                {{--                                                                                                                                    <td>Air Conditioner</td> --}}

                                                                {{--                                                                                                                                    <td>Air Conditioner</td> --}}

                                                                {{--                                                                                                                                    <td>Air Conditioner</td> --}}

                                                                {{--                                                                                                                                    <td>Air Conditioner</td> --}}



                                                                {{--                                                                                                                                    <td> --}}

                                                                {{--                                                                                                                    <span> --}}

                                                                {{--                                                                                                                        <a href="javascript:void()" class="mr-4" data-toggle="tooltip" --}}

                                                                {{--                                                                                                                           data-placement="top" title="Edit"><i --}}

                                                                {{--                                                                                                                                class="fa fa-pencil color-muted"></i> </a> --}}

                                                                {{--                                                                                                                        <a href="javascript:void()" data-toggle="tooltip" --}}

                                                                {{--                                                                                                                           data-placement="top" title="Close"><i --}}

                                                                {{--                                                                                                                                class="fa fa-close color-danger"></i></a> --}}

                                                                {{--                                                                                                                    </span> --}}





                                                                {{--                                                                                                                                    </td> --}}

                                                                {{--

                                                                                                                                                                                          </tr> --}}

                                                                </tbody>

                                                                {{--                                                                <tfoot style="width: 98.3%!important"> --}}

                                                                <tfoot>

                                                                <tr>

                                                                    <td style="border-right: none;"></td>

                                                                    <td style="text-align: right;border-left: none;">
                                                                        Total

                                                                        Item

                                                                    </td>

                                                                    <td style="border-right: none;border-right: none;">
                                                                        <input readonly type="number"
                                                                               onkeyup="calculation()" value="0"
                                                                               class="form-control" id="total_item"
                                                                               name="total_item"
                                                                               placeholder="Grand Total"
                                                                               style="height: 0px;background: none;border: none;">

                                                                    </td>

                                                                    <td style="border-left: none;"></td>

                                                                    <td style="border-right: none;"></td>

                                                                    <td style="text-align: right;border-left: none;"
                                                                        colspan="2">Grand

                                                                        Total

                                                                    </td>

                                                                    <td style="border-right: none;" colspan="2">
                                                                        <input readonly type="number"
                                                                               onkeyup="calculation()" value="0"
                                                                               class="form-control" id="grand_total"
                                                                               name="grand_total"
                                                                               placeholder="Grand Total"
                                                                               style="height: 0px;background: none;border: none;">

                                                                    </td>

                                                                    <td style="border-left: none;"></td>


                                                                </tr>

                                                                </tfoot>


                                                            </table>


                                                        </div>

                                                        <div class="row">

                                                            <div class="col-lg-3"></div>

                                                            <label class="col-lg-2 col-form-label col-form-label-sm"
                                                                   for="p_amount"> Amount Paid (Rs)


                                                                <span class="text-danger">*</span></label>

                                                            <div class="col-lg-2 text-right">

                                                                <input type="text" class="form-control form-control-sm"
                                                                       id="p_amount" value="" name="p_amount"
                                                                       placeholder="Enter a Amount.."
                                                                       onkeyup="amount_check()"
                                                                       onkeypress="return numbersOnly(event)">

                                                            </div>

                                                            <label class="col-lg-1 col-form-label col-form-label-sm"
                                                                   for="discount">Remaining


                                                            </label>

                                                            <div class="col-lg-2">

                                                                <input type="number" readonly
                                                                       class="form-control form-control-sm"
                                                                       id="r_amount"
                                                                       name="remaining" placeholder="Enter a Discount.."
                                                                       onkeypress="return numbersOnly(event)">

                                                            </div>


                                                            <div class="col-lg-2">

                                                                <button type="submit" class="btn btn-primary btn-sm"
                                                                        tabindex="8">Save

                                                                </button>
                                                                <input type="hidden" name="inv_no" value="{{$count}}">
                                                            </div>

                                                        </div>


                                                        <div class="row justify-content-end">

                                                            {{--                                                                <label class="col-lg-2 col-form-label col-form-label-sm ml-auto" for="rate">Grand Total --}}

                                                            {{--                                                                    <span class="text-danger">*</span> --}}

                                                            {{--                                                                </label> --}}

                                                            {{--                                                                <div class="col-lg-2"> --}}

                                                            {{--                                                                    <input readonly type="number" onkeyup="calculation()" value="0" class="form-control form-control-sm" id="grand_total" --}}

                                                            {{--                                                                           name="grand_total" placeholder="Grand Total"> --}}

                                                            {{--                                                                </div> --}}


                                                        </div>

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





    <div class="modal fade" id="myModal" role="dialog">

        <div class="modal-dialog modal-lg mdl_wdth">

            <div class="modal-content base_clr">

                <div class="modal-header">

                    <h4 class="modal-title text-black">Sales Invoice Detail</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>

                <div class="modal-body">


                    <div id="table_body">


                    </div>


                </div>


                <div class="modal-footer">

                    <div class="col-lg-12 col-md-12 col-sm-12">

                        <div class="form_controls">

                            <button type="button" class="btn btn-default form-control cancel_button"
                                    data-dismiss="modal">

                                <i class="fa fa-times"></i> Cancel

                            </button>

                        </div>

                    </div>

                </div>


            </div>

        </div>

    </div>

@endsection

@section('script')

    <script>
        function amount_check() {

            var p_amount = $("#p_amount").val();

            var grand_total = $("#grand_total").val();

            var diff = grand_total - p_amount;

            $("#r_amount").val(diff);

        }

        function grand() {

            var abc = $('.valid').val();

            console.log(abc);

        }


        function maincheckForm() {

            let account = document.getElementById("account"),

                party = document.getElementById("party"),

                parts = document.getElementById("parts"),

                qty = document.getElementById("qty"),

                rate = document.getElementById("rate"),

                validateInputIdArray = [

                    account.id,

                    parts.id,

                    party.id,

                    qty.id,

                    rate.id,

                ];


            if (account.value == 0) {

                account.nextSibling.childNodes[0].childNodes[0].style.border = "1px solid red"

                return false;

            } else {

                account.nextSibling.childNodes[0].childNodes[0].style.border = ""

            }

            if (party.value == 0) {

                party.nextSibling.childNodes[0].childNodes[0].style.border = "1px solid red"

                return false;

            } else {

                party.nextSibling.childNodes[0].childNodes[0].style.border = ""

            }

            if (parts.value == 0) {

                parts.nextSibling.childNodes[0].childNodes[0].style.border = "1px solid red"

                return false;

            } else {

                parts.nextSibling.childNodes[0].childNodes[0].style.border = ""

            }

            if (document.getElementById("tamount").value < 0) {

                // alert("Amount can not be greater than estimate cost");

                // document.getElementById("alert").style.display = "block";

                alert("Total is Negative");

                return false;

            }


            // return validateInventoryInputs(validateInputIdArray);


            var ok = validateInventoryInputs(validateInputIdArray);


            if (ok) {

                add_sale()

                return true;

            } else {

                return false;

            }

        }

        function checkform() {

            var val1 = $("#grand_total").val();

            if (val1 < 0) {

                // document.getElementById("alert").style.display = "block";

                alert("Grand Total is Negative");

                return false;

            }


            var tt = $("#total_item").val();


            if (tt == 0) {

                document.getElementById("alert").style.display = "block";

                return false;

            }


            var bol;

            $('input[name="tamount[]"]').each(function (pro_index) {


                let value = $(this).val();

                if (value < 0) {

                    // alert("Amount can not be greater than estimate cost");

                    // document.getElementById("alert").style.display = "block";

                    alert("Total of Part is Negative");

                    bol = 0;

                }

            })

            var p_amount = document.getElementById("p_amount");

            if ($("#p_amount").val() == "") {

                p_amount.classList.add('red-border');

                return false

            }


            if (parseFloat(p_amount.value) > parseFloat(val1)) {

                p_amount.classList.add('red-border');

                return false

            } else {

                p_amount.classList.remove('red-border');

            }

            if (bol == 0) {

                return false;

            } else {

                var ans = check_stck();

                return ans;

            }

        }

        function check_stck() {


            if (counter == 0) {

                document.getElementById("alert").style.display = "block";

                return false;

            }


            var disc_percentage = 0;

            var disc_amount = jQuery("#disc_amount").val();


            var count_total = 0;

            var count2_total = 0;

            var qty;

            var pro_code;

            var pro_field_id_title;

            var pro_field_id;


            $('input[name="parts_name[]"]').each(function (pro_index) {

                pro_code = $(this).val();

                pro_field_id_title = $(this).attr('id');

                pro_field_id = pro_field_id_title.match(/\d+/); // 123456


                qty = jQuery("#qty" + pro_field_id).val();

                st_qty = jQuery("#st_qty" + pro_field_id).val();


                // grand_total = +grand_total + +product_amount;

                // item_total = +item_total + +product_quantity;


                if (parseFloat(qty) <= parseFloat(st_qty)) {

                    // alert("work");

                    count_total++;

                    // $("#qty"+count).val("0");

                }

                count2_total++;

            });

            console.log(count_total, count2_total);

            if (count_total == count2_total) {

                // alert("www")

                // return false;

                return true;

            } else {

                alert("Do not have enough quantity");

                return false;

            }

        }


        $(document).ready(function () {
            $('#refreshData').click(function() {
                $.ajax({
                    url: '{{ route("refresh-data") }}',  // URL to fetch the updated data
                    method: 'GET',
                    success: function(response) {
                        console.log(response);
                        // Clear and append new data for "account"
                        $('#account').empty().append('<option value="" selected disabled>Select Account</option>');
                        $.each(response.cash, function(index, account) {
                            $('#account').append('<option value="' + account.ca_id + '" data-balance="' + account.ca_balance + '">' + account.ca_name + '</option>');
                        });

                        // Clear and append new data for "party"
                        $('#party').empty().append('<option value="" selected disabled>Select Party</option>');
                        $.each(response.party, function(index, party) {
                            $('#party').append('<option value="' + party.party_id + '">' + party.party_name + '</option>');
                        });
                        // Clear and append new data for "products"
                        $('#parts').empty().append('<option value="" selected disabled>Select Product</option>');

                        $.each(response.parts, function(index, part) {
                            $('#parts').append('<option value="' + part.par_id + '" data-stock="' + part.par_total_qty + '" data-rate="' + part.par_purchase_price + '">' + part.par_name + '</option>');
                        });
                        $('#rate').val('');
                        $('#account_total').val('');
                    }
                });
            });
            $("#account").select2();

            $(".select2-selection--single").focus();

            $("#parts").select2();

            $("#party").select2();

            $("#select_parts").select2();

            $("#parts").change(function () {
                var rate = jQuery('option:selected', this).attr('data-rate');
                $('#rate').val(`${rate}`);
            });
            $("#parts").change(function () {
                var stock = jQuery('option:selected', this).attr('data-stock');
                $('#stock').val(`${stock}`);
            });
        });


        var counter = 0;


        function add_sale() {


            counter++;


            var parts = document.getElementById('parts');

            var parts_name = parts.options[parts.selectedIndex].text;


            var parts = $("#parts").val();

            var qty = $("#qty").val();

            var rate = $("#rate").val();

            var amount = $("#amount").val();

            var discount = $("#discount").val();

            var total = $("#tamount").val();


            var st_qty = $("#stock").val();


            if (parseFloat(qty) > parseFloat(st_qty)) {

                alert("Do not have enough quantity");

            } else {

                add_sale_row(counter, parts, parts_name, qty, rate, amount, discount, total, st_qty);

            }


        }


        function add_sale_row(counter, parts, parts_name, qty, rate, amount, discount, total, st_qty) {


            jQuery("#parts option[value=" + parts + "]").attr("disabled", "true");

            jQuery("#parts").select2("destroy");

            jQuery("#parts").select2();


            jQuery("#table_body").append(
                '<tr id="table_row' + counter + '">' +

                '<td>' + counter + '</td>' +


                '<td hidden>' + '<input type="text" name="parts[]" id="parts' + counter + '" value="' + parts + '">' +
                '</td>' +

                '<td>' + '<input type="text" name="parts_name[]" id="parts_name' + counter + '" value="' + parts_name +
                '">' + '</td>' +

                '<td hidden>' + '<input type="text" name="st_qty[]" id="st_qty' + counter + '" value="' + st_qty +
                '">' + '</td>' +

                '<td>' + '<input type="text" onkeypress="return numbersOnly(event)" name="qty[]" id="qty' + counter +
                '" value="' + qty + '" onkeyup="calculation2(' + counter + ')">' + '</td>' +

                '<td>' + '<input type="text" onkeypress="return numbersOnly(event)" name="rate[]" id="rate' + counter +
                '" value="' + rate + '" onkeyup="calculation2(' + counter + ')">' + '</td>' +

                '<td>' + '<input readonly type="text" name="amount[]" id="amount' + counter + '" value="' + amount +
                '">' + '</td>' +

                '<td>' + '<input type="text" onkeypress="return numbersOnly(event)" name="discount[]" id="discount' +
                counter + '" value="' + discount + '" onkeyup="calculation2(' + counter + ')">' + '</td>' +

                '<td>' + '<input readonly type="text" name="tamount[]" id="tamount' + counter + '" value="' + total +
                '">' + '</td>' +


                '<td>' +

                '<span>' +

                '<a href="javascript:void()" onclick="delete_sale(' + counter + ')" data-toggle="tooltip" data-placement="top" title="Close"><i class="fas fa-times color-danger"></i></a>'
                +

                '</span>' +

                '</td>' +


                '</tr>');

            $("#parts").val('aaa');


            // var total = $("#tamount").val();

            // var grand = $("#grand_total").val();

            // // var total_cal = parseFloat(grand) + parseFloat(total);

            //

            // var total_float = parseFloat(total);

            // var grand_float = parseFloat(grand);

            //

            // var total_cal = grand_float + total_float;

            //

            // // alert(parseFloat(total_cal));

            // $("#grand_total").val(total_cal);


            // var qty = $("#qty").val();

            // var item = $("#total_item").val();

            // // var total_cal = parseFloat(grand) + parseFloat(total);

            //

            // var qty_float = parseFloat(qty);

            // var item_float = parseFloat(item);

            //

            // var total_cal2 = item_float + qty_float;

            //

            // // alert(parseFloat(total_cal));

            // $("#total_item").val(total_cal2);


            $("#qty").val('');

            $("#rate").val('');

            $("#amount").val('');

            $("#discount").val('');

            grand_total_calculation_with_disc_amount();

            // grand();

        }


        function delete_sale(current_item) {

            var hid = $("#parts" + current_item).val();

            var hi = $("#parts" + current_item);


            var tamount = $("#tamount" + current_item).val()

            var grand_total = $("#grand_total").val();

            $("#grand_total").val(grand_total - tamount);


            var qty = $("#qty" + current_item).val()

            var total_item = $("#total_item").val();

            $("#total_item").val(total_item - qty);

            // alert(tamount);

            $("#table_row" + current_item).remove();

            $("#parts").select2("destroy");

            $("#parts option[value=" + hid + "]").removeAttr("disabled");

            // alert(this.value);

            $("#parts").select2();

            $("#parts").val(0);

        }


        {{--jQuery("#parts").change(function () {--}}


        {{--    var dropDown = document.getElementById('parts');--}}

        {{--    var bra_name_id = dropDown.options[dropDown.selectedIndex].value;--}}


        {{--    jQuery.ajaxSetup({--}}

        {{--        headers: {--}}

        {{--            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')--}}

        {{--        }--}}

        {{--    });--}}


        {{--    jQuery.ajax({--}}

        {{--        url: "{{ route('get_rate') }}",--}}

        {{--        data: {--}}
        {{--            bra_name_id: bra_name_id--}}
        {{--        },--}}

        {{--        type: "GET",--}}

        {{--        cache: false,--}}

        {{--        dataType: 'json',--}}

        {{--        success: function (data) {--}}


        {{--            console.log(data);--}}


        {{--            $.each(data, function (index, value) {--}}

        {{--                $rate = value.par_sale_price;--}}

        {{--                $stock = value.par_total_qty;--}}

        {{--            });--}}

        {{--            jQuery("#rate").val($rate);--}}

        {{--            jQuery("#stock").val($stock);--}}

        {{--        },--}}

        {{--        error: function (jqXHR, textStatus, errorThrown) {--}}

        {{--            alert(jqXHR.responseText);--}}

        {{--            alert(errorThrown);--}}

        {{--        }--}}

        {{--    });--}}

        {{--});--}}


        function calculation() {


            var qty = $("#qty").val();

            var rate = $("#rate").val();

            var amount = $("#amount").val();

            var discount = $("#discount").val();

            var total = $("#tamount").val();


            var amount_cal = qty * rate;

            $("#amount").val(amount_cal);


            var total_cal = amount_cal - discount;

            $("#tamount").val(total_cal);


        }


        function calculation2(count) {


            var qty = $("#qty" + count).val();

            var rate = $("#rate" + count).val();

            var amount = $("#amount" + count).val();

            var discount = $("#discount" + count).val();

            var total = $("#tamount" + count).val();


            var amount_cal = qty * rate;

            $("#amount" + count).val(amount_cal);


            var total_cal = amount_cal - discount;

            $("#tamount" + count).val(total_cal);


            grand_total_calculation_with_disc_amount();


        }


        function grand_total_calculation_with_disc_amount() {


            var disc_percentage = 0;

            var disc_amount = jQuery("#disc_amount").val();


            var grand_total = 0;

            var item_total = 0;

            var product_quantity;

            var pro_code;

            var pro_field_id_title;

            var pro_field_id;


            $('input[name="parts_name[]"]').each(function (pro_index) {

                pro_code = $(this).val();

                pro_field_id_title = $(this).attr('id');

                pro_field_id = pro_field_id_title.match(/\d+/); // 123456


                product_quantity = jQuery("#qty" + pro_field_id).val();

                product_amount = jQuery("#tamount" + pro_field_id).val();


                grand_total = +grand_total + +product_amount;

                item_total = +item_total + +product_quantity;

            });


            // console.log(grand_total);

            $("#grand_total").val(grand_total)

            $("#total_item").val(item_total)

            // alert(grand_total);


            // jQuery("#total_tax").val(total_sale_tax_amount.toFixed(2));

            // jQuery("#grand_total").val(grand_total.toFixed(2));


        }

        function delete2() {


        }
    </script>







    @if (Session::has('si_id'))
        <script>
            // alert("id mill gai");


            jQuery("#table_body").html("");


            var id = '{{ Session::get('si_id') }}';


            $('.modal-body').load('{{ url('sale_invoice_modal_view_details/view/') }}' + '/' + id, function () {

                $("#myModal").modal({
                    show: true
                });


                // // for print preview to not remain on screen

                // if ($('#quick_print').is(":checked")) {

                //

                //     setTimeout(function () {

                //         var abc = $("#printi");

                //         abc.click();

                //

                //

                //         $('.invoice_sm_mdl').css('display', 'none');

                //         $('.cancel_button').click();

                //         $('#product').focus();

                //     }, 100);

                // }


            });

            function check_stock() {


                if (counter == 0) {

                    document.getElementById("alert").style.display = "block";

                    return false;

                }


                var disc_percentage = 0;

                var disc_amount = jQuery("#disc_amount").val();


                var count_total = 0;

                var count2_total = 0;

                var qty;

                var pro_code;

                var pro_field_id_title;

                var pro_field_id;


                $('input[name="parts_name[]"]').each(function (pro_index) {

                    pro_code = $(this).val();

                    pro_field_id_title = $(this).attr('id');

                    pro_field_id = pro_field_id_title.match(/\d+/); // 123456


                    qty = jQuery("#qty" + pro_field_id).val();

                    st_qty = jQuery("#st_qty" + pro_field_id).val();


                    // grand_total = +grand_total + +product_amount;

                    // item_total = +item_total + +product_quantity;


                    if (parseFloat(qty) <= parseFloat(st_qty)) {

                        // alert("work");

                        count_total++;

                        // $("#qty"+count).val("0");

                    }

                    count2_total++;

                });

                console.log(count_total, count2_total);

                if (count_total == count2_total)

                    return true;

                else {

                    alert("Do not have enough quantity");

                    return false;

                }

            }
        </script>
    @endif

@stop
