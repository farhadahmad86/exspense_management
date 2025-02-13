<table id="" class="table table-striped table-bordered display"
       style="min-width: 845px">
    <thead>
    <tr>

        <th>Job No</th>
        <th>Receiving Date</th>
        <th>Client Name</th>
        <th>Job Title</th>
        <th>Vendor</th>
        <th>Brand</th>
        <th>Category</th>
        <th>Model</th>
        <th>Equipment</th>
        <th>S#</th>
        <th>Fault</th>
        <th>Part Name/ Qty</th>
        <th>Total Amount Pay (Rs)</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($query as $index => $brand)
        <tr>
            {{--                                            <td>{{$sr}}</td> --}}
            <td>{{ $brand->job_id }}</td>
            @php
                $complaint = \App\Models\JobInformationItemsModel::where('jii_ji_job_id',$brand->job_id)->where('jii_status' , 'Complain')->get();
                $issue_parts = \App\Models\IssuePartsToJobModel::where('iptj_job_no',$brand->job_id)->pluck('iptj_inv_id')->first();
                $issue_parts_items = \App\Models\IssuePartsToJobItemsModel::where('iptji_inv_id',$issue_parts)->get();
//                                                $parts = '';
//                                                foreach ($issue_parts_items as $items){
//                                                $parts = \App\Models\PartsModel::where('par_id',$items->iptji_parts)->get();
//                                                }
////                                            dd($issue_parts_items);
//                                            dd($parts);
            @endphp
            <td>{{ $brand->ji_created_at }}</td>
            {{--                                            <td>{{ $technician ? $technician->tech_name : '' }}</td>--}}
            <td>{{ $brand->cli_name }}</td>
            <td> {{ $brand->ji_title }} </td>
            <td>{{ $brand->vendor_name }}</td>
            <td>{{ $brand->bra_name }}</td>
            <td>{{ $brand->cat_name }}</td>
            <td>{{ $brand->mod_name }}</td>
            <td>{{ $brand->ji_equipment }}</td>
            <td>{{ $brand->ji_serial_no }}</td>
            <td>
                @foreach($complaint as  $comp)
                    {{$comp->jii_item_name}}
{{--                    <hr style="margin: 3px; border: none;height: 2px;background-color: black;"></hr>--}}
                @endforeach
            </td>
            <td>
                @foreach($issue_parts_items as  $items)
                    {{ \App\Models\PartsModel::where('par_id', $items->iptji_parts)->first()->par_name }} - Qty {{$items->iptji_qty}} /
{{--                    <hr style="margin: 3px; border: none;height: 2px;background-color: black;"></hr>--}}
                @endforeach

            </td>
            <td>{{ $brand->sifj_amount_paid }}</td>
        </tr>
    @endforeach
    </tbody>

</table>
