
@extends('inc.print_index')

@section('print_cntnt')
    <style>
    .h-center{
    text-align: center;
    color: black;
    }
    </style>
{{--                        <h3 class="invoice_sub_hdng mb-0">--}}
{{--                            Company Information--}}
{{--                        </h3>--}}

    <h2 class="h-center">Job Card</h2>
    <div id="" class="table-responsive" style="z-index: 9;">


        <table class="table table-sm m-0">

            <tr class="bg-transparent">
                <td class="wdth_50_prcnt p-0 border-0">
                    <h3 class="invoice_sub_hdng mb-0">
                        Company Information
                    </h3>
                    <p class="invoice_para m-0 pt-0">
                        <b> Name: </b>
                        RF Electronics
                    </p>
                    <p class="invoice_para adrs m-0 pt-0">
                        <b> CEO: </b>
                        Rana Farhan
                    </p>
                    <p class="invoice_para adrs m-0 pt-0">
                        <b> Address: </b>
                        Behind Hussain Agahi Multan
                    </p>
                    <p class="invoice_para m-0 pt-0">
                        <b> Contact #: </b>
                        03008637653, 0614587653
                    </p>
                    <p class="invoice_para m-0 pt-0">
                        <b> Services: </b>
                        SolarMax, Solar Projects and
                    </p>
                    <p class="invoice_para m-0 pt-0">
                        UPS, VFD, Grid Inverter Repairing
                    </p>

                </td>

                <td class="wdth_50_prcnt p-0 border-0">
                    <h3 class="invoice_sub_hdng mb-0 mt-0">
                        Bill Information
                    </h3>

                    <p class="invoice_para m-0 pt-0">
                        <b>Client Name: </b>{{$items[0]->cli_name}}
                    </p>
                    <p class="invoice_para m-0 pt-0">
                        <b>Clint Number #</b> {{$items[0]->cli_number}}
                    </p>
                    <p class="invoice_para m-0 pt-0">
                        <b>Date: </b>{{date('d-m-Y', strtotime( $items[0]->ji_created_at )) }}
                    </p>
                    <p class="invoice_para m-0 pt-0">
                        <b>Job#</b> {{$items[0]->ji_id}}
                    </p>
                    <p class="invoice_para m-0 pt-0">
                        <b>Job Title: </b>{{$items[0]->ji_title}}
                    </p>
                    <p class="invoice_para m-0 pt-0">
                        <b>Warrenty: </b>{{$items[0]->ji_warranty_status == 1 ? 'Yes' : ''}}
                    </p>

                    {{--                <td id="remarks" class="datas" style="width: 77%">{{$items[0]->ji_title}}</td>--}}
                    {{--                <td id="job" style="width: 12%"><b>Warranty:</b> {{$items[0]->ji_warranty_status == 1 ? 'Yes' : ''}}</td>--}}
                </td>
            </tr>

        </table>


        <table class="table table-bordered table-sm">
            <thead>
                        <tr class="data">
                            <th>Brand</th>
                            <th>Category</th>
                            <th>Model</th>
                            <th>Equipment</th>
                            <th>Serial No</th>
                        </tr>
            </thead>

            <tbody>
                        <tr class="data">
                            <td class="rowdata">{{$items[0]->bra_name}}</td>
                            <td class="rowdata">{{$items[0]->cat_name}}</td>
                            <td class="rowdata">{{$items[0]->mod_name}}</td>
                            <td class="rowdata">{{$items[0]->ji_equipment}}</td>
                            <td class="rowdata">{{$items[0]->ji_serial_no}}</td>
                        </tr>

