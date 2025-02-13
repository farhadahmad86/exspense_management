@extends('inc.print_index')

@section('print_cntnt')
    <style>
        .h-center {
            text-align: center;
            color: black;
        }
    </style>
    <h2 class="h-center">Sale Invoice</h2>


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
                        <b>Invoice#: </b>{{ $items[0]->si_inv_id }}
                    </p>
                    <p class="invoice_para m-0 pt-0">
                        <b>Date</b> {{ date('d-m-Y', strtotime($items[0]->si_created_at)) }}
                    </p>
                    <p class="invoice_para m-0 pt-0">
                        <b>Remarks: </b>{{ $items[0]->si_remarks }}
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
                    <th>Product</th>
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
                    <td class="rowdata" id="qty">{{ $brand->sii_qty }}</td>
                    <td class="rowdata" id="rate">{{ $brand->sii_rate }}</td>
                    <td class="rowdata" id="dis">{{ $brand->sii_discount }}</td>
                    <td class="rowdata" id="amount">{{ $brand->sii_amount }}</td>
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
                                                {{ $items[0]->si_total_items }}

                                            </td>

                                        </tr>

                                        <tr>
                                            <th class="vi_tbl_hdng fontS-12 text-right">
                                                <label class="total-items-label text-right">
                                                    Total
                                                </label>
                                            </th>
                                            <td class="text-right fontS-12">
                                                {{ $items[0]->si_grand_total }}
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

                                                {{ $items[0]->si_amount_pay }}
                                            </td>
                                        </tr>


                                        <tr>
                                            <th class="vi_tbl_hdng fontS-12 text-right">
                                                <label class="total-items-label text-right">
                                                    Remaining
                                                </label>
                                            </th>
                                            <td class="text-right fontS-12">
                                                {{ $items[0]->si_remaining }}
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
    </div>



    <div class="itm_vchr_rmrks">

        <a href="{{ route('sale_invoice_modal_view_details_pdf_sh', ['id' => $brand->sii_inv_id]) }}"
            class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
            Download
        </a>

        <iframe style="display: none" id="printf" name="printf"
            src="{{ route('sale_invoice_modal_view_details_pdf_sh', ['id' => $brand->sii_inv_id]) }}"
            title="W3Schools Free Online Web
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







































