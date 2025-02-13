@extends('inc.print_index')

@section('print_cntnt')
    <style>
        .h-center {
            text-align: center;
            color: black;
        }
    </style>
    <h2 class="h-center">{{$pge_title}}</h2>


    <div id="" class="table-responsive" style="z-index: 9;">


        <table class="table table-sm m-0">

            <tr class="bg-transparent">
                <td class="wdth_50_prcnt p-0 border-0">
                    <h3 class="invoice_sub_hdng mb-0">
                        Company Information
                    </h3>
                    <p class="invoice_para m-0 pt-0">
                        <b> Name: </b>
                        {{ $company_profile->cp_name }}
                    </p>
                     <p class="invoice_para adrs m-0 pt-0">
                     <b> CEO: </b>
                     {{$company_profile->cp_name}}
                     </p>
                    <p class="invoice_para adrs m-0 pt-0">
                        <b> Address: </b>
                         {{$company_profile->cp_salogan}} |
                        {{ $company_profile->cp_address }}
                    </p>
                    <p class="invoice_para m-0 pt-0">
                        <b> Contact #: </b>
                        {{ $company_profile->cp_contact }}
                    </p>
                    <p class="invoice_para m-0 pt-0">
                        <b> Services: </b>
                        {{ $company_profile->cp_deal }}
                    </p>
                     <p class="invoice_para m-0 pt-0">
                    </p>
                     <p class="invoice_para m-0 pt-0">
                    </p>

                </td>

                <td class="wdth_50_prcnt p-0 border-0">
                    <h3 class="invoice_sub_hdng mb-0 mt-0">
                        Bill Information
                    </h3>

                    <p class="invoice_para m-0 pt-0">
                        <b>Invoice#: </b>{{ $query[0]->job_id }}
                    </p>
                    <p class="invoice_para m-0 pt-0">
                        <b>Date</b> {{ date('d-m-Y', strtotime($query[0]->ji_created_at)) }}
                    </p>
                    <p class="invoice_para m-0 pt-0">
                        <b>Client Name</b>
                        {{ $query[0]->cli_name }}
                    </p>
                    <p class="invoice_para m-0 pt-0">
                        <b>Client Number </b>
                        {{ $query[0]->cli_number }}


                </td>
            </tr>

        </table>


        <table id="example" class="table table-striped table-bordered display"
               style="min-width: 845px">
            <thead>
            <tr>

                <th>Job No</th>
                <th>Client Name</th>
                <th>Client Number</th>
                <th>Warrenty</th>
                <th>Delivery Status</th>
                <th>Delivered By</th>
                <th>Brand</th>
                <th>Category</th>
                <th>Model</th>
                <th>Equipment</th>
                <th>Status</th>
                <th>Serial Number</th>
                <th>Cost</th>
                <th>Complain</th>
                <th>Accessories</th>
                <th>Start Date</th>
                <th>End Date</th>


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
                    <td>{{ $brand->cli_name }}</td>
                    <td>{{ $brand->cli_number }}</td>
                    <td>{{ $brand->ji_warranty_status == 1 ? 'Yes' : '' }}</td>
                    <td>{{ $brand->job_delivery_status == 2 ? 'Delivered' : 'Not delivered' }}
                    </td>
                    <td>{{ $brand->user_name }}</td>
                    <td>{{ $brand->bra_name }}</td>
                    <td>{{ $brand->cat_name }}</td>
                    <td>{{ $brand->mod_name }}</td>
                    <td>{{ $brand->ji_equipment }}</td>

                    <td>{{ $brand->ji_job_status }}</td>
                    <td>{{ $brand->ji_serial_no }}</td>
                    <td>{{ $brand->ji_estimated_cost }}</td>


                    @foreach ($complain_items as $complain)
                        @if ($complain->jii_ji_job_id == $brand->job_id)
                            <td>{{ $complain->jii_item_name }}</td>
                        @endif
                    @endforeach


                    @foreach ($accessory_items as $complain)
                        @if ($complain->jii_ji_job_id == $brand->job_id)
                            <td>{{ $complain->jii_item_name }}</td>
                        @endif
                    @endforeach

                    <td>{{ $brand->ji_recieve_datetime }}</td>
                    <td>{{ $brand->ji_delivery_datetime }}</td>
                    <td><a href="{{ route('job_info.edit', $brand->job_id) }}"><i
                                class="fas fa-edit"></i></a></td>

                </tr>

                @php
                    $sr++;
                    !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                @endphp
            @endforeach


            </tbody>

        </table>
    </div>



{{--    <div class="itm_vchr_rmrks">--}}

{{--        <a href="{{ route('sale_invoice_modal_view_details_pdf_sh', ['id' => $brand->sii_inv_id]) }}"--}}
{{--           class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">--}}
{{--            Download--}}
{{--        </a>--}}

{{--        <iframe style="display: none" id="printf" name="printf"--}}
{{--                src="{{ route('sale_invoice_modal_view_details_pdf_sh', ['id' => $brand->sii_inv_id]) }}"--}}
{{--                title="W3Schools Free Online Web--}}
{{--            Tutorials">--}}
{{--            Iframe--}}
{{--        </iframe>--}}


{{--        <a href="#" id="printi" onclick="PrintFrame()" class="ml-2 align_right text-center btn btn-sm btn-info"--}}
{{--           style="float: left;margin-top: 7px;">--}}
{{--            Print--}}
{{--        </a>--}}

{{--    </div>--}}




    <div class="clearfix"></div>
    <div class="input_bx_ftr"></div>



    <script>
        function PrintFrame() {
            window.frames["printf"].focus();
            window.frames["printf"].print();
        }
    </script>
@endsection
