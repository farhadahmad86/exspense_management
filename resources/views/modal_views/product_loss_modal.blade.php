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
    </style>




    <!--**********************************
            Content body start
        ***********************************-->
    {{--    <div class="content-body"> --}}
    {{--        <div class="container-fluid"> --}}
    {{--            <div class="row page-titles mx-0"> --}}
    {{--                <div class="col-sm-6 p-md-0"> --}}
    {{--                    <div class="welcome-text"> --}}
    {{--                        <h4>Hi, welcome back!</h4> --}}
    {{--                        <p class="mb-1">Job Product Registration List</p> --}}
    {{--                    </div> --}}
    {{--                </div> --}}
    {{--                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex"> --}}
    {{--                    <ol class="breadcrumb"> --}}
    {{--                        <li class="breadcrumb-item"><a href="javascript:void(0)">Registration</a></li> --}}
    {{--                        <li class="breadcrumb-item"><a href="javascript:void(0)">Job Product Registration</a></li> --}}
    {{--                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Create Job Product Registration</a></li> --}}
    {{--                    </ol> --}}
    {{--                </div> --}}
    {{--            </div> --}}
    @include('inc._message')
    <!-- row -->


    {{-- <div class="container"> --}}
    {{--            <div class="row"> --}}
    {{--                <div class="col-12"> --}}
    {{--                    <div class="card"> --}}
    {{--                        <div class="card-header"> --}}
    {{--                            <h4 class="card-title">Basic Datatable</h4> --}}
    {{--                        </div> --}}
    {{--                        <div class="card-body"> --}}


    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered display" style="min-width: 100%">
            <thead>
                <tr>

                    <th>Sr#</th>
                    <th>Product Name</th>
                    <th>Product Quantity</th>
                    <th>Remarks</th>
                    <th>Created By</th>
                    <th>Updated At</th>
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
                @foreach ($items as $product_loss)
                    <tr>
                        <td>{{ $sr }}</td>

                        <td>{{ $product_loss->par_name }}</td>
                        <td>{{ $product_loss->pl_qty }}</td>
                        <td>{{ $product_loss->pl_remarks }}</td>
                        <td>{{ $product_loss->name }}</td>
                        <td>{{ date('d-m-Y', strtotime($product_loss->pl_created_at)) }}</td>
                        {{--                                            <td><a href="{{route('product_loss.edit',$product_loss->pl_id)}}"><i class="fas fa-edit"></i></a></td> --}}
                    </tr>

                    @php
                        $sr++;
                        !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                    @endphp
                @endforeach


            </tbody>


        </table>
    </div>
    {{--                        </div> --}}
    {{--                    </div> --}}
    {{--                </div> --}}
    {{--            </div> --}}

    {{-- </div> --}}

    {{--        </div> --}}
    {{--    </div> --}}
    <!--**********************************
        Content body end
    ***********************************-->
</body>

</html>
