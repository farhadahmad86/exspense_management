@extends('layouts.app', ['page' => __('Sale Invoice List'), 'pageSlug' => 'users', 'section' => 'users'])

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
        .table .table {
            background-color: white !important;
        }
        .cancel_button{
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
                        <p class="mb-1">Sale Invoice List</p>
                    </div>
                </div>
            </div>
            @include('inc._message')
            <!-- row -->


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Sale Invoice List</h4>
                        </div>
                        <div class="card-body">

                            <form action="{{ route('sale_invoice.index') }}" method="get">


                                <div class="row">

                                    <div class="col-1-5">
                                        <div class="form-group mb-0">
                                            <label for="">Invoice #</label>
                                            <input type="text" tabindex="1" id="job_no" name="job_no"
                                                   class="form-control form-control-sm" value="{{ $job_no }}">
                                        </div>
                                    </div>
                                    <x-date-filter label="From" id="from_date" name="from_date" value="{{$from_date}}"/>
                                    <x-date-filter label="To" id="to_date" name="to_date" value="{{$to_date}}"/>
                                    <div class="col-0-5">
                                        <div class="form-group" style="margin-bottom: 10px;">
                                            <label for=""></label>
                                        </div>
                                        <div class="form-group">
                                            <a href="{{route('sale_invoice.index')}}" class="btn btn-primary btn-sm"
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
                            </form>


                            <div class="table-responsive">
                                <table id="" class="table table-striped table-bordered display"
                                       style="min-width: 845px">
                                    <thead>
                                    <tr>
                                        <th>Sr#</th>
                                        <th>Invoice</th>
                                        <th>Account</th>
                                        <th>Party</th>
                                        <th>Remarks</th>
                                        <th>Items</th>
                                        <th>Total</th>
                                        <th>Amount Pay</th>
                                        <th>Remaining</th>
                                        <th>Status</th>
                                        <th>Date</th>

                                        <th>Action</th>

                                        {{--                                        <th>Updated At</th> --}}
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



                                    @foreach ($query as $brand)
                                        <tr>
                                            <td>{{ $sr }}</td>
                                            <td class="view" data-id="{{ $brand->si_inv_id }}"
                                                style="color:#007bff;cursor: pointer">{{ $brand->si_inv_id }}</td>
                                            <td>{{ $brand->ca_name }}</td>
                                            <td>{{ $brand->party_name }}</td>
                                            <td>{{ $brand->si_remarks }}</td>
                                            <td>{{ $brand->si_total_items }}</td>

                                            <td>{{ $brand->si_grand_total }}</td>
                                            <td>{{ $brand->si_amount_pay }}</td>
                                            <td>{{ $brand->si_remaining }}</td>
                                            <td>{{ $brand->si_status }}</td>
                                            <td>{{ date('d-m-Y h:m:s', strtotime($brand->si_created_at)) }}</td>

                                            @if ($brand->si_status == 'Credit')
                                                <td><a href="{{ route('add_credit_sale', $brand->si_id) }}"><i
                                                            class="fas fa-edit"></i></a></td>
                                            @else
                                                <td></td>
                                            @endif
                                            {{--                                            <td>{{$brand->si_created_at}}</td> --}}

                                        </tr>

                                        @php
                                            $sr++;
                                            !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                                        @endphp
                                    @endforeach


                                    </tbody>

                                </table>
                            </div>
                            {{ $query->appends(['segmentSr' => $countSeg, 'job_no' => $job_no,  'from_date' => $from_date, 'to_date' => $to_date])->links() }}
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
        jQuery(".view").click(function () {

            jQuery("#table_body").html("");

            var id = jQuery(this).attr("data-id");

            $('.modal-body').load('{{ url('sale_invoice_modal_view_details/view/') }}' + '/' + id, function () {
                $('#myModal').modal({
                    show: true
                });
            });

        });
    </script>

    <script>
        $(document).ready(function () {
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
