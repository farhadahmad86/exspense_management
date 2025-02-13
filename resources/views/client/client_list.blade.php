@extends('layouts.app', ['page' => __('Client List'), 'pageSlug' => 'users', 'section' => 'users'])

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
                        <p class="mb-1">Client List</p>
                    </div>
                </div>
            </div>
            @include('inc._message')
            <!-- row -->



            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Client List</h4>
                            <!-- Ibrahim add -->
                            {{--                        <button > --}}
                            <div class="srch_box_opn_icon">
                                <i id="search_hide" onclick="hide_the_search();" class="fa fa-search icon-hide"></i>
                            </div>
                            {{--                        </button> --}}
                        </div>
                        <div class="card-body">

                            <form action="{{ route('client.index') }}" method="get">

                                <div class="row">

                                    <div class="col-1-5">
                                        <div class="form-group mb-0">
                                            <label for="">Name</label>
                                        </div>
                                    </div>

                                </div>



                                {{--                second --}}
                                <div class="row">

                                    <div class="col-1-5">
                                        <div class="form-group mb-0">
                                            {{-- <input  type="text" tabindex="1" id="search" name="search" class="form-control form-control-sm"
                                                    value="{{$search}}"> --}}
                                            <select id="client_name" name="client_name">
                                                <option value="0" selected disabled>Select</option>
                                                @foreach ($client_title as $index => $client)
                                                    <option value="{{ $client->cli_name }}"
                                                        {{ $client_name == $client->cli_name ? 'selected' : '' }}>
                                                        {{ $client->cli_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-0-5">
                                        <div class="form-group">
                                            <a href="{{ route('client.index') }}" class="btn btn-primary btn-sm"
                                                id="">
                                                Clear
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <button tabindex="8" class="btn btn-primary btn-sm" id="customer_search">
                                                Search
                                            </button>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">



                                </div>



                            </form>




                            <div class="table-responsive">
                                <table id="" class="table table-striped table-bordered display"
                                    style="min-width: 845px">
                                    <thead>
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Name</th>
                                            <th>Number</th>
                                            <th>Address</th>
                                            <th>Actions</th>
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
                                                <td>{{ $brand->cli_name }}</td>
                                                <td>{{ $brand->cli_number }}</td>
                                                <td>{{ $brand->cli_address }}</td>
                                                <td><a href="{{ route('client.edit', $brand->cli_id) }}">Edit</a></td>

                                            </tr>

                                            @php
                                                $sr++;
                                                !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                                            @endphp
                                        @endforeach


                                    </tbody>

                                </table>
                            </div>
                            {{ $query->appends(['segmentSr' => $countSeg, 'client_name' => $client_name])->links() }}
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
            $('#client_name').select2();
            // $('#form').validate({ // initialize the plugin
            //
            //     rules: {
            //         brand: {
            //             required: true,
            //
            //         }
            //     },
            //     messages: {
            //         brand: {
            //             required: "Required"
            //         }
            //
            //     },
            //
            //     ignore: [],
            //     errorClass: "invalid-feedback animated fadeInUp",
            //     errorElement: "div",
            //     errorPlacement: function (e, a) {
            //         jQuery(a).parents(".form-group > div").append(e)
            //     },
            //     highlight: function (e) {
            //         jQuery(e).closest(".form-group").removeClass("is-invalid").addClass("is-invalid")
            //     },
            //     success: function (e) {
            //         jQuery(e).closest(".form-group").removeClass("is-invalid"), jQuery(e).remove()
            //     },
            //
            // });

        });
    </script>
@stop
