@extends('layouts.app', ['page' => __('Credit Sale List'), 'pageSlug' => 'users', 'section' => 'users'])

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




    <!--**********************************
                Content body start
            ***********************************-->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Hi, welcome back!</h4>
                        <p class="mb-1">Sale Invoice Detail List</p>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Sale Invoices</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Sale Invoice Detail List</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Sale Invoice Detail List</a></li>
                    </ol>
                </div>
            </div>
            @include('inc._message')
            <!-- row -->



            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Sale Invoice Detail List</h4>
                            <!-- Ibrahim add -->
                            {{--                        <button > --}}
                            <div class="srch_box_opn_icon">
                                <i id="search_hide" onclick="hide_the_search();" class="fa fa-search icon-hide"></i>
                            </div>
                            {{--                        </button> --}}
                        </div>
                        <div class="card-body">

                            <form action="{{ route('credit_sale_list') }}" method="get">

                                <div class="row">




                                    <div class="col-1-5">
                                        <div class="form-group mb-0">
                                            <label class="" for="">Search</label>
                                        </div>
                                    </div>

                                    <div class="col-1-5">
                                        <div class="form-group mb-0">
                                            <label for=""></label>
                                        </div>
                                    </div>

                                    <div class="col-1">
                                        <div class="form-group mb-0">
                                            <label class="" for=""></label>
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <div class="form-group mb-0">
                                            <label class="" for=""></label>
                                        </div>
                                    </div>

                                    <div class="col-1-5">
                                        <div class="form-group mb-0">
                                            <label for=""></label>
                                        </div>
                                    </div>


                                    <div class="col-1-5">
                                        <div class="form-group mb-0">
                                            <label for=""></label>
                                        </div>
                                    </div>

                                </div>



                                {{--                second --}}
                                <div class="row">

                                    <div class="col-1-5">
                                            <div class="form-group mb-0">
                                            <label for="">Staus</label>
                                            <select type="text" tabindex="1" id="status" name="status"
                                                class="form-control form-control-sm">
                                                <option value="" selected disabled>Select Status</option>
                                                <option value="Paid"
                                                {{$status == 'Paid' ? 'selected' : ''}}>Paid</option>
                                                <option value="Credit"
                                                {{$status == 'Credit' ? 'selected' : ''}}>Credit</option>


                                            </select>
                                        </div>
                                    </div>
                                    <div class=" col-1-5">
                                        <div class="form-group">
                                            <label class="" for="">Sale Invoice#</label>
                                            <input type="text" tabindex="2" onkeypress='validate(event)'
                                            name="sale_invoice" class="form-control form-control-sm" id="sale_invoice" value="{{$sale_invoice}}">
                                        </div>
                                        </div>
                                    <div class=" col-1-5">
                                        <div class="form-group">
                                            <label class="" for="">Account</label>
                                            {{--  --}}
                                            <select id="account_name" name="account_name">
                                                <option value="0" selected disabled>Select Account</option>
                                                @foreach ($cash_title as $index => $cash)
                                                    <option value="{{ $cash->ca_name }}"
                                                        {{ $account_name == $cash->ca_name ? 'selected' : '' }}>
                                                        {{ $cash->ca_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                    <div class=" col-1-5">
                                        <div class="form-group">
                                            <label class="" for="">Invoice#</label>
                                            <input onkeyup="small_than_five(event)" tabindex="4"
                                            onkeypress='validate(event)' type="text" name="invoice"
                                            class="form-control form-control-sm" id="invoice" value="{{$invoice}}">
                                        </div>
                                    </div>
                                    <div class=" col-1-5">
                                        <div class="form-group">
                                            <label class="" for="">Party</label>
                                            <input onkeypress='validate(event)' tabindex="3" type="text" name="party"
                                            class="form-control form-control-sm" id="party" value="{{$party}}">
                                        </div>
                                        </div>
                                    <x-date-filter label="From" id="from_date" name="from_date" value="{{$from_date}}"/>
                                    <x-date-filter label="To" id="to_date" name="to_date" value="{{$to_date}}"/>
                                </div>
                                <div class="row">
                                    <div class="col-0-5 m-3">
                                        <div class="form-group">
                                            <a href="{{route('credit_sale_list')}}" class="btn btn-primary btn-sm" id="">
                                                Clear
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col mt-3">
                                        <div class="form-group">
                                            <button tabindex="8" class="btn btn-primary btn-sm" id="customer_search">
                                                Search
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </form>

                            <div class="table-responsive">
                                <table id="" class="table table-striped table-bordered display"
                                    style="min-width: 845px">
                                    <thead>
                                        <tr>
                                            <th>Sr#</th>
                                            {{-- <th>Invoice#</th> --}}
                                            <th>Sale Invoice#</th>
                                            <th>Cash Account</th>
                                            <th>Party</th>
                                            <th>Remarks</th>
                                            <th>Status</th>
                                            <th>Cost (Rs)</th>
                                            <th>Amount Pay</th>
                                            <th>Discount</th>
                                            <th>Remaining Cost</th>
                                            <th>Date</th>
                                            {{--                                        <th>Created At</th> --}}
                                            {{--                                        <th>Actions</th> --}}
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
                                        @foreach ($query as $sale_invoice_details)
                                            <tr>
                                                <td>{{ $sr }}</td>
                                                {{-- <td>{{ $sale_invoice_details->csi_inv_id }}</td> --}}
                                                <td class="view" data-id="{{ $sale_invoice_details->csi_inv_id }}"
                                                    style="color:#007bff;cursor: pointer">
                                                    {{ $sale_invoice_details->csi_inv_id }}</td>
                                                <td>{{ $sale_invoice_details->ca_name }}</td>
                                                <td>{{ $sale_invoice_details->party_name }}</td>
                                                <td>{{ $sale_invoice_details->csi_remarks }}</td>
                                                <td>{{ $sale_invoice_details->csi_status }}</td>

                                                <td>{{ $sale_invoice_details->csi_real_estimated_cost }}</td>
                                                <td>{{ $sale_invoice_details->csi_amount_paid }}</td>
                                                <td>{{ $sale_invoice_details->csi_discount }}</td>

                                                <td>{{ $sale_invoice_details->csi_remaining_cost }}</td>
                                                <td>{{ date('d-m-Y', strtotime($sale_invoice_details->csi_created_at)) }}
                                                </td>
                                                {{--                                            <td>{{$sale_invoice_details->csi_updated_at}}</td> --}}
                                                {{--                                            <td><a href="{{route('sale_invoice_for_jobs.edit',$sale_invoice_details->csi_id)}}"><button type="button"  class="btn btn-primary" >Edit</button></a></td> --}}

                                            </tr>

                                            @php
                                                $sr++;
                                                !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                                            @endphp
                                        @endforeach


                                    </tbody>

                                </table>
                            </div>
                            {{ $query->appends(['segmentSr' => $countSeg, 'status' => $status ,'invoice' => $invoice, 'sale_invoice' => $sale_invoice , 'account_name' => $account_name , 'party' => $party , 'from_date' => $from_date, 'to_date' => $to_date])->links() }}
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
        // jQuery("#invoice_no").blur(function () {
        jQuery(".view").click(function() {

            jQuery("#table_body").html("");

            var id = jQuery(this).attr("data-id");

            $('.modal-body').load('{{ url('credit_sale_modal_view_details/view/') }}' + '/' + id, function() {
                $('#myModal').modal({
                    show: true
                });
            });

        });
    </script>









    <script>
        $(document).ready(function() {
            $('#account_name').select2();
            $('#status').select2;

        });
    </script>
@stop
