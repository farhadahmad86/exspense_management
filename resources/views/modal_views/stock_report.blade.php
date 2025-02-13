
<html>
<head></head>
<body>

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

        th,
        td {
            border: 1px solid;
            border-collapse: collapse;
        }
    </style>




    <!--**********************************
                            Content body start
                        ***********************************-->
    <div class="content-body">
        <div class="container-fluid">
            <!-- row -->



            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Stock Report</h4>
                        </div>
                        <div class="card-body">
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
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
    <!--**********************************
                        Content body end
                    ***********************************-->
</body>
</html>
