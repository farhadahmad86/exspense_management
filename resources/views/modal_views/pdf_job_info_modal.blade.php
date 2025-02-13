
@php
    $company_info = Session::get('company_info');
@endphp

<style>
    .table tbody tr:nth-child(even) {
        /*background-color: rgba(0,0,0,.05);*/
    }
    *{
        font-family: Arial, sans-serif;
    }
    td{
        font-size: 12px;
    }
    th{
        font-size: 14px;
    }

    .table th, .table td {
        padding: .1rem .2rem;
        line-height: 17px;
        vertical-align: middle;
        font-size: 12px;
        cursor: pointer;
        border: 1px solid rgba(0,0,0,.3);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        /*background-color: #f2f2f2;*/
    }

    blockquote {
        background: transparent;
        border-left: 2px solid rgba(204,204,204,.5);
        margin: 0em 0px;
        padding: .2em 4px;
        quotes: "\201C""\201D""\2018""\2019";
        position: relative;
    }


    .v_wdth_1{
        min-width: 5%;
        width: 5%;
        text-align: center;
    }

    .v_wdth_2{
        min-width: 16%;
        width: 16%;
        text-align: center;
    }

    .v_wdth_3{
        min-width: 30%;
        width: 30%;
        text-align: left;
    }

    .v_wdth_4{
        min-width: 25%;
        width: 25%;
        text-align: left;
    }

    .v_wdth_5{
        min-width: 12%;
        width: 12%;
        text-align: right;
    }

    .vi_tbl_hdng {
        background: #a5a5a5;
        color: #000;
    }

    .text-center{
        text-align: center;
    }
    .pts-10{
        padding-top: 10px !important;
    }

    .fontS-12{
        font-size: 12px !important;
    }

    .fontS-12 label{
        font-size: 10px !important;
    }

    .invoice_hdng{
        font-weight: bolder;
        font-size: 25px;
        margin: 0 !important;
        padding: 0 !important;
    }

    .invoice_para{
        padding: 0px 5px 0;
    }

    .invoice_sub_hdng{
        padding: 5px;
        font-size: 14px;
        font-weight: bolder;
        background: #a5a5a5;
        color: #000;
    }

    .vi_tbl_hdng {
        background: #a5a5a5;
        color: #000;
    }

    .text-center{
        text-align: center;
    }

    .border-0{
        border: 0px solid transparent !important;
    }

    .text-right{
        text-align: right !important;
    }

    .bg-transparent{
        background-color: transparent;
    }

    .m-0{
        margin: 0 !important;
    }

    .p-0{
        padding: 0 !important;
    }

    .pl-0{
        padding-left: 0px !important;
    }

    .pb-0{
        padding-bottom: 0px !important;
    }

    .pr-0{
        padding-right: 0px !important;
    }

    .pts-10 {
        padding-top: 10px !important;
    }

    .mt-0{
        margin-top: 0 !important;
    }

    .mt-10{
        margin-top: 10px !important;
    }

    .mb-10 {
        margin-bottom: 10px !important;
    }

    .mt-5{
        margin-top: 5px !important;
    }

    .valign-top{
        vertical-align: top;
    }

    .text-center{
        text-align: center;
    }

    .text-left{
        text-align: left;
    }

    .text-right{
        text-align: right;
    }

    .wrds_con {
        position: relative;
        border: 1px solid rgba(0,0,0,.3);
        margin: 30px 0;
        width: 100%;
        display: block;
        float: left;
        min-height: 45px;
        height: auto;
    }

    .wrds_bx {
        position: relative;
        padding: 10px 15px;
        width: 70%;
        display: block;
        float: left;
        border-right: 1px solid rgba(0,0,0,.3);
        text-transform: uppercase;
    }

    .wrds_bx.wrds_bx_two {
        width: 30%;
        float: right
    }

    .wrds_hdng {
        position: absolute;
        top: -10px;
        background-color: #fff;
        padding: 0 10px;
        left: 5px;
        font-weight: bold;
        text-transform: capitalize;
    }

    .wrds_bx.wrds_bx_two .wrds_hdng {
        left: 30%;
        margin: 0 auto;
    }

    .sign_con {
        position: relative;
        margin: 0px 0;
        width: 100%;
        float: left;
        text-align: center;
        display: block;
        min-height: 70px;
        height: auto;
    }

    .sign_bx {
        position: relative;
        padding: 30px 15px 0;
        width: 20%;
        display: inline-block;
        text-transform: uppercase;
        text-align: center;
    }

    .sign_itm {
        position: relative;
        padding: 0 10px;
        font-weight: bold;
        text-transform: capitalize;
        border-top: 2px solid;
        width: 90%;
        display: block;
        font-size: 12px;
    }

    .border-left-0{
        border-left: 0px solid transparent;
    }

    .border-top-0{
        border-top: 0px solid transparent;
    }

    .border-right-0{
        border-right: 0px solid transparent;
    }

    .max_txt {
        min-width: 250px;
        max-width: 250px;
        width: 100%;
        overflow: hidden;
        -ms-word-break: break-all;
        word-break: break-all;
    }

    .fontS-12 {
        font-size: 9px !important;
    }

    .fontS-12 label {
        font-size: 8px !important;
    }

    .clearfix{
        clear: both;
    }

    .border-bottom-3{
        border-bottom: 3px double #000 !important;
    }

    .border-top-2{
        border-top: 2px solid #000 !important;
    }

    .h-center{
        text-align: center;
        color: black;
    }
</style>


<h2 class="h-center">Job Card</h2>

<div id="" class="table-responsive">

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

    <div class="clearfix"></div>

</div>
<div class="input_bx_ftr"></div>
