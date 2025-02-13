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
            {{--                                            {{$items[0]->si_total_items}} --}}

            {{--                                        </td> --}}

            {{--                                    </tr> --}}

            {{--                                    <tr> --}}
            {{--                                        <th class="vi_tbl_hdng fontS-12 text-right"> --}}
            {{--                                            <label class="total-items-label text-right"> --}}
            {{--                                                Total --}}
            {{--                                            </label> --}}
            {{--                                        </th> --}}
            {{--                                        <td class="text-right fontS-12"> --}}
            {{--                                            {{$items[0]->si_grand_total}} --}}
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

            {{--                                            {{$items[0]->si_amount_pay}} --}}
            {{--                                        </td> --}}
            {{--                                    </tr> --}}


            {{--                                    <tr> --}}
            {{--                                        <th class="vi_tbl_hdng fontS-12 text-right"> --}}
            {{--                                            <label class="total-items-label text-right"> --}}
            {{--                                                Remaining --}}
            {{--                                            </label> --}}
            {{--                                        </th> --}}
            {{--                                        <td class="text-right fontS-12"> --}}
            {{--                                            {{$items[0]->si_remaining}} --}}
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
                    <td class="rowdata" id="data1">{{ $brand->csi_id }}</td>
                    <td class="rowdata" id="qty">{{ $brand->csi_remarks }}</td>
                    <td class="rowdata">{{ $brand->csi_real_estimated_cost }}</td>
                    <td class="rowdata">{{ $brand->csi_amount_paid }}</td>
                    <td class="rowdata">{{ $brand->csi_discount }}</td>

                    <td class="rowdata">{{ $brand->csi_remaining_cost }}</td>
                    <td class="rowdata">{{ date('d-m-Y', strtotime($brand->csi_created_at)) }}</td>
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

        <a href="{{ route('credit_sale_modal_view_details_pdf_sh', ['id' => $brand->csi_inv_id]) }}"
            class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
            Download
        </a>

        <iframe style="display: none" id="printf" name="printf"
            src="{{ route('credit_sale_modal_view_details_pdf_sh', ['id' => $brand->csi_inv_id]) }}"
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
