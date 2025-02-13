@extends('layouts.app', ['page' => __('Product Recover List'), 'pageSlug' => 'users', 'section' => 'users'])

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
                        <p class="mb-1">Product Recover List</p>
                    </div>
                </div>
            </div>
            @include('inc._message')
            <!-- row -->



            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Product Recover List</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('product_recover.index') }}" method="get">

                                <div class="row">

                                    <div class="col-1-5">
                                        <div class="form-group mb-0">
                                            <label for="">Product Name </label>
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
                                    <x-date-filter label="From" id="from_date" name="from_date" value="{{$from_date}}"/>
                                    <x-date-filter label="To" id="to_date" name="to_date" value="{{$to_date}}"/>
                                    <div class="col-0-5">
                                        <div class="form-group" style="margin-bottom: 10px;">
                                            <label for=""></label>
                                        </div>
                                        <div class="form-group">
                                            <a href="{{ route('product_recover.index') }}" class="btn btn-primary btn-sm"
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
                                            <th>PR #</th>
                                            <th>Product Name</th>
                                            <th>Product Quantity</th>
                                            <th>Remarks</th>
                                            <th>Created By</th>
                                            <th>Created At</th>
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
                                        @foreach ($query as $product_recover)
                                            <tr>
                                                <td>{{ $sr }}</td>
                                                <td>{{ $product_recover->pr_inv_id }}</td>
                                                <td>{{ $product_recover->par_name }}</td>
                                                <td>{{ $product_recover->pr_qty }}</td>
                                                <td>{{ $product_recover->pr_remarks }}</td>
                                                <td>{{ $product_recover->name }}</td>
                                                <td>{{ date('d-m-Y', strtotime($product_recover->pr_created_at)) }}</td>
                                                {{--                                            <td><a href="{{route('product_recover.edit',$product_recover->pr_id)}}"><i class="fas fa-edit"></i></a></td> --}}

                                            </tr>

                                            @php
                                                $sr++;
                                                !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                                            @endphp
                                        @endforeach


                                    </tbody>

                                </table>
                            </div>
                            {{ $query->appends(['segmentSr' => $countSeg, 'part_name' => $part_name, 'from_date' => $from_date, 'to_date' => $to_date])->links() }}
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
        });
    </script>
@stop
