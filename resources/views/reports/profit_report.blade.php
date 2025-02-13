@extends('layouts.app', ['page' => __('Profit Report'), 'pageSlug' => 'users', 'section' => 'users'])

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
                        <p class="mb-1">Profit Report</p>
                    </div>
                </div>
            </div>
            @include('inc._message')
            <!-- row -->



            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Profit Report</h4>
                        </div>
                        <div class="card-body">

                            <form action="{{ route('Profit_Report') }}" method="get">

                                <div class="row">
                                    <div class="col-1">
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

                                    <div class="col-1-5">
                                        <div class="form-group mb-0">
                                            <label for=""></label>
                                        </div>
                                    </div>

                                </div>
                                {{--                second --}}
                                <div class="row">
                                    <div class=" col-1-5">
                                        <div class="form-group">
                                            <label class="" for="">Products</label>
                                            <select id="product" name="product">
                                                <option value="0" selected disabled>Select Products</option>
                                                @foreach ($product_title as $index => $product)
                                                    <option value="{{ $product->par_id }}"
                                                        {{ $products == $product->par_id ? 'selected' : '' }}>
                                                        {{ $product->par_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <x-date-filter label="From" id="from_date" name="from_date"
                                                   value="{{ $from_date }}" />
                                    <x-date-filter label="To" id="to_date" name="to_date"
                                                   value="{{ $to_date }}" />
                                    <div class="col-0-5" style="margin-top: 2rem !important;">
                                        <div class="form-group">
                                            <a href="{{ route('Profit_Report') }}" class="btn btn-primary btn-sm"
                                               id="">
                                                Clear
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col" style="margin-top: 2rem !important;">
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
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Profit</th>
                                        {{--                                            <th>Status</th>--}}
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
                                        @php
                                            $purchase = $brand->product_purchase * $brand->sii_qty;
                                            $sale = $brand->sii_rate * $brand->sii_qty;
                                            $profit = $sale-$purchase;
                                        @endphp
                                        <tr>

                                            <td>{{ $sr }}</td>
                                            <td>{{ $brand->product_name }}</td>
                                            <td>{{ $brand->sii_qty }}</td>
                                            <td>{{ $brand->sii_rate }}</td>
                                            <td>{{ $profit }}</td>
                                            {{--                                                <td>{{ $brand->si_status }}</td>--}}
                                            <td>{{ date('d-m-Y', strtotime($brand->si_created_at)) }}</td>
                                        </tr>

                                        @php
                                            $sr++;
                                            !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                                        @endphp
                                    @endforeach


                                    </tbody>
                                    <tr>
                                        {{-- <td>{{$total_amount}}</td> --}}
                                    </tr>
                                </table>
                            </div>
                            {{ $query->appends(['segmentSr' => $countSeg, 'product' => $products,'from_date' => $from_date, 'to_date' => $to_date])->links() }}
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
            $("#product").select2();

        });
    </script>
@stop
