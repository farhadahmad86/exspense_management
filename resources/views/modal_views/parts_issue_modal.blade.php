
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
{{--    <div class="content-body">--}}
{{--        <div class="container-fluid">--}}
{{--            <div class="row page-titles mx-0">--}}
{{--                <div class="col-sm-6 p-md-0">--}}
{{--                    <div class="welcome-text">--}}
{{--                        <h4>Hi, welcome back!</h4>--}}
{{--                        <p class="mb-1">Job Part Registration List</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">--}}
{{--                    <ol class="breadcrumb">--}}
{{--                        <li class="breadcrumb-item"><a href="javascript:void(0)">Registration</a></li>--}}
{{--                        <li class="breadcrumb-item"><a href="javascript:void(0)">Job Part Registration</a></li>--}}
{{--                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Create Job Part Registration</a></li>--}}
{{--                    </ol>--}}
{{--                </div>--}}
{{--            </div>--}}
        @include('inc._message')
        <!-- row -->


{{--<div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-12">--}}
{{--                    <div class="card">--}}
{{--                        <div class="card-header">--}}
{{--                            <h4 class="card-title">Basic Datatable</h4>--}}
{{--                        </div>--}}
{{--                        <div class="card-body">--}}


                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered display" style="min-width: 100%">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Part Name</th>
                                        <th scope="col">Quantity</th>

                                    </tr>
                                    </thead>
                                    <tbody>

                                    @php
                                        $sr = 1
                                    @endphp

                                    @foreach($items as $brand)
                                        <tr>
                                            <td>{{$sr}}</td>
                                            <td>{{$brand->par_name}}</td>
                                            <td>{{$brand->iptji_qty}}</td>
                                        </tr>
                                        @php
                                        $sr++
                                    @endphp
                                    @endforeach
                                    </tbody>

                                </table>
                            </div>
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--</div>--}}

{{--        </div>--}}
{{--    </div>--}}
    <!--**********************************
        Content body end
    ***********************************-->
</body>

</html>
