@extends('layouts.theme_list')

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

        .quixnav,
        .header,
        .nav-header {
            display: none;
        }

        .content-body {
            margin-left: 0 !important;
            padding-top: 2rem !important;
        }

        tbody tr {
            line-height: 0rem;
        }

        th {
            top: 0 !important;
        }
    </style>




    <!--**********************************
                                    Content body start
                                ***********************************-->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-lg-12 col-sm-6 p-md-0">
                    <div class="welcome-text text-center mt-3">
                        <h2>Welcome Everyone!<span id="timer" class="float-right"></span></h2>
                    </div>
                </div>
            </div>


            <div class="row">

                @foreach ($jobs as $job)
                    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                        <div class="card">
                            <div class="stat-widget-one card-body">
                                <div class="stat-content d-inline-block">
                                    <div class="stat-text"
                                        style="max-width: 100px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                        <h4>{{ $job->tech_name }}</h4>
                                    </div>
                                    <div class="stat-digit">{{ $job->total_jobs }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            @include('inc._message')
            <!-- row -->



            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="" class="table table-striped table-bordered display"
                                    style="min-width: 845px">
                                    <thead>
                                        <tr>
                                            <th>Job No</th>
                                            <th>Technician Name</th>
                                            {{--                                        <th>Status</th> --}}
                                            <th>Job Title</th>
                                            {{-- <th>Job Start Date</th> --}}
                                            {{-- <th>Job End Date</th> --}}

                                            <th>Technician Start Date</th>
                                            {{-- <th>Job Days</th> --}}
                                            {{-- <th>Technician End Date</th> --}}
                                            <th>Technician Days</th>
                                            <th>Delivery Date</th>
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



                                        @foreach ($query as $index => $brand)
                                            <tr>
                                                <td>{{ $brand->job_id }}</td>
                                                <td>{{ $brand->tech_name }}</td>
                                                <td>{{ $brand->ji_title }}</td>

                                                @php

                                                    $datetime1 = new DateTime(date('d-m-Y', strtotime($brand->jitt_created_at)));
                                                    $datetime2 = new DateTime(date('d-m-Y'));
                                                    //$datetime2 = new DateTime(date("Y-m-d"));
                                                    //$interval = $datetime2->diff($datetime1);
                                                    $interval = $datetime1->diff($datetime2);
                                                    $days = $interval->format('%a'); //now do whatever you like with $days
                                                    //echo $days;
                                                @endphp

                                                {{--                                            <td>{{date('Y-m-d', strtotime($brand->ji_recieve_datetime))}}</td> --}}


                                                <td>{{ date('d-m-Y H:m:s', strtotime($brand->jitt_created_at)) }}</td>
                                                {{--                                            <td>{{$brand->jitt_created_at}}</td> --}}

                                                {{--                                            <td>{{$days}}</td> --}}
                                                {{--                                            @if (date('d-m-Y', strtotime($brand->jc_created_at)) == '1970-01-01') --}}
                                                {{--                                                <td>Not Completed</td> --}}
                                                {{--                                                <td>{{$not_competed_days}}</td> --}}
                                                {{--                                            @else --}}
                                                {{--                                                <td>{{date('Y-m-d', strtotime($brand->jc_created_at))}}</td> --}}
                                                {{--                                                <td>{{$tech_days}}</td> --}}

                                                {{--                                            @endif --}}



                                                {{--                                            <td>{{date("d-m-Y")}}</td> --}}
                                                <td>{{ $days }}</td>
                                                <td>{{ date('Y-m-d', strtotime($brand->ji_delivery_datetime)) }}</td>

                                                {{--                                            <td>{{$brand->jitt_created_at - date("Y-m-d")}}</td> --}}
                                                {{--                                            <td><a href="{{route('job_info.edit',$brand->ji_id)}}"><i class="fas fa-edit"></i></a></td> --}}

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
@endsection
@section('script')


    <script>
        $(document).ready(function() {
            $("#warranty").select2();
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
            setInterval(function() {
                location.reload()
            }, 30000);
            var time = 30;
            setInterval(function() {
                document.getElementById("timer").innerHTML = time;
                time--;
            }, 1000)
        });
    </script>
@stop
