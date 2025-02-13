@extends('layouts.app', ['page' => __('Stock Report'), 'pageSlug' => 'users', 'section' => 'users'])

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
                        <p class="mb-1">Stock Report</p>
                    </div>
                </div>
            </div>
            @include('inc._message')
            <!-- row -->



            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Stock Report</h4>
                        </div>
                        <div class="card-body">

                            <form action="{{ route('stock_report') }}" method="get">

                                <div class="row">
                                    <div class="col-1-5">
                                        <div class="form-group mb-0">
                                            <label for="">Product Name</label>
                                            {{-- <input type="text" tabindex="1" id="part_name" name="part_name"
                                                class="form-control form-control-sm" value="{{ $part_name }}"> --}}
                                            <select id="part_name" name="part_name">
                                                <option value="0" selected disabled>Select Product</option>
                                                @foreach ($parts_title as $index => $part)
                                                    <option value="{{ $part->par_id }}"
                                                        {{ $part_name == $part->par_id ? 'selected' : '' }}>
                                                        {{ $part->par_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    {{-- <div class="col-1-5">
                                        <div class="form-group mb-0">
                                            <label for="">Job #</label>
                                            <input type="text" tabindex="1" id="job_no" name="job_no"
                                                class="form-control form-control-sm" value="{{ $job_no }}">
                                        </div>
                                    </div> --}}
                                    {{-- <x-date-filter label="From" id="from_date" name="from_date"
                                        value="{{ $from_date }}" />
                                    <x-date-filter label="To" id="to_date" name="to_date"
                                        value="{{ $to_date }}" /> --}}
                                    <div class="col-0-5">
                                        <div class="form-group" style="margin-bottom: 10px;">
                                            <label for=""></label>
                                        </div>
                                        <div class="form-group">
                                            <a href="{{ route('stock_report') }}" class="btn btn-primary btn-sm"
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
                                    <div class="col-0-5" style="margin-top: 33px;">
                                        <div class="form-group">
                                            <button tabindex="8" class="btn btn-primary btn-sm" id="pdf_download"
                                                name="pdf_download" value="1">
                                                Download
                                            </button>
                                        </div>
                                    </div>




                                </div>



                                {{--                second --}}
                                <div class="row">

                                    <div class="col-1-5">

                                    </div>


                                    <div class=" col-1-5">

                                    </div>



                                    <div class=" col-1-5">

                                    </div>






                                </div>


                            </form>





                            <div class="table-responsive">
                                <table id="" class="table table-striped table-bordered display"
                                    style="min-width: 845px">
                                    <thead>
                                        <tr>

                                            <th>Sr#</th>
                                            <th>Part</th>
                                            {{-- <th>Job</th> --}}
                                            {{-- <th>Type</th> --}}
                                            <th>Total Qty</th>
                                            <th>Last Purchase Rate</th>
                                            {{-- <th>Amount</th> --}}
                                            {{-- <th>Stock Out Qty</th> --}}
                                            {{-- <th>Rate</th> --}}
                                            {{-- <th>Amount</th> --}}

                                            {{--                                        <th>Stock Hold Qty</th> --}}
                                            {{-- <th>Job Hold Qty</th> --}}
                                            {{-- <th>Rate</th> --}}
                                            {{-- <th>Amount</th> --}}

                                            <th>Total</th>
                                            {{-- <th>Date</th> --}}
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
                                                <td>{{ $brand->par_name }}</td>
                                                {{-- <td>{{ $brand->sto_job_id }}</td> --}}
                                                {{-- <td>{{ $brand->sto_type }}</td> --}}
                                                <td>{{ $brand->sto_total }}</td>
                                                <td>{{ $brand->par_purchase_price }}</td>
                                                {{-- <td>{{ $brand->sto_in_amount }}</td> --}}
                                                {{-- <td>{{ $brand->sto_out }}</td> --}}
                                                {{-- <td>{{ $brand->sto_out_rate }}</td> --}}
                                                {{-- <td>{{ $brand->sto_out_amount }}</td> --}}
                                                {{-- <td>{{ $brand->sto_hold }}</td> --}}
                                                {{-- <td>{{ $brand->sto_hold_rate }}</td> --}}
                                                {{-- <td>{{ $brand->sto_hold_amount }}</td> --}}
                                                <td>{{ $brand->sto_total * $brand->par_purchase_price  }}</td>
                                                {{-- <td>{{ date('d-m-Y', strtotime($brand->sto_created_at)) }}</td> --}}

                                            </tr>

                                            @php
                                                $sr++;
                                                !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                                            @endphp
                                        @endforeach


                                    </tbody>

                                </table>
                            </div>
                            {{ $query->appends(['segmentSr' => $countSeg, 'job_no' => $job_no, 'from_date' => $from_date, 'to_date' => $to_date, 'part_name' => $part_name])->links() }}
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
        $(document).ready(function() {
        $('#part_name').select2();
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
@stop
