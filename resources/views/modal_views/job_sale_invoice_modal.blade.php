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

    <h2 class="h-center">Job Sale Invoice</h2>


    <div id="" class="table-responsive" style="z-index: 9;">


        <table class="table table-sm m-0">

            <tr class="bg-transparent">
                <td class="wdth_50_prcnt p-0 border-0">
                    <h3 class="invoice_sub_hdng mb-0">
                        Company Information
                    </h3>
                    <p class="invoice_para m-0 pt-0">
                        <b> Name: </b>
                        {{$company_profile->cp_name}}
                    </p>
                    {{-- <p class="invoice_para adrs m-0 pt-0"> --}}
                        {{-- <b> CEO: </b> --}}
                        {{-- {{$company_profile->cp_name}} --}}
                        {{-- Rana Farhan --}}
                        {{-- </p> --}}
                        <p class="invoice_para adrs m-0 pt-0">
                            <b> Address: </b>
                            {{-- {{$company_profile->cp_salogan}} |  --}}
                            {{$company_profile->cp_address}}
                            {{-- Behind Hussain Agahi Multan --}}
                        </p>
                        <p class="invoice_para m-0 pt-0">
                            <b> Contact #: </b>
                            {{$company_profile->cp_contact}}
                            {{-- 03008637653, 0614587653 --}}
                        </p>
                        <p class="invoice_para m-0 pt-0">
                            <b> Services: </b>
                            {{$company_profile->cp_deal}}
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
                        <b>Client Name: </b>{{$items[0]->cli_name}}
                    </p>
                    <p class="invoice_para m-0 pt-0">
                        <b>Clint Number #</b> {{$items[0]->cli_number}}
                    </p>
                    <p class="invoice_para m-0 pt-0">
                        <b>Date: </b>{{date('d-m-Y', strtotime( $items[0]->sifj_created_at )) }}
                    </p>
                    <p class="invoice_para m-0 pt-0">
                        <b>Job#</b> {{$items[0]->job_id}}
                    </p>
                    <p class="invoice_para m-0 pt-0">
                        <b>Invoice# </b>{{$items[0]->sifj_inv_id}}
                    </p>
                    <p class="invoice_para m-0 pt-0">
                        <b>Warrenty: </b>{{$items[0]->ji_warranty_status == 1 ? 'Yes' : ''}}
                    </p>
                    <p class="invoice_para m-0 pt-0">
                        <b>Remarks: </b>{{$items[0]->sifj_remarks}}
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




            </tbody>
            <tfoot>
            <tr class="border-0">
                <td colspan="13" align="right" class="p-0 border-0">
                    <table class="table m-0 p-0 chk_dmnd">
                        <tr>
                            <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                                <table class="m-0 p-0 table">

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

                                                @if($complain->jii_ji_job_id == $items[0]->ji_id)
                                                    {{--                                                                                <th style="vertical-align: top">Complain:</th>--}}
                                                    {{$complain->jii_item_name}}
                                                @endif

                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="vi_tbl_hdng fontS-12 text-right">
                                            <label class="total-items-label text-right">
                                                Estimated Charges
                                            </label>
                                        </th>
                                        <td class="text-right fontS-12">
                                            {{$items[0]->sifj_estimated_cost}}                                                    </td>

                                    </tr>

                                    <tr>
                                        <th class="vi_tbl_hdng fontS-12 text-right">
                                            <label class="total-items-label text-right">
                                                Discount

                                            </label>
                                        </th>
                                        <td class="text-right fontS-12">
                                            {{$items[0]->sifj_discount}}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                                <table class="m-0 p-0 table">
                                    <tr>
                                        <th class="vi_tbl_hdng fontS-12 text-right">
                                            <label class="total-items-label text-right">
                                                Accessories

                                            </label>
                                        </th>
                                        <td class="text-right fontS-12">

                                            @foreach($accessory_items as $complain)

                                                @if($complain->jii_ji_job_id == $items[0]->ji_id)
                                                    {{--                                                                                <th style="vertical-align: top">Accessories:</th>--}}
                                                    {{$complain->jii_item_name}}

                                                @endif

                                            @endforeach
                                            {{--                                                        {{ number_format($discountTtl,2) }}--}}
                                            {{--                                                                                                    {{ number_format($pim->pri_total_discount,2) }}--}}
                                        </td>
                                    </tr>


                                    <tr>
                                        <th class="vi_tbl_hdng fontS-12 text-right">
                                            <label class="total-items-label text-right">
                                                Amount Pay
                                            </label>
                                        </th>
                                        <td class="text-right fontS-12">
                                            {{$items[0]->sifj_amount_paid}}                                                    </td>
                                    </tr>

                                    <tr>
                                        <th class="vi_tbl_hdng fontS-12 text-right">
                                            <label class="total-items-label text-right">
                                                Remaining
                                            </label>
                                        </th>
                                        <td class="text-right fontS-12">
                                            {{$items[0]->sifj_remaining_cost}}                                                 </td>
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

        <a href="{{ route('sale_job_invoice_modal_view_details_pdf_sh',['id'=>$items[0]->sifj_inv_id]) }}"
           class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
            Download
        </a>

        <iframe style="display: none" id="printf" name="printf"
                src="{{ route('sale_job_invoice_modal_view_details_pdf_sh',['id'=>$items[0]->sifj_inv_id]) }}" title="W3Schools Free Online Web
            Tutorials">
            Iframe
        </iframe>


        <a href="#" id="printi" onclick="PrintFrame()" class="ml-2 align_right text-center btn btn-sm btn-info"
           style="float: left;margin-top: 7px;">
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



















































