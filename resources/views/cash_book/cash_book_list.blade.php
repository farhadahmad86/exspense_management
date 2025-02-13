@extends('layouts.app', ['page' => __('Cash Book List'), 'pageSlug' => 'users', 'section' => 'users'])

@section('content')



    <style>
        .col-1-5 {
            flex: 0 0 12.6%;
            max-width: 12.6%;
            position: relative;
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
        }

        .w-5 {
            width: 2% !important;
        }

        .leading-5 {
            margin-bottom: 0 !important;
            margin-top: 8px !important;
        }

        .border {
            border: none !important;
        }
    </style>
    <style>
        .col-1-5 {
            flex: 0 0 12.6%;
            max-width: 12.6%;
            position: relative;
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
        }

        .col-0-5 {
            flex: 0 0 3.6%;
            max-width: 6.6%;
            position: relative;
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
        }

        /* farhad add */
        .rec {
            margin: none;
            font-size: 18px;
        }

        .rec p {
            line-height: 40px
        }

        .tr_line {
            line-height: 4px;
        }

        .centered {
            text-align: center;
            align-content: center;
        }

        .content-line {
            line-height: 25px !important;
        }


        .ticket {
            width: 155px;
            max-width: 155px;
        }

        img {
            max-width: inherit;
            width: inherit;
        }

        .img-center {
            margin: 10px auto;
            display: block;
            width: 300px;
            height: 130px;
        }



        .job_tr {
            border: 2px solid;
            line-height: 3px !important;
        }

        .job_t th {
            white-space: nowrap;
        }

        .urdu {
            color: black;
            font-size: 20px;
            font-family: 'Noto Nastaliq Urdu Draft', serif !important;
        }

        .english {
            color: black;
            font-family: Arial, Verdana, Helvetica, sans-serif;
        }

        .job_name {
            line-height: 30px !important;

        }

        .w-5 {
            width: 2% !important;
        }

        .leading-5 {
            margin-bottom: 0 !important;
            margin-top: 8px !important;
        }

        .border {
            border: none !important;
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
                        <p class="mb-1">Cash Book List</p>
                    </div>
                </div>
            </div>
            @include('inc._message')
            <!-- row -->



            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Cash Book List</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('cash_book_list') }}" method="get">

                                <div class="row">
                                    <div class="col-1-5">
                                        <div class="form-group mb-0">
                                            <label for="">Job #</label>
                                            <input type="text" tabindex="1" id="job_no" name="job_no"
                                                class="form-control form-control-sm" value="{{ $job_no }}">
                                        </div>
                                    </div>
                                    <div class="col-1-5">
                                        <div class="form-group mb-0">
                                            <label for="">Account Name</label>
                                            <select id="account_name" name="account_name">
                                                <option value="0" selected disabled>Select Account</option>
                                                @foreach ($cash_title as $index => $cash)
                                                    <option value="{{ $cash->ca_id }}"
                                                        {{ $account_name == $cash->ca_id ? 'selected' : '' }}>
                                                        {{ $cash->ca_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class=" col-1-5">
                                        <div class="form-group">
                                            <label class="" for="">Type</label>

                                            <select id="status" name="status">
                                                {{-- <option value="0" selected disabled>Select</option> --}}

                                                <option value="" selected disabled>Select Type</option>
                                                <option value="Opening_Stock"
                                                    {{ $status === 'Opening_Stock' ? 'selected' : '' }}>Cash Opening
                                                </option>
                                                <option value="Purchase_Invoice"
                                                    {{ $status === 'Purchase_Invoice' ? 'selected' : '' }}>Purchase Invoice
                                                </option>
                                                <option value="Sale_Invoice"
                                                    {{ $status === 'Sale_Invoice' ? 'selected' : '' }}>Sale Invoice
                                                </option>
                                                <option value="Job Invoice"
                                                    {{ $status === 'Job Invoice' ? 'selected' : '' }}>
                                                    Job Invoice
                                                </option>
                                                <option value="Cash_Receipt"
                                                    {{ $status === 'Cash_Receipt' ? 'selected' : '' }}>Cash Receipt
                                                </option>
                                                <option value="Cash_Payment"
                                                    {{ $status === 'Cash_Payment' ? 'selected' : '' }}>Cash Payment
                                                </option>

                                            </select>
                                        </div>
                                    </div>
                                    <x-date-filter label="From" id="from_date" name="from_date"
                                        value="{{ $from_date }}" />
                                    <x-date-filter label="To" id="to_date" name="to_date"
                                        value="{{ $to_date }}" />
                                    <div class="col-0-5">
                                        <div class="form-group" style="margin-bottom: 10px;">
                                            <label for=""></label>
                                        </div>
                                        <div class="form-group">
                                            <a href="{{ route('cash_book_list') }}" class="btn btn-primary btn-sm"
                                                id="">
                                                Clear
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-1-5">
                                        <div class="form-group" style="margin-bottom: 10px;">
                                            <label for=""></label>
                                        </div>
                                        <div class="form-group">
                                            <button tabindex="8" class="btn btn-primary btn-sm" id="customer_search">
                                                Search
                                            </button>
                                        </div>
                                    </div>





                                </div>
                                {{--                                <div class="row"> --}}

                                {{--                                    <div class="col-1-5"> --}}
                                {{--                                        <div class="form-group"> --}}
                                {{--                                            <label for="">Account#</label> --}}
                                {{--                                        </div> --}}
                                {{--                                    </div> --}}



                                {{--                                    <div class="col-1-5"> --}}
                                {{--                                        <label class="float-left" for="">Date From</label> --}}
                                {{--                                    </div> --}}

                                {{--                                    <div class="col-1-5"> --}}
                                {{--                                        <label class="float-left" for="">Date To</label> --}}
                                {{--                                    </div> --}}




                                {{--                                </div> --}}



                                {{--                                --}}{{--                second --}}
                                {{--                                <div class="row"> --}}

                                {{--                                    <div class="col-1-5"> --}}
                                {{--                                        <div class="form-group mb-0"> --}}
                                {{--                                            <input type="text" tabindex="1" id="job_no" name="job_no" class="form-control form-control-sm" --}}
                                {{--                                                   value="{{$job_no}}"> --}}
                                {{--                                        </div> --}}
                                {{--                                    </div> --}}


                                {{--                                    <div class=" col-1-5"> --}}
                                {{--                                        <input type="date" tabindex="6" name="from_date" class="form-control date advance_search form-control-sm" --}}
                                {{--                                               value="{{$from_date}}" id="from_date" placeholder="Choose..."> --}}
                                {{--                                    </div> --}}



                                {{--                                    <div class=" col-1-5"> --}}
                                {{--                                        <input type="date" name="to_date" tabindex="7" class="form-control date advance_search form-control-sm" --}}
                                {{--                                               value="{{$to_date}}" id="to_date" placeholder="Choose..."> --}}
                                {{--                                    </div> --}}




                                {{--                                    <div class="col"> --}}
                                {{--                                        <div class="form-group"> --}}
                                {{--                                            <button tabindex="8" class="btn btn-primary btn-sm" id="customer_search"> --}}
                                {{--                                                Search --}}
                                {{--                                            </button> --}}
                                {{--                                        </div> --}}
                                {{--                                    </div> --}}

                                {{--                                </div> --}}


                            </form>




                            <div class="table-responsive">
                                <table id="" class="table table-striped table-bordered display"
                                    style="min-width: 845px">
                                    <thead>
                                        <tr>

                                            <th>Sr#</th>
                                            <th>Account</th>
                                            {{--                                        <th>Job</th> --}}

                                            <th>Job#</th>
                                            <th>Type</th>
                                            <th>Ref. #</th>
                                            <th>In (Rs)</th>

                                            <th>Out (Rs)</th>
                                            {{--                                        <th>Credit (Rs)</th> --}}
                                            <th>Total</th>

                                            <th>Date</th>


                                        </tr>
                                    </thead>
                                    <tbody>

                                        @php
                                            $segmentSr = !empty(app('request')->input('segmentSr')) ? app('request')->input('segmentSr') : '';
                                            $segmentPg = !empty(app('request')->input('page')) ? app('request')->input('page') : '';
                                            $sr = !empty($segmentSr) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                                            $countSeg = !empty($segmentSr) ? $segmentSr : 0;
                                            $prchsPrc = $slePrc = $avrgPrc = 0;
                                        @endphp



                                        @foreach ($query as $index => $brand)
                                            <tr>
                                                {{--                                            <td>{{$sr}}</td> --}}
                                                <td>{{ $sr }}</td>
                                                <td>{{ $brand->ca_name }}</td>
                                                {{--                                            <td>{{$brand->cb_job_id}}</td> --}}
                                                <td onclick="thermal_print({{ $brand->cb_job_id }})"
                                                    style="color:#007bff;cursor: pointer;white-space: nowrap;">
                                                    {{ $brand->cb_job_id }}</td>
                                                <td>
                                                    @if ($brand->cb_type == 'Opening_Stock')
                                                    {{'Cash Opening'}}
                                                    @else
                                                    {{ $brand->cb_type }}
                                                   @endif
                                                </td>
                                                @if ($brand->cb_type == 'Opening_Stock')
                                                    <td>{{ '' }}</td>
                                                @else
                                                    <td class="view" data-id="{{ $brand->cb_type_id }}"
                                                        data-type="{{ $brand->cb_type }}"
                                                        style="color:#007bff;cursor: pointer">
                                                        @if ($brand->cb_type == 'Sale_Invoice')
                                                            SI-
                                                        @elseif ($brand->cb_type == 'Purchase_Invoice')
                                                            PI-
                                                        @elseif ($brand->cb_type == 'Job Invoice')
                                                            JI-
                                                        @elseif ($brand->cb_type == 'Cash_Payment')
                                                            CP-
                                                        @elseif ($brand->cb_type == 'Cash_Receipt')
                                                            CR-
                                                        @endif
                                                        {{ $brand->cb_type_id }}
                                                    </td>
                                                @endif


                                                <td>{{ $brand->cb_in }}</td>
                                                <td>{{ $brand->cb_out }}</td>

                                                {{--                                            <td>{{$brand->cb_credit}}</td> --}}
                                                <td>{{ $brand->cb_total }}</td>
                                                <td>{{ date('d-m-Y', strtotime($brand->cb_created_at)) }}</td>


                                            </tr>

                                            @php
                                                $sr++;
                                                !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                                            @endphp
                                        @endforeach


                                    </tbody>

                                </table>
                            </div>
                            {{ $query->appends(['segmentSr' => $countSeg, 'account_name' => $account_name, 'status' => $status, 'from_date' => $from_date, 'to_date' => $to_date, 'job_no' => $job_no])->links() }}
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
    <!--**********************************
                                                            Content body end
                                                        ***********************************-->
    {{-- farhad add --}}
    <!-- Modal -->
{{--    <div class="modal fade rec" id="exampleModall" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
{{--        <div class="modal-dialog">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header hidden-print">--}}
{{--                    <h5 class="modal-title" id="exampleModalLabel">Sales Invoice Detail</h5>--}}
{{--                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
{{--                </div>--}}
{{--                <div class="modal-body" id="body_print">--}}
{{--                    @include('job_info.customfile')--}}
{{--                </div>--}}
{{--                <div class="modal-footer">--}}
{{--                    --}}{{-- <button type="button" class="btn btn-secondary hidden-print" data-bs-dismiss="modal">Close</button> --}}
{{--                    <button id="btnPrint" class="btn btn-success hidden-print" style="display: none">Print</button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    {{-- farhad add --}}
    {{-- For part Ref. --}}
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg mdl_wdth">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    {{-- <h4 class="modal-title text-black">Parts Issue Detail</h4> --}}
{{--                    <button type="button" class="close" data-dismiss="modal">&times;</button>--}}
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
        $(document).ready(function() {
            $('#account_name').select2();
            $('#status').select2();
            $('#form').validate({ // initialize the plugin

                rules: {
                    brand: {
                        required: true,

                    }
                },
                messages: {
                    brand: {
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
    <script>
        // jQuery("#invoice_no").blur(function () {
        jQuery(".view").click(function() {
            jQuery("#table_body").html("");

            var id = jQuery(this).attr("data-id");
            var type = jQuery(this).attr("data-type");
            if (type == 'Issue') {
                $('.modal-body').load('{{ url('part_issue_modal_view_details/view/') }}' + '/' + id, function() {
                    $('#myModal').modal({
                        show: true
                    });
                });
            } else if (type == 'Sale_Invoice') {
                $('.modal-body').load('{{ url('sale_invoice_modal_view_details/view/') }}' + '/' + id, function() {
                    $('#myModal').modal({
                        show: true
                    });
                });
            } else if (type == 'Purchase_Invoice') {
                $('.modal-body').load('{{ url('purchase_invoice_modal_view_details/view/') }}' + '/' + id,
                    function() {
                        $('#myModal').modal({
                            show: true
                        });
                    });
            } else if (type == 'Job Invoice') {
                $('.modal-body').load('{{ url('sale_job_invoice_modal_view_details/view/') }}' + '/' + id,
                    function() {
                        $('#myModal').modal({
                            show: true
                        });
                    });
            } else if (type == 'Cash_Payment') {
                $('.modal-body').load('{{ url('cash_payment_modal_view_details/view/') }}' + '/' + id, function() {
                    $('#myModal').modal({
                        show: true
                    });
                });
            } else if (type == 'Cash_Receipt') {
                $('.modal-body').load('{{ url('cash_receipt_modal_view_details/view/') }}' + '/' + id, function() {
                    $('#myModal').modal({
                        show: true
                    });
                });
            } else {
                alert(1)
            }
        });
    </script>
@stop
