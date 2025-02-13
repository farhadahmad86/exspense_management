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
                        <h4>Hi, welcome back!</h4>
                        <p class="mb-1">Issue Parts Report</p>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Report</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Issue Parts Report</a></li>

                    </ol>
                </div>
            </div>
            @include('inc._message')
            <!-- row -->



            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Issue Parts Report</h4>
                            <!-- Ibrahim add -->
                            {{--                        <button > --}}
                            <div class="srch_box_opn_icon">
                                <i id="search_hide" onclick="hide_the_search();" class="fa fa-search icon-hide"></i>
                            </div>
                            {{--                        </button> --}}
                        </div>
                        <div class="card-body">

                            <form action="{{ route('Job_Info_Job_Issue_Parts_Items_Report') }}" method="get">

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
                                            <label class="" for="">Job#</label>
                                            <input tabindex="4" type="text" name="job_no"
                                                class="form-control form-control-sm" id="job_no"
                                                value="{{ $job_no }}">
                                        </div>
                                    </div>
                                    <div class="col-1-5">
                                        <div class="form-group">
                                            <label class="" for="">Technician</label>
                                            <select id="tech_name" name="tech_name">
                                                <option value="0" selected disabled>Select Technician</option>
                                                @foreach ($tech_title as $index => $tech)
                                                    <option value="{{ $tech->tech_id }}"
                                                        {{ $tech_name == $tech->tech_id ? 'selected' : '' }}>
                                                        {{ $tech->tech_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-1-5">
                                        <div class="form-group">
                                            <label class="" for="">Parts</label>
                                            <select id="parts" name="parts">
                                                <option value="0" selected disabled>Select Parts</option>
                                                @foreach ($parts_title as $index => $part)
                                                    <option value="{{ $part->par_id }}"
                                                        {{ $parts == $part->par_id ? 'selected' : '' }}>
                                                        {{ $part->par_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class=" col-1-5">
                                        <div class="form-group">
                                            <label class="" for="">Status</label>
                                            <select id="status" name="status">
                                                {{-- <option value="0" selected disabled>Select</option> --}}

                                                <option value="" selected disabled>Select Status</option>
                                                <option value="Issued" {{ $status === 'Issued' ? 'selected' : '' }}>Issued
                                                </option>
                                                <option value="Returned" {{ $status === 'Returned' ? 'selected' : '' }}>
                                                    Returned
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-1-5">
                                        <div class="form-group">
                                            <label class="" for="">Warranty</label>
                                            <select id="warranty" name="warranty">
                                                {{-- <option value="0" selected disabled>Select</option> --}}

                                                <option value="0" selected disabled>Select Warranty</option>
                                                <option value="0" {{ $warranty == '0' ? 'selected' : '' }}>No</option>
                                                <option value="1" {{ $warranty == '1' ? 'selected' : '' }}>Yes
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-1-5">
                                        <div class="form-group">
                                            <label for="" style="font-size: 11.5px">Issue Against Damage</label>
                                            <select id="damage" name="damage">
                                                <option selected disabled>Select</option>
                                                <option value="2" {{ $damage === '2' ? 'selected' : '' }}>
                                                    Parts Issue Against Damage
                                                </option>
                                                <option value="1" {{ $damage === '1' ? 'selected' : '' }}>
                                                    Parts Not Issue Against Damage
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <x-date-filter label="From" id="from_date" name="from_date"
                                        value="{{ $from_date }}" />
                                    <x-date-filter label="To" id="to_date" name="to_date"
                                        value="{{ $to_date }}" />
                                    <div class="col-1-5" style="margin-top: 2rem !important;">
                                        <div class="form-group">
                                            <a href="{{ route('Job_Info_Job_Issue_Parts_Items_Report') }}"
                                                class="btn btn-primary btn-sm" id="">
                                                Clear
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-1-5" style="margin-top: 2rem !important;margin-left: -81px;">
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
                                            <th>Job No</th>
                                            <th>Technician</th>
                                            <th>Remarks</th>
                                            <th>Status</th>

                                            {{--                                        <th>Client Name</th> --}}
                                            {{--                                        <th>Client Number</th> --}}
                                            <th>Warrenty</th>
                                            <th>Part</th>
                                            <th>Parts Issue Status</th>
                                            <th>Quantity</th>
                                            <th>Rate</th>
                                            <th>Amount</th>
                                            {{--                                        <th>Category</th> --}}
                                            {{--                                        <th>Model</th> --}}
                                            {{--                                        <th>Equipment</th> --}}

                                            {{--                                        <th>Serial Number</th> --}}
                                            <th>Cost</th>

                                            <th>Job Status</th>
                                            {{--                                        <th>Accessories</th> --}}
                                            {{--                                        <th>Start Date</th> --}}
                                            <th>Date</th>
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
                                            @php
                                                $total_amount = $brand->par_purchase_price * $brand->iptji_qty;
                                            @endphp
                                            <tr>
                                                <td>{{ $sr }}</td>
                                                {{--                                            <td>{{$brand->iptj_job_no}}</td> --}}
                                                <td>{{ $brand->job_id }}</td>
                                                <td>{{ $brand->tech_name }}</td>
                                                <td>{{ $brand->iptj_remarks }}</td>

                                                <td class="view">{{ $brand->iptj_status }}</td>

                                                {{--                                            <td>{{$brand->cli_name}}</td> --}}
                                                {{--                                            <td>{{$brand->cli_number}}</td> --}}
                                                <td>
                                                    @if ($brand->ji_warranty_status == 1)
                                                        Yes
                                                    @else
                                                        No
                                                    @endif
                                                </td>
                                                <td>{{ $brand->par_name }}</td>
                                                <td>
                                                    @if ($brand->issue_against_damage == 1)
                                                        {{ 'Not Issue Against the Damage' }}
                                                    @else
                                                        {{ 'Issue Against the Damage' }}
                                                    @endif
                                                </td>
                                                <td>{{ $brand->iptji_qty }}</td>
                                                <td>{{ $brand->par_purchase_price }}</td>
                                                <td>{{ $total_amount }}</td>

                                                {{--                                            <td>{{$brand->ji_equipment}}</td> --}}


                                                {{--                                            <td>{{$brand->ji_serial_no}}</td> --}}
                                                <td>{{ $brand->ji_estimated_cost }}</td>
                                                <td>{{ $brand->ji_job_status }}</td>
                                                <td>{{ date('d-m-Y h:i:s', strtotime($brand->ji_recieve_datetime)) }}</td>

                                                {{--                                            <td>{{$complain_items->jii_item_name}}</td> --}}
                                                {{--                                            <td>{{$brand->ji_recieve_datetime}}</td> --}}
                                                {{--                                            <td>{{$brand->ji_recieve_datetime}}</td> --}}
                                                {{--                                            <td>{{$brand->ji_delivery_datetime}}</td> --}}

                                                {{--                                            @foreach ($complain_items as $complain) --}}

                                                {{--                                                @if ($complain->jii_ji_id == $brand->ji_id) --}}
                                                {{--                                                    <td>{{$complain->jii_item_name}}</td> --}}
                                                {{--                                                @endif --}}

                                                {{--                                            @endforeach --}}


                                                {{--                                            @foreach ($accessory_items as $complain) --}}

                                                {{--                                                @if ($complain->jii_ji_id == $brand->ji_id) --}}
                                                {{--                                                    <td>{{$complain->jii_item_name}}</td> --}}
                                                {{--                                                    --}}{{--                                               --}}
                                                {{--                                                @endif --}}

                                                {{--                                            @endforeach --}}

                                                {{--                                            <td>{{$brand->ji_recieve_datetime}}</td> --}}
                                                {{--                                            <td>{{$brand->ji_delivery_datetime}}</td> --}}
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
                            {{ $query->appends(['segmentSr' => $countSeg, 'damage' => $damage, 'job_no' => $job_no, 'tech_name' => $tech_name, 'status' => $status, 'warranty' => $warranty, 'from_date' => $from_date, 'to_date' => $to_date, 'parts' => $parts])->links() }}
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
            $("#tech_name").select2();
            $("#status").select2();
            $("#parts").select2();
            $("#damage").select2();
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