{{--<html>--}}
{{--<head></head>--}}
{{--<body>--}}

{{--<style>--}}


{{--    table{--}}
{{--        width: 100%;--}}
{{--        color: black;--}}
{{--        padding: 5px !important;--}}
{{--    }--}}
{{--    .h-center{--}}
{{--        text-align: center;--}}
{{--        color: black;--}}
{{--    }--}}
{{--    tbody{--}}
{{--        overflow-y: hidden!important;--}}
{{--    }--}}
{{--    thead{--}}
{{--        width: 100%;--}}
{{--    }--}}

{{--    .tabl{--}}
{{--        /*border: 1px solid #000000;*/--}}
{{--    }--}}

{{--    #invoice, #job{--}}
{{--        text-align: left;--}}
{{--        /*font-size: 20px;*/--}}
{{--    }--}}
{{--    .remarks{--}}
{{--        text-align: left;--}}
{{--        /*font-size: 20px;*/--}}
{{--        font-weight: normal;--}}
{{--        padding-top: 25px;--}}
{{--        padding-bottom: 10px;--}}
{{--        white-space: break-spaces;--}}
{{--        line-height: 1;--}}
{{--        vertical-align: baseline;--}}
{{--    }--}}
{{--    #date{--}}
{{--        text-align: right;--}}
{{--        /*font-size: 20px;*/--}}
{{--        /*font-weight: bold;*/--}}
{{--    }--}}
{{--    #data{--}}
{{--        position: relative;--}}
{{--        /*left: 30px;*/--}}
{{--    }--}}
{{--    #data1{--}}
{{--        position: relative;--}}
{{--        /*left: 28px;*/--}}
{{--        /*font-size: 20px;*/--}}
{{--        margin-bottom: 10px;--}}
{{--    }--}}
{{--    #qty{--}}
{{--        position: relative;--}}
{{--        /*left: 40px;*/--}}
{{--        padding-top: 15px;--}}

{{--        padding-bottom: 5px;--}}
{{--    }--}}
{{--    #rate{--}}
{{--        position: relative;--}}
{{--        /*left: 40px;*/--}}
{{--        padding-top: 5px;--}}
{{--        padding-bottom: 5px;--}}
{{--    }--}}
{{--    #dis{--}}
{{--        position: relative;--}}
{{--        /*left: 50px;*/--}}
{{--        padding-top: 5px;--}}
{{--        padding-bottom: 5px;--}}
{{--    }--}}
{{--    #amount{--}}
{{--        position: relative;--}}
{{--        /*left: 50px;*/--}}
{{--        padding-top: 5px;--}}
{{--        padding-bottom: 5px;--}}
{{--    }--}}
{{--    #total{--}}
{{--        /*font-size: 20px;*/--}}
{{--        text-align: right;--}}
{{--        padding-bottom: 5px;--}}
{{--        padding-right: 43px;--}}
{{--    }--}}
{{--    tr{--}}
{{--        line-height: 1rem !important;--}}
{{--    }}--}}


{{--</style>--}}

{{--<section class="tabl">--}}
{{--    <div class="table-responsive">--}}
{{--        <table id="example" class="display title" style="min-width: 100%">--}}
{{--            <thead id="sale">--}}
{{--            <tr>--}}
{{--                <th><h2 class="h-center">RF Electronics</h2></th>--}}

{{--            </tr>--}}
{{--            <tr>--}}
{{--                <th><h4 class="h-center">Job Sale Invoice</h4></th>--}}
{{--            </tr>--}}
{{--            </thead>--}}
{{--        </table>--}}
{{--        <hr>--}}
{{--    </div>--}}

{{--    <div class="table-responsive">--}}
{{--        <table id="example" class="display" style="min-width:  100%">--}}
{{--            <thead>--}}
{{--            <tr>--}}
{{--                <td id="invoice"><b>Invoice#</b> {{$items[0]->sifj_id}}</td>--}}
{{--                <td id="date"><b>Date: </b>{{date('d-m-Y', strtotime( $items[0]->sifj_created_at )) }} </td>--}}
{{--            </tr>--}}
{{--            </thead>--}}
{{--        </table>--}}
{{--    </div>--}}


{{--    <div class="table-responsive">--}}
{{--        <table id="example" class="display" style="min-width:  100%">--}}
{{--            <thead>--}}
{{--            <tr>--}}
{{--                <th style="width: 11%;margin-top: 37px; vertical-align: top">Remarks:</th>--}}
{{--                <td id="remarks" class="datas" style="width: 77%">{{$items[0]->sifj_remarks}}</td>--}}
{{--                <td id="job" style="width: 12%; vertical-align: top"><b>Job#:</b> {{$items[0]->ji_id}}</td>--}}
{{--            </tr>--}}


{{--            </thead>--}}
{{--        </table>--}}
{{--    </div>--}}


{{--    <div class="table-responsive">--}}
{{--        <table id="example" class="table table-striped table-bordered display" style="min-width:  100%">--}}
{{--            <thead>--}}
{{--                <tr class="data">--}}
{{--                    <th>Brand</th>--}}
{{--                    <th>Category</th>--}}
{{--                    <th>Model</th>--}}
{{--                    <th>Equipment</th>--}}
{{--                    <th>Serial No</th>--}}
{{--                </tr>--}}
{{--            </thead>--}}
{{--            <tbody>--}}


{{--            <tr class="data">--}}
{{--                <td id="complain">{{$items[0]->bra_name}}</td>--}}
{{--                <td id="ascri">{{$items[0]->cat_name}}</td>--}}
{{--                <td id="complain">{{$items[0]->mod_name}}</td>--}}
{{--                <td id="ascri">{{$items[0]->ji_equipment}}</td>--}}
{{--            </tr>--}}
{{--                <tr class="data">--}}
{{--                    <td class="rowdata">{{$items[0]->bra_name}}</td>--}}
{{--                    <td class="rowdata">{{$items[0]->cat_name}}</td>--}}
{{--                    <td class="rowdata">{{$items[0]->mod_name}}</td>--}}
{{--                    <td class="rowdata">{{$items[0]->ji_equipment}}</td>--}}
{{--                    <td class="rowdata">{{$items[0]->ji_serial_no}}</td>--}}
{{--                </tr>--}}


{{--            </tbody>--}}

{{--        </table>--}}


{{--    </div>--}}

{{--    <div class="table-responsive" >--}}
{{--        <table id="example" class="display" style="overflow: hidden;">--}}
{{--            <thead>--}}
{{--            <tr id="complain">--}}
{{--                @foreach($complain_items as $complain)--}}

{{--                    @if($complain->jii_ji_job_id == $items[0]->sifj_job_no)--}}
{{--                        <th style="vertical-align: top">Complain:</th>--}}
{{--                        <td class="datas" style="vertical-align: top">{{$complain->jii_item_name}}</td>--}}
{{--                    @endif--}}

{{--                @endforeach--}}


{{--                @foreach($accessory_items as $complain)--}}

{{--                    @if($complain->jii_ji_job_id == $items[0]->sifj_job_no)--}}
{{--                        <th style="vertical-align: top">Accessories:</th>--}}
{{--                        <td class="datas" style="vertical-align: top">{{$complain->jii_item_name}}</td>--}}

{{--                    @endif--}}

{{--                @endforeach--}}
{{--            </tr>--}}

{{--            </thead>--}}
{{--        </table>--}}
{{--    </div>--}}

{{--    <hr>--}}
{{--    <div class="table-responsive">--}}
{{--        <table id="example" class="display" style="min-width:  100%">--}}
{{--            <thead>--}}
{{--            <tr >--}}
{{--                <td id="cal"><b>Estimated:</b> {{$items[0]->sifj_estimated_cost}}</td>--}}
{{--                <td id="calc"><b>Amount Pay:</b> {{$items[0]->sifj_amount_paid}}</td>--}}
{{--            </tr >--}}
{{--            <tr >--}}
{{--                <td id="cal"><b>Discount:</b> {{$items[0]->sifj_discount}}</td>--}}
{{--                <td id="calc"><b>Remaining:</b> {{$items[0]->sifj_remaining_cost}}</td>--}}
{{--            </tr>--}}
{{--            </thead>--}}
{{--        </table>--}}
{{--    </div>--}}
{{--</section>--}}
{{--<a href="{{ route('sale_job_invoice_modal_view_details_pdf_sh',['id'=>$items[0]->sifj_id]) }}" class="align_right text-center btn btn-sm btn-info mt-3" style="float: left;margin-top: 7px;">--}}
{{--    Download--}}
{{--</a>--}}

{{--</body>--}}

{{--</html>--}}
