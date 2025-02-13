@php
    $company_info = Session::get('company_info');
@endphp

<style>
    .table tbody tr:nth-child(even) {
        /*background-color: rgba(0,0,0,.05);*/
    }

    * {
        font-family: Arial, sans-serif;
    }

    td {
        font-size: 12px;
    }

    th {
        font-size: 14px;
    }

    .table th,
    .table td {
        padding: .1rem .2rem;
        line-height: 17px;
        vertical-align: middle;
        font-size: 12px;
        cursor: pointer;
        border: 1px solid rgba(0, 0, 0, .3);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        /*background-color: #f2f2f2;*/
    }

    blockquote {
        background: transparent;
        border-left: 2px solid rgba(204, 204, 204, .5);
        margin: 0em 0px;
        padding: .2em 4px;
        quotes: "\201C" "\201D" "\2018" "\2019";
        position: relative;
    }


    .v_wdth_1 {
        min-width: 5%;
        width: 5%;
        text-align: center;
    }

    .v_wdth_2 {
        min-width: 16%;
        width: 16%;
        text-align: center;
    }

    .v_wdth_3 {
        min-width: 30%;
        width: 30%;
        text-align: left;
    }

    .v_wdth_4 {
        min-width: 25%;
        width: 25%;
        text-align: left;
    }

    .v_wdth_5 {
        min-width: 12%;
        width: 12%;
        text-align: right;
    }

    .vi_tbl_hdng {
        background: #a5a5a5;
        color: #000;
    }

    .text-center {
        text-align: center;
    }

    .pts-10 {
        padding-top: 10px !important;
    }

    .fontS-12 {
        font-size: 12px !important;
    }

    .fontS-12 label {
        font-size: 10px !important;
    }

    .invoice_hdng {
        font-weight: bolder;
        font-size: 25px;
        margin: 0 !important;
        padding: 0 !important;
    }

    .invoice_para {
        padding: 0px 5px 0;
    }

    .invoice_sub_hdng {
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

    .text-center {
        text-align: center;
    }

    .border-0 {
        border: 0px solid transparent !important;
    }

    .text-right {
        text-align: right !important;
    }

    .bg-transparent {
        background-color: transparent;
    }

    .m-0 {
        margin: 0 !important;
    }

    .p-0 {
        padding: 0 !important;
    }

    .pl-0 {
        padding-left: 0px !important;
    }

    .pb-0 {
        padding-bottom: 0px !important;
    }

    .pr-0 {
        padding-right: 0px !important;
    }

    .pts-10 {
        padding-top: 10px !important;
    }

    .mt-0 {
        margin-top: 0 !important;
    }

    .mt-10 {
        margin-top: 10px !important;
    }

    .mb-10 {
        margin-bottom: 10px !important;
    }

    .mt-5 {
        margin-top: 5px !important;
    }

    .valign-top {
        vertical-align: top;
    }

    .text-center {
        text-align: center;
    }

    .text-left {
        text-align: left;
    }

    .text-right {
        text-align: right;
    }

    .wrds_con {
        position: relative;
        border: 1px solid rgba(0, 0, 0, .3);
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
        border-right: 1px solid rgba(0, 0, 0, .3);
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

    .border-left-0 {
        border-left: 0px solid transparent;
    }

    .border-top-0 {
        border-top: 0px solid transparent;
    }

    .border-right-0 {
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

    .clearfix {
        clear: both;
    }

    .border-bottom-3 {
        border-bottom: 3px double #000 !important;
    }

    .border-top-2 {
        border-top: 2px solid #000 !important;
    }

    .h-center {
        text-align: center;
        color: black;
    }
</style>


<h2 class="h-center">Purchase Invoice</h2>

<div id="" class="table-responsive">


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
                {{-- <p class="invoice_para adrs m-0 pt-0"> --}}
                {{-- <b> CEO: </b> --}}
                {{-- {{$company_profile->cp_name}} --}}
                {{-- Rana Farhan --}}
                {{-- </p> --}}
                <p class="invoice_para adrs m-0 pt-0">
                    <b> Address: </b>
                    {{-- {{$company_profile->cp_salogan}} |  --}}
                    {{ $company_profile->cp_address }}
                    {{-- Behind Hussain Agahi Multan --}}
                </p>
                <p class="invoice_para m-0 pt-0">
                    <b> Contact #: </b>
                    {{ $company_profile->cp_contact }}
                    {{-- 03008637653, 0614587653 --}}
                </p>
                <p class="invoice_para m-0 pt-0">
                    <b> Services: </b>
                    {{ $company_profile->cp_deal }}
                    {{-- SolarMax, Solar Projects and --}}
                </p>
                {{-- <p class="invoice_para m-0 pt-0">

                    UPS, VFD Repairing
                </p> --}}
                {{-- <p class="invoice_para m-0 pt-0">
                    Grid Inverter Repairing
                </p> --}}

            </td>
            <td class="wdth_50_prcnt p-0 border-0">
                <h3 class="invoice_sub_hdng mb-0 mt-0">
                    Bill Information
                </h3>

                <p class="invoice_para m-0 pt-0">
                    <b>Invoice#: </b>{{ $items[0]->pi_inv_id }}
                </p>
                <p class="invoice_para m-0 pt-0">
                    <b>Date</b> {{ date('d-m-Y', strtotime($items[0]->pi_created_at)) }}
                </p>
                <p class="invoice_para m-0 pt-0">
                    <b>Remarks: </b>{{ $items[0]->pi_remarks }}
                </p>
                <p class="invoice_para m-0 pt-0">
                    <b>Party Name</b>
                    {{ $items[0]->party_name }}
                </p>
                <p class="invoice_para m-0 pt-0">
                    <b>Party Number </b>
                    {{ $items[0]->party_number }}
                </p>
                {{--                    <p class="invoice_para m-0 pt-0"> --}}
                {{--                        <b>Total Items: </b> --}}
                {{--                        --}}{{--                        {{$items[0]->ji_warranty_status == 1 ? 'Yes' : ''}} --}}
                {{--                    </p> --}}
                {{--                    <p class="invoice_para m-0 pt-0"> --}}
                {{--                        <b>Remarks: </b> --}}
                {{--                        {{$items[0]->sifj_remarks}} --}}
                {{--                    </p> --}}


            </td>
        </tr>

    </table>


    <table class="table table-bordered table-sm">
        <thead>

            <tr id="data">
                <th>Sr#</th>
                <th>Part</th>
                <th>Quantity</th>
                <th>Rate</th>
                <th>Discount</th>
                <th>Amount</th>

            </tr>
        </thead>

        <tbody>
            <tr class="data">

                @php
                    $segmentSr = !empty(app('request')->input('segmentSr')) ? app('request')->input('segmentSr') : '';
                    $segmentPg = !empty(app('request')->input('page')) ? app('request')->input('page') : '';
                    $sr = !empty($segmentSr) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                    $countSeg = !empty($segmentSr) ? $segmentSr : 0;
                    $prchsPrc = $slePrc = $avrgPrc = 0;
                @endphp

                @foreach ($items as $brand)
            <tr>
                <td class="rowdata" id="data">{{ $sr }}</td>
                <td class="rowdata" id="data1">{{ $brand->par_name }}</td>
                <td class="rowdata" id="qty">{{ $brand->pii_qty }}</td>
                <td class="rowdata" id="rate">{{ $brand->pii_rate }}</td>
                <td class="rowdata" id="dis">{{ $brand->pii_discount }}</td>
                <td class="rowdata" id="amount">{{ $brand->pii_amount }}</td>
            </tr>
            @endforeach
            </tr>

            @php
                $sr++;
                !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
            @endphp


        </tbody>
        {{--            <tfoot> --}}
        {{--            <tr class="border-0"> --}}
        {{--                <td colspan="13" align="right" class="p-0 border-0"> --}}
        {{--                    <table class="table m-0 p-0 chk_dmnd"> --}}
        {{--                        <tr> --}}

        {{--                            <td class="pl-0 pb-0 pr-0 border-0 pts-10"> --}}
        {{--                                <table class="m-0 p-0 table"> --}}


        {{--                                    <tr> --}}
        {{--                                        <th class="vi_tbl_hdng fontS-12 text-right"> --}}
        {{--                                            <label class="total-items-label text-right"> --}}
        {{--                                                Total Items --}}
        {{--                                            </label> --}}
        {{--                                        </th> --}}
        {{--                                        <td class="text-right fontS-12"> --}}
        {{--                                            {{$items[0]->pi_total_items}} --}}

        {{--                                        </td> --}}

        {{--                                    </tr> --}}

        {{--                                    <tr> --}}
        {{--                                        <th class="vi_tbl_hdng fontS-12 text-right"> --}}
        {{--                                            <label class="total-items-label text-right"> --}}
        {{--                                                Total --}}
        {{--                                            </label> --}}
        {{--                                        </th> --}}
        {{--                                        <td class="text-right fontS-12"> --}}
        {{--                                            {{$items[0]->pi_grand_total}} --}}
        {{--                                        </td> --}}

        {{--                                    </tr> --}}



        {{--                                </table> --}}
        {{--                            </td> --}}
        {{--                            <td class="pl-0 pb-0 pr-0 border-0 pts-10"> --}}
        {{--                                <table class="m-0 p-0 table"> --}}
        {{--                                    <tr> --}}
        {{--                                        <th class="vi_tbl_hdng fontS-12 text-right"> --}}
        {{--                                            <label class="total-items-label text-right"> --}}
        {{--                                                Amount Paid (Rs) --}}

        {{--                                            </label> --}}
        {{--                                        </th> --}}
        {{--                                        <td class="text-right fontS-12"> --}}

        {{--                                            {{$items[0]->pi_amount_pay}} --}}
        {{--                                        </td> --}}
        {{--                                    </tr> --}}


        {{--                                    <tr> --}}
        {{--                                        <th class="vi_tbl_hdng fontS-12 text-right"> --}}
        {{--                                            <label class="total-items-label text-right"> --}}
        {{--                                                Remaining --}}
        {{--                                            </label> --}}
        {{--                                        </th> --}}
        {{--                                        <td class="text-right fontS-12"> --}}
        {{--                                            {{$items[0]->pi_remaining}} --}}
        {{--                                        </td> --}}
        {{--                                    </tr> --}}


        {{--                                </table> --}}
        {{--                            </td> --}}


        {{--                        </tr> --}}
        {{--                    </table> --}}
        {{--                </td> --}}
        {{--            </tr> --}}

        {{--            </tfoot> --}}


    </table>

    <h3 class="invoice_sub_hdng mb-0">
        Installments
    </h3>
    <table class="table table-bordered table-sm">
        <thead>

            <tr id="data">
                <th>Sr#</th>
                <th>Invoice#</th>
                <th>Remarks</th>
                <th>Cost (Rs)</th>
                <th>Amount Pay</th>
                <th>Discount</th>
                <th>Remaining Cost</th>
                <th>Date</th>

            </tr>
        </thead>

        <tbody>
            <tr class="data">

                @php
                    $segmentSr = !empty(app('request')->input('segmentSr')) ? app('request')->input('segmentSr') : '';
                    $segmentPg = !empty(app('request')->input('page')) ? app('request')->input('page') : '';
                    $sr = !empty($segmentSr) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                    $countSeg = !empty($segmentSr) ? $segmentSr : 0;
                    $prchsPrc = $slePrc = $avrgPrc = 0;
                @endphp

                @foreach ($credit_items as $brand)
            <tr>
                <td class="rowdata" id="data">{{ $sr }}</td>
                <td class="rowdata" id="data1">{{ $brand->cpi_id }}</td>
                <td class="rowdata" id="qty">{{ $brand->cpi_remarks }}</td>
                <td class="rowdata">{{ $brand->cpi_real_estimated_cost }}</td>
                <td class="rowdata">{{ $brand->cpi_amount_paid }}</td>
                <td class="rowdata">{{ $brand->cpi_discount }}</td>

                <td class="rowdata">{{ $brand->cpi_remaining_cost }}</td>
                <td class="rowdata">{{ date('d-m-Y', strtotime($brand->cpi_created_at)) }}</td>
            </tr>
            @endforeach
            </tr>

            @php
                $sr++;
                !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
            @endphp


        </tbody>

        <tfoot>
            <tr class="border-0">
                <td colspan="13" align="right" class="p-0 border-0">
                    <table class="table m-0 p-0 chk_dmnd">
                        <tr>

                            <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                                <table class="m-0 p-0 table">


                                    <tr>
                                        <th class="vi_tbl_hdng fontS-12 text-right">
                                            <label class="total-items-label text-right">
                                                Total Items
                                            </label>
                                        </th>
                                        <td class="text-right fontS-12">
                                            {{ $items[0]->pi_total_items }}

                                        </td>

                                    </tr>

                                    <tr>
                                        <th class="vi_tbl_hdng fontS-12 text-right">
                                            <label class="total-items-label text-right">
                                                Total
                                            </label>
                                        </th>
                                        <td class="text-right fontS-12">
                                            {{ $items[0]->pi_grand_total }}
                                        </td>

                                    </tr>



                                </table>
                            </td>
                            <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                                <table class="m-0 p-0 table">
                                    <tr>
                                        <th class="vi_tbl_hdng fontS-12 text-right">
                                            <label class="total-items-label text-right">
                                                Amount Paid (Rs)

                                            </label>
                                        </th>
                                        <td class="text-right fontS-12">

                                            {{ $items[0]->pi_amount_pay }}
                                        </td>
                                    </tr>


                                    <tr>
                                        <th class="vi_tbl_hdng fontS-12 text-right">
                                            <label class="total-items-label text-right">
                                                Remaining
                                            </label>
                                        </th>
                                        <td class="text-right fontS-12">
                                            {{ $items[0]->pi_remaining }}
                                        </td>
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