{{-- <html> --}}
{{-- <head></head> --}}
{{-- <body> --}}
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
{{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> --}}
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css"> --}}
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script> --}}
{{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}
{{-- <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script> --}}
{{-- <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script> --}}
{{-- <style> --}}

{{--    .col-1-5 { --}}
{{--        flex: 0 0 12.6%; --}}
{{--        max-width: 12.6%; --}}
{{--        position: relative; --}}
{{--        width: 100%; --}}
{{--        padding-right: 15px; --}}
{{--        padding-left: 15px; --}}
{{--    } --}}


{{-- </style> --}}
{{-- <style> --}}


{{--    table{ --}}
{{--        width: 100%; --}}
{{--        color: black; --}}
{{--        padding: 5px !important; --}}
{{--    } --}}
{{--    .h-center{ --}}
{{--        text-align: center; --}}
{{--        color: black; --}}
{{--    } --}}
{{--    tbody{ --}}
{{--        overflow-y: hidden!important; --}}
{{--    } --}}
{{--    .tabl{ --}}
{{--        /*border: 1px solid #000000;*/ --}}
{{--    } --}}

{{--    #invoice, #job{ --}}
{{--        text-align: left; --}}
{{--        /*font-size: 20px;*/ --}}
{{--    } --}}
{{--    .remarks{ --}}
{{--        text-align: left; --}}
{{--        /*font-size: 20px;*/ --}}
{{--        font-weight: normal; --}}
{{--        padding-top: 25px; --}}
{{--        padding-bottom: 10px; --}}
{{--        white-space: break-spaces; --}}
{{--        line-height: 1; --}}
{{--        vertical-align: baseline; --}}
{{--    } --}}
{{--    #date{ --}}
{{--        text-align: right; --}}
{{--        /*font-size: 20px;*/ --}}
{{--        /*font-weight: bold;*/ --}}
{{--    } --}}
{{--    #data{ --}}
{{--        position: relative; --}}
{{--        /*left: 30px;*/ --}}
{{--    } --}}
{{--    #data1{ --}}
{{--        position: relative; --}}
{{--        /*left: 28px;*/ --}}
{{--        /*font-size: 20px;*/ --}}
{{--        margin-bottom: 10px; --}}
{{--    } --}}
{{--    #qty{ --}}
{{--        position: relative; --}}
{{--        /*left: 40px;*/ --}}
{{--        padding-top: 15px; --}}

{{--        padding-bottom: 5px; --}}
{{--    } --}}
{{--    #rate{ --}}
{{--        position: relative; --}}
{{--        /*left: 40px;*/ --}}
{{--        padding-top: 5px; --}}
{{--        padding-bottom: 5px; --}}
{{--    } --}}
{{--    #dis{ --}}
{{--        position: relative; --}}
{{--        /*left: 50px;*/ --}}
{{--        padding-top: 5px; --}}
{{--        padding-bottom: 5px; --}}
{{--    } --}}
{{--    #amount{ --}}
{{--        position: relative; --}}
{{--        /*left: 50px;*/ --}}
{{--        padding-top: 5px; --}}
{{--        padding-bottom: 5px; --}}
{{--    } --}}
{{--    #total{ --}}
{{--        /*font-size: 20px;*/ --}}
{{--        text-align: right; --}}
{{--        padding-bottom: 5px; --}}
{{--        padding-right: 43px; --}}
{{--    } --}}




{{-- </style> --}}



{{-- <section class="tabl"> --}}

{{--    <div class="table-responsive"> --}}
{{--        <table id="example" class="display" style="min-width: 100%;background-color: silver; margin-bottom: 16px;"> --}}
{{--            <thead> --}}
{{--            <tr> --}}
{{--                <th><h2 class="h-center">RF Electronics</h2></th> --}}

{{--            </tr> --}}
{{--            <tr> --}}

{{--                <th><h4 class="h-center">Purchase Invoice</h4></th> --}}
{{--            </tr> --}}
{{--            </thead> --}}
{{--        </table> --}}
{{--    </div> --}}

{{--    <div class="table-responsive"> --}}
{{--        <table id="example" class="display" style="min-width: 100%"> --}}
{{--            <thead> --}}
{{--            <tr> --}}
{{--                <td id="invoice"><b>Invoice#</b> {{$items[0]->pi_id}}</td> --}}
{{--                <td id="date"><b>Date: </b>{{date('d-m-Y', strtotime( $items[0]->pi_created_at )) }}</td> --}}
{{--            </tr> --}}
{{--            </thead> --}}
{{--        </table> --}}
{{--        <hr> --}}
{{--    </div> --}}

{{--    <div class="table-responsive"> --}}
{{--        <table id="example" class="display" style="min-width: 100%"> --}}
{{--            <thead> --}}
{{--            <tr> --}}
{{--                <th id="remarks" class="remarks" style="width: 15%"><strong>Remarks# </strong></th> --}}
{{--                <td class="remarks" style="width:100%">{{$items[0]->pi_remarks}}</td> --}}
{{--            </tr> --}}
{{--            </thead> --}}
{{--        </table> --}}
{{--    </div> --}}

{{--    <div class="table-responsive"> --}}
{{--        <table id="example" class="table table-striped table-bordered display" style="min-width: 100%"> --}}
{{--            <thead> --}}
{{--            <tr id="data1"> --}}
{{--                <th>Sr#</th> --}}
{{--                <th>Part</th> --}}
{{--                <th>Quantity</th> --}}
{{--                <th>Rate</th> --}}
{{--                <th>Discount</th> --}}
{{--                <th>Amount</th> --}}

{{--            </tr> --}}
{{--            </thead> --}}
{{--            <tbody> --}}

{{--            @php --}}
{{--                $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : ''; --}}
{{--                $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : ''; --}}
{{--                $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1; --}}
{{--                $countSeg = (!empty($segmentSr)) ? $segmentSr : 0; --}}
{{--                $prchsPrc = $slePrc = $avrgPrc = 0; --}}
{{--            @endphp --}}




{{--            @foreach ($items as $brand) --}}
{{--                <tr> --}}
{{--                    <td id="data">{{$sr}}</td> --}}
{{--                    <td id="data1">{{$brand->par_name}}</td> --}}
{{--                    <td id="qty">{{$brand->pii_qty}}</td> --}}
{{--                    <td id="rate">{{$brand->pii_rate}}</td> --}}
{{--                    <td id="dis">{{$brand->pii_discount}}</td> --}}
{{--                    <td id="amount">{{$brand->pii_amount}}</td> --}}
{{--                </tr> --}}
{{--            @endforeach --}}

{{--            @php --}}
{{--                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++; --}}
{{--            @endphp --}}


{{--            </tbody> --}}

{{--        </table> --}}



{{--    </div> --}}
{{-- <hr> --}}
{{--    <div class="table-responsive"> --}}
{{--        <table id="example" class="display" style="min-width: 100%"> --}}
{{--            <thead> --}}
{{--            <tr> --}}
{{--                <td id="total"><b>Total:</b> {{$items[0]->pi_grand_total}}</td> --}}
{{--            </tr> --}}
{{--            </thead> --}}
{{--        </table> --}}
{{--    </div> --}}
{{-- </section> --}}

{{-- <a href="{{ route('purchase_invoice_modal_view_details_pdf_sh',['id'=>$brand->pii_pi_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;"> --}}
{{--    Download --}}
{{-- </a> --}}

{{-- </body> --}}

{{-- </html> --}}









































{{-- <html> --}}
{{-- <head></head> --}}
{{-- <body> --}}

{{-- <style> --}}

{{--    .col-1-5 { --}}
{{--        flex: 0 0 12.6%; --}}
{{--        max-width: 12.6%; --}}
{{--        position: relative; --}}
{{--        width: 100%; --}}
{{--        padding-right: 15px; --}}
{{--        padding-left: 15px; --}}
{{--    } --}}


{{-- </style> --}}
{{-- <style> --}}


{{--    table{ --}}
{{--        width: 100%; --}}
{{--        color: black; --}}
{{--        padding: 5px; --}}
{{--    } --}}
{{--    table h2, h4{ --}}
{{--        text-align: center; --}}
{{--        color: black; --}}
{{--    } --}}

{{--    .tabl{ --}}
{{--        border: 1px solid #000000; --}}
{{--    } --}}

{{--    #invoice{ --}}
{{--        text-align: left; --}}
{{--        font-size: 20px; --}}
{{--        padding-top: 5px; --}}
{{--        padding-bottom: 15px; --}}
{{--    } --}}
{{--    #remarks{ --}}
{{--        text-align: left; --}}
{{--        font-size: 20px; --}}
{{--        font-weight: normal; --}}
{{--        padding-top: 5px; --}}
{{--        padding-bottom: 15px; --}}
{{--    } --}}
{{--    #date{ --}}
{{--        text-align: right; --}}
{{--        font-size: 20px; --}}
{{--        font-weight: bold; --}}
{{--    } --}}
{{--    #data{ --}}
{{--        position: relative; --}}
{{--        left: 30px; --}}
{{--    } --}}
{{--    #data1{ --}}
{{--        position: relative; --}}
{{--        left: 28px; --}}
{{--        font-size: 20px; --}}
{{--        padding-bottom: 15px; --}}
{{--    } --}}
{{--    #qty{ --}}
{{--        position: relative; --}}
{{--        left: 40px; --}}
{{--        padding-top: 15px; --}}

{{--        padding-bottom: 5px; --}}
{{--    } --}}
{{--    #rate{ --}}
{{--        position: relative; --}}
{{--        left: 40px; --}}
{{--        padding-top: 5px; --}}
{{--        padding-bottom: 5px; --}}
{{--    } --}}
{{--    #dis{ --}}
{{--        position: relative; --}}
{{--        left: 50px; --}}
{{--        padding-top: 5px; --}}
{{--        padding-bottom: 5px; --}}
{{--    } --}}
{{--    #amount{ --}}
{{--        position: relative; --}}
{{--        left: 50px; --}}
{{--        padding-top: 5px; --}}
{{--        padding-bottom: 5px; --}}
{{--    } --}}
{{--    #total{ --}}
{{--        font-size: 20px; --}}
{{--        text-align: center; --}}
{{--        padding-top: 10px; --}}
{{--        padding-bottom: 15px; --}}
{{--    } --}}




{{-- </style> --}}
{{-- <style> --}}


{{--    table{ --}}
{{--        width: 100%; --}}
{{--        color: black; --}}
{{--        padding: 5px !important; --}}
{{--    } --}}
{{--    .h-center{ --}}
{{--        text-align: center; --}}
{{--        color: black; --}}
{{--    } --}}
{{--    tbody{ --}}
{{--        overflow-y: hidden!important; --}}
{{--    } --}}
{{--    thead{ --}}
{{--        width: 100%; --}}
{{--    } --}}

{{--    .tabl{ --}}
{{--        /*border: 1px solid #000000;*/ --}}
{{--    } --}}

{{--    #invoice, #job{ --}}
{{--        text-align: left; --}}
{{--        /*font-size: 20px;*/ --}}
{{--    } --}}
{{--    .remarks{ --}}
{{--        text-align: left; --}}
{{--        /*font-size: 20px;*/ --}}
{{--        font-weight: normal; --}}
{{--        padding-top: 25px; --}}
{{--        padding-bottom: 10px; --}}
{{--        white-space: break-spaces; --}}
{{--        line-height: 1; --}}
{{--        vertical-align: baseline; --}}
{{--    } --}}
{{--    #date{ --}}
{{--        text-align: right; --}}
{{--        /*font-size: 20px;*/ --}}
{{--        font-weight: bold; --}}
{{--    } --}}
{{--    #data{ --}}
{{--        position: relative; --}}
{{--        /*left: 30px;*/ --}}
{{--    } --}}
{{--    #data1{ --}}
{{--        position: relative; --}}
{{--        /*left: 28px;*/ --}}
{{--        /*font-size: 20px;*/ --}}
{{--        margin-bottom: 10px; --}}
{{--    } --}}
{{--    #qty{ --}}
{{--        position: relative; --}}
{{--        /*left: 40px;*/ --}}
{{--        padding-top: 15px; --}}

{{--        padding-bottom: 5px; --}}
{{--    } --}}
{{--    #rate{ --}}
{{--        position: relative; --}}
{{--        /*left: 40px;*/ --}}
{{--        padding-top: 5px; --}}
{{--        padding-bottom: 5px; --}}
{{--    } --}}
{{--    #dis{ --}}
{{--        position: relative; --}}
{{--        /*left: 50px;*/ --}}
{{--        padding-top: 5px; --}}
{{--        padding-bottom: 5px; --}}
{{--    } --}}
{{--    #amount{ --}}
{{--        position: relative; --}}
{{--        /*left: 50px;*/ --}}
{{--        padding-top: 5px; --}}
{{--        padding-bottom: 5px; --}}
{{--    } --}}
{{--    #total{ --}}
{{--        /*font-size: 20px;*/ --}}
{{--        text-align: right; --}}
{{--        padding-bottom: 5px; --}}
{{--        padding-right: 43px; --}}
{{--    } --}}




{{-- </style> --}}

{{-- <section class="tabl"> --}}
{{--    <div class="table-responsive"> --}}
{{--        <table id="example" class="display" style="min-width: 100%"> --}}
{{--            <thead> --}}
{{--            <tr> --}}
{{--                <th><h2 class="h-center">RF Electronics</h2></th> --}}

{{--            </tr> --}}
{{--            <tr> --}}

{{--                <th><h4 class="h-center">Sale Invoice</h4></th> --}}
{{--            </tr> --}}
{{--            </thead> --}}
{{--        </table> --}}
{{--    </div> --}}

{{--    <div class="table-responsive"> --}}
{{--        <table id="example" class="display" style="min-width: 100%"> --}}
{{--            <thead> --}}
{{--            <tr> --}}
{{--                <th id="invoice"><b>Invoice#</b> {{$items[0]->si_id}}</th> --}}
{{--                <th id="date"><b>Date: </b>{{date('d-m-Y', strtotime( $items[0]->si_created_at )) }}</th> --}}
{{--            </tr> --}}
{{--            </thead> --}}
{{--        </table> --}}
{{--    </div> --}}

{{--    <div class="table-responsive"> --}}
{{--        <table id="example" class="display" style="min-width: 100%"> --}}
{{--            <thead> --}}
{{--            <tr> --}}
{{--                <th id="remarks" class="remarks" style="width: 15%"><strong>Remarks# </strong></th> --}}
{{--                <td class="remarks" style="width:100%">{{$items[0]->si_remarks}}</td> --}}
{{--            </tr> --}}
{{--            </thead> --}}
{{--        </table> --}}
{{--    </div> --}}


{{--    <div class="table-responsive"> --}}
{{--        <table id="example" class="table table-striped table-bordered display" style="min-width: 100%"> --}}
{{--            <thead> --}}
{{--            <tr id="data1"> --}}
{{--                <th>Sr#</th> --}}
{{--                <th>Part</th> --}}
{{--                <th>Quantity</th> --}}
{{--                <th>Rate</th> --}}
{{--                <th>Discount</th> --}}
{{--                <th>Amount</th> --}}

{{--            </tr> --}}
{{--            </thead> --}}
{{--            <tbody style="overflow: hidden!important;"> --}}

{{--            @php --}}
{{--                $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : ''; --}}
{{--                $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : ''; --}}
{{--                $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1; --}}
{{--                $countSeg = (!empty($segmentSr)) ? $segmentSr : 0; --}}
{{--                $prchsPrc = $slePrc = $avrgPrc = 0; --}}
{{--            @endphp --}}




{{--            @foreach ($items as $brand) --}}
{{--                <tr> --}}
{{--                    <td id="data">{{$sr}}</td> --}}
{{--                    <td id="data">{{$brand->par_name}}</td> --}}
{{--                    <td id="qty">{{$brand->sii_qty}}</td> --}}
{{--                    <td id="rate">{{$brand->sii_rate}}</td> --}}
{{--                    <td id="dis">{{$brand->sii_discount}}</td> --}}
{{--                    <td id="amount">{{$brand->sii_amount}}</td> --}}
{{--                </tr> --}}
{{--            @endforeach --}}

{{--            @php --}}
{{--                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++; --}}
{{--            @endphp --}}


{{--            </tbody> --}}

{{--        </table> --}}

{{--    </div> --}}

{{--    <div class="table-responsive"> --}}
{{--        <table id="example" class="display" style="min-width: 100%"> --}}
{{--            <thead> --}}
{{--            <tr> --}}
{{--                <td id="total"><b>Total:</b> {{$items[0]->si_grand_total}}</td> --}}
{{--            </tr> --}}
{{--            </thead> --}}
{{--        </table> --}}
{{--    </div> --}}

{{-- </section> --}}


{{-- <a href="{{ route('sale_invoice_modal_view_details_pdf_sh',['id'=>$brand->sii_si_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;"> --}}
{{--    Download --}}
{{-- </a> --}}

{{-- </body> --}}

{{-- </html> --}}
