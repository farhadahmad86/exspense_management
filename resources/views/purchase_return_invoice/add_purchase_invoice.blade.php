@extends('layouts.app', ['page' => __('Add Purchase Invoice'), 'pageSlug' => 'users', 'section' => 'users'])

@section('content')
    <style>
        tbody::-webkit-scrollbar {

            width: 0px;

        }


        thead {

            width: 100%;

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


        }


        /*.table-container {*/

        /*    height: 10em;*/

        /*}*/

        /*.table-responsive{*/

        /*    overflow: hidden;*/

        /*}*/

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

        table tbody {

            /* body takes all the remaining available space */

            flex: 1 1 auto;

            display: block;

            overflow-y: scroll;

            width: fit-content;

        }

        table tbody tr {

            width: 100%;

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

        tfoot {

            overflow-x: hidden;

            max-height: 180px;

            width: fit-content;

        }

        table thead,
        table tbody tr {

            display: table;

            table-layout: fixed;

        }

        td input {

            width: 100%;

        }

        th,
        td {

            width: 100px !important;

        }

        thead {

            width: 100%;

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

                        <p class="mb-1">Purchase Return Invoice</p>

                    </div>

                </div>

            </div>

            @include('inc._message')

            <!-- row -->

            <div class="alert alert-danger " style="display: none" id="alert">

                <a href="#" class="close" aria-label="close"
                   onclick="document.getElementById('alert').style.display = 'none';">&times;</a>

                <p style="margin: auto;width: 50%;"><strong>Danger!</strong> Add Products to Purchase Them</p>

            </div>


            <div class="row">

                <div class="col-lg-12">

                    <div class="card">

                        <div class="card-header">

                            <h4 class="card-title">Purchase Return Invoice</h4>

                        </div>

                        <div class="card-body">
{{--                            <span class="float-right">--}}
{{--                                <button type="button" class="btn btn-primary" id="refreshData"><i class="fas fa-sync-alt"></i>--}}
{{--                                </button>--}}
{{--                            </span>--}}
                            <div class="form-validation">

                                <form class="form-valide" id="form" action="{{ route('purchase_return_invoice.store') }}"
                                      onsubmit="return check()" method="post">

                                    @csrf

                                    <div class="row">

                                        <div class="col-xl-12">

                                            <div class="form-group row">
                                                <label class="col-lg-1 col-form-label col-form-label-sm" for="purchase_invoice">
                                                    Purchase Invoice <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-lg-2">
                                                    <select id="purchase_invoice" name="purchase_invoice" tabindex="1">
                                                        <option value="" selected disabled>Select Purchase Invoice</option>
                                                        @foreach ($purchase_invoice as $inv)
                                                            <option value="{{ $inv->pi_id }}">{{ $inv->pi_inv_id }}</option>
                                                        @endforeach
                                                    </select>
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
            <!-- Table to display invoice details -->
            <table class="table table-bordered" id="invoiceTable">
                <thead>
                <tr>
                    <th>Part Name</th>
                    <th>Quantity</th>
                    <th>Rate</th>
                    <th>Discount</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody id="invoiceDetailsBody">
                <!-- Rows will be appended here using jQuery -->
                </tbody>
            </table>

        </div>

    </div>

    <!--**********************************

                Content body end

            ***********************************-->





    <div class="modal fade" id="myModal" role="dialog">

        <div class="modal-dialog modal-lg mdl_wdth">

            <div class="modal-content base_clr">

                <div class="modal-header">

                    <h4 class="modal-title text-black">Purchase Invoice Detail</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>

                <div class="modal-body">


                    <div id="table_body">


                    </div>


                </div>


                <div class="modal-footer">

                    <div class="col-lg-12 col-md-12 col-sm-12">

                        <div class="form_controls">

                            <button type="button" class="btn btn-default form-control form-control-sm cancel_button"
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

        function maincheckForm() {

            let account = document.getElementById("account"),

                party = document.getElementById("party"),

                parts = document.getElementById("parts"),

                qty = document.getElementById("qty"),

                rate = document.getElementById("rate"),

                validateInputIdArray = [

                    account.id,

                    party.id,

                    parts.id,

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
            $('#purchase_invoice').change(function() {
                let invoiceId = $(this).val(); // Get the selected invoice ID

                // AJAX call to fetch the invoice details
                $.ajax({
                    url: '{{route('get_invoice_data')}}',
                    data:{
                        InvoiceID:invoiceId
                    },
                    type: 'GET',
                    success: function(response) {
                            console.log(response)
                        // Clear any existing rows in the table body
                        $('#invoiceDetailsBody').empty();

                        // Iterate over the invoice items and append them to the table
                        $.each(response, function(index, item) {
                            let row = `
                    <tr>
                        <td>
                            <input type="text" class="form-control" name="part_name[]" value="${item.pii_part_name}" readonly />
                        </td>
                        <td>
                            <input type="number" class="form-control" name="qty[]" value="${item.pii_qty}" readonly />
                        </td>
                        <td>
                            <input type="number" class="form-control" name="rate[]" value="${item.pii_rate}" readonly />
                        </td>
                        <td>
                            <input type="number" class="form-control" name="discount[]" value="${item.pii_discount}" readonly />
                        </td>
                        <td>
                            <input type="number" class="form-control" name="amount[]" value="${item.pii_amount}" readonly />
                        </td>
                    </tr>
                `;
                            $('#invoiceDetailsBody').append(row);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log('Error fetching data:', error);
                    }
                });
            });

            {{--$('#refreshData').click(function() {--}}
            {{--    $.ajax({--}}
            {{--        url: '{{ route("refresh-data") }}',  // URL to fetch the updated data--}}
            {{--        method: 'GET',--}}
            {{--        success: function(response) {--}}
            {{--            console.log(response);--}}
            {{--            // Clear and append new data for "account"--}}
            {{--            $('#account').empty().append('<option value="" selected disabled>Select Account</option>');--}}
            {{--            $.each(response.cash, function(index, account) {--}}
            {{--                $('#account').append('<option value="' + account.ca_id + '" data-balance="' + account.ca_balance + '">' + account.ca_name + '</option>');--}}
            {{--            });--}}

            {{--            // Clear and append new data for "party"--}}
            {{--            $('#party').empty().append('<option value="" selected disabled>Select Party</option>');--}}
            {{--            $.each(response.party, function(index, party) {--}}
            {{--                $('#party').append('<option value="' + party.party_id + '">' + party.party_name + '</option>');--}}
            {{--            });--}}
            {{--            // Clear and append new data for "products"--}}
            {{--            $('#parts').empty().append('<option value="" selected disabled>Select Product</option>');--}}

            {{--            $.each(response.parts, function(index, part) {--}}
            {{--                $('#parts').append('<option value="' + part.par_id + '" data-stock="' + part.par_total_qty + '" data-rate="' + part.par_purchase_price + '">' + part.par_name + '</option>');--}}
            {{--            });--}}
            {{--            $('#rate').val('');--}}
            {{--            $('#account_total').val('');--}}
            {{--        }--}}
            {{--    });--}}
            {{--});--}}

            $("#account").select2();

            $(".select2-selection--single").focus();

            $("#parts").select2();
            $("#purchase_invoice").select2();

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


            add_sale_row(counter, parts, parts_name, qty, rate, amount, discount, total);


        }


        function add_sale_row(counter, parts, parts_name, qty, rate, amount, discount, total) {


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

                '<a href="javascript:void()" onclick="delete_sale(' + counter + ')" data-toggle="tooltip" data-placement="top" title="Close"><i class="fas fa-times color-danger"></i></a>' +

                '</span>' +

                '</td>' +


                '</tr>');

            $("#parts").val('aaa');


            var total = $("#tamount").val();

            var grand = $("#grand_total").val();

            // var total_cal = parseFloat(grand) + parseFloat(total);


            var total_float = parseFloat(total);

            var grand_float = parseFloat(grand);


            var total_cal = grand_float + total_float;


            // alert(parseFloat(total_cal));

            $("#grand_total").val(total_cal);


            $("#qty").val('');

            $("#rate").val('');

            $("#amount").val('');

            $("#discount").val('');

            grand_total_calculation_with_disc_amount();


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

        // Change the selector if needed

        var $table = $('table'),

            $bodyCells = $table.find('tbody tr:first').children(),

            colWidth;


        // Get the tbody columns width array

        colWidth = $bodyCells.map(function () {

            return $(this).width();

        }).get();


        // Set the width of thead columns

        $table.find('thead tr').children().each(function (i, v) {

            $(v).width(colWidth[i]);

        });


        // Adjust the width of thead cells when *window* resizes

        $(window).resize(function () {

            /* Same as before */

        }).resize(); // Trigger the resize handler once the script runs


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


            $("#grand_total").val(grand_total)

            $("#total_item").val(item_total)


        }


        function check() {


            var tt = $("#total_item").val();


            if (tt == 0) {

                document.getElementById("alert").style.display = "block";

                return false;

            }


            var val1 = $("#grand_total").val();

            var acc_total = $("#account_total").val();

            var pay_amount = $("#p_amount").val();

            if (val1 < 0) {

                // document.getElementById("alert").style.display = "block";

                alert("Grand Total is Negative");

                return false;

            }

            if (parseFloat(pay_amount) > parseFloat(acc_total)) {

                // document.getElementById("alert").style.display = "block";

                alert("Do not have enough cash in Account");

                return false;

            }


            var bol;

            $('input[name="tamount[]"]').each(function (pro_index) {


                let value = $(this).val();

                if (value < 0) {

                    alert("Total of Part is Negative");

                    // document.getElementById("alert").style.display = "block";

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


                return true;

            }

        }

        $("#account").change(function () {
            var rate = jQuery('option:selected', this).attr('data-balance');
            $('#account_total').val(`${rate}`);
        });
    </script>



    @if (Session::has('pi_id'))
        <script>
            // alert("id mill gai");


            jQuery("#table_body").html("");


            var id = '{{ Session::get('pi_id') }}';


            $('.modal-body').load('{{ url('purchase_invoice_modal_view_details/view/') }}' + '/' + id, function () {

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
        </script>
    @endif

@stop
