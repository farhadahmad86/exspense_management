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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Sale Invoice For Jobs List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="" class="table table-striped table-bordered display"
                                    style="min-width: 845px">
                                    <thead>
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Invoice#</th>
                                            <th>Job No</th>
                                            <th>Client Name</th>
                                            <th>Client Number</th>
                                            <th>Job Title</th>
                                            <th>Cash Account</th>
                                            <th>Job Cost</th>
                                            <th>Paid Amount</th>
                                            <th>Discount</th>
                                            <th>Remaining Balance</th>
                                            <th>Remarks</th>
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
                                        @foreach ($query as $sale_invoice_for_jobs)
                                            <tr>
                                                <td>{{ $sr }}</td>
                                                <td data-id="{{ $sale_invoice_for_jobs->sifj_id }}">
                                                    {{ $sale_invoice_for_jobs->sifj_id }}</td>
                                                <td>{{ $sale_invoice_for_jobs->sifj_job_no }}</td>
                                                <td>{{ $sale_invoice_for_jobs->cli_name }}</td>
                                                <td>{{ $sale_invoice_for_jobs->cli_number }}</td>
                                                <td>{{ $sale_invoice_for_jobs->ji_title }}</td>
                                                <td>{{ $sale_invoice_for_jobs->ca_name }}</td>
                                                <td>{{ $sale_invoice_for_jobs->sifj_real_estimated_cost }}</td>
                                                <td>{{ $sale_invoice_for_jobs->sifj_amount_paid }}</td>
                                                <td>{{ $sale_invoice_for_jobs->sifj_discount }}</td>

                                                <td>{{ $sale_invoice_for_jobs->sifj_remaining_cost }}</td>
                                                <td>{{ $sale_invoice_for_jobs->sifj_remarks }}</td>
                                                <td>{{ date('d-m-Y', strtotime($sale_invoice_for_jobs->sifj_created_at)) }}
                                                </td>
                                                {{--                                            <td>{{$sale_invoice_for_jobs->sifj_updated_at}}</td> --}}
                                                {{--                                            <td><a href="{{route('sale_invoice_for_jobs.edit',$sale_invoice_for_jobs->sifj_id)}}"><button type="button"  class="btn btn-primary" >Edit</button></a></td> --}}

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