{{--                        <tr>--}}
{{--                            <th colspan="2" class="text-right align_right">--}}
{{--                                Total:---}}
{{--                            </th>--}}
{{--                            <td class="text-center align_right">--}}
{{--                                {{ number_format($pim->pri_total_items,3) }}--}}{{--aa--}}
{{--                            </td>--}}
{{--                            <td class="text-center align_center">--}}
{{--                            </td>--}}
{{--                            <td class="text-center align_center">--}}
{{--                            </td>--}}
{{--                            <td class="text-center align_center">--}}
{{--                            </td>--}}
{{--                            <td class="text-right align_right">--}}
{{--                                {{ number_format($ttlExcluDis,2) }}--}}{{--cc--}}
{{--                            </td>--}}
{{--                            <td class="text-right align_right">--}}
{{--                                {{ number_format($trade_offerTtl,2) }}--}}{{--vv--}}
{{--                            </td>--}}
{{--                            <td class="text-center align_center">--}}
{{--                                                    {{ number_format($ttlDis,2) }}--}}{{--gg--}}
{{--                            </td>--}}
{{--                            <td class="text-center align_center">--}}
{{--                                {{ number_format($discountAmountTtl,2) }}--}}{{--rr--}}
{{--                            </td>--}}
{{--                            <td class="text-right align_right">--}}
{{--                                {{ number_format($ttlAmnt,2) }}--}}{{--yy--}}
{{--                            </td>--}}
{{--                        </tr>--}}


            </tbody>
            <tfoot>
                        <tr class="border-0">
                            <td colspan="13" align="right" class="p-0 border-0">
                                <table class="table m-0 p-0 chk_dmnd">
                                    <tr>
                                        <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                                            <table class="m-0 p-0 table">
{{--                                                <tr>--}}
{{--                                                    <th class="vi_tbl_hdng fontS-12 text-right">--}}
{{--                                                        <label class="total-items-label text-right">--}}
{{--                                                            {{$product_discount}}--}}{{--dsf--}}
{{--                                                        </label>--}}
{{--                                                    </th>--}}
{{--                                                    <td class="text-right fontS-12">--}}
{{--                                                     23   {{ number_format($pim->pri_product_disc,2) }}--}}
{{--                                                    </td>--}}
{{--                                                </tr>--}}
{{--                                                <tr>--}}
{{--                                                    <th class="vi_tbl_hdng fontS-12 text-right">--}}
{{--                                                        <label class="total-items-label text-right">--}}
{{--                                                            {{$round_off_discount}}--}}{{--asd--}}
{{--                                                        </label>--}}
{{--                                                    </th>--}}
{{--                                                    <td class="text-right fontS-12">dsf--}}
{{--                                                        {{ number_format($pim->pri_round_off_disc,2) }}--}}
{{--                                                    </td>--}}
{{--                                                </tr>--}}
                                            </table>
                                        </td>
                                        <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                                            <table class="m-0 p-0 table">
                                                <tr>
                                                    <th class="vi_tbl_hdng fontS-12 text-right">
                                                        <label class="total-items-label text-right">
Complain
                                                        </label>
                                                    </th>
                                                    <td class="text-right fontS-12">
                                                                        @foreach($complain_items as $complain)

                                                                            @if($complain->jii_ji_id == $items[0]->ji_id)
{{--                                                                                <th style="vertical-align: top">Complain:</th>--}}
                                                                                {{$complain->jii_item_name}}
                                                                            @endif

                                                                        @endforeach
                                                                            </td>
                                                </tr>
                                                <tr>
                                                    <th class="vi_tbl_hdng fontS-12 text-right">
                                                        <label class="total-items-label text-right">
Accessories
                                                        </label>
                                                    </th>
                                                    <td class="text-right fontS-12">

                                                                        @foreach($accessory_items as $complain)

                                                                            @if($complain->jii_ji_id == $items[0]->ji_id)
{{--                                                                                <th style="vertical-align: top">Accessories:</th>--}}
                                                                                {{$complain->jii_item_name}}

                                                                            @endif

                                                                        @endforeach
{{--                                                        {{ number_format($discountTtl,2) }}--}}
{{--                                                                                                    {{ number_format($pim->pri_total_discount,2) }}--}}
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                                            <table class="m-0 p-0 table">
                                                <tr>
                                                    <th class="vi_tbl_hdng fontS-12 text-right">
                                                        <label class="total-items-label text-right">
                                                            Delivery Date

                                                        </label>
                                                    </th>
                                                    <td class="text-right fontS-12">
                                                        {{date('d-m-Y', strtotime( $items[0]->ji_delivery_datetime )) }}
                                                </tr>


                                                <tr>
                                                    <th class="vi_tbl_hdng fontS-12 text-right">
                                                        <label class="total-items-label text-right">
                                                            Estimated Charges
                                                        </label>
                                                    </th>
                                                    <td class="text-right fontS-12">
                                                        {{$items[0]->ji_estimated_cost}}                                                    </td>
                                                </tr>

                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

            </tfoot>


        </table>
    </div>



    <div class="itm_vchr_rmrks">

        <a href="{{ route('job_info_modal_view_details_pdf_sh',['id'=>$items[0]->ji_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
            Download
        </a>

        <iframe style="display: none" id="printf" name="printf" src="{{ route('job_info_modal_view_details_pdf_sh',['id'=>$items[0]->ji_id]) }}" title="W3Schools Free Online Web
            Tutorials">
            Iframe
        </iframe>


        <a href="#" id="printi" onclick="PrintFrame()" class="ml-2 align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
            Print
        </a>

    </div>




    <div class="clearfix"></div>
    <div class="input_bx_ftr"></div>



    <script>

        function PrintFrame() {
            window.frames["printf"].focus();
            window.frames["printf"].print();
        }

    </script>


@endsection


