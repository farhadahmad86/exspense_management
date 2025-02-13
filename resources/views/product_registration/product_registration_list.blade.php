@extends('layouts.app', ['page' => __('Product Management'), 'pageSlug' => 'users', 'section' => 'users'])

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
                        <p class="mb-1">Product Registration List</p>
                    </div>
                </div>
            </div>
            @include('inc._message')
            <!-- row -->



            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Product Registration List</h4>
                            <!-- Ibrahim add -->
                            {{--                        <button > --}}
                            <div class="srch_box_opn_icon">
                                <i id="search_hide" onclick="hide_the_search();" class="fa fa-search icon-hide"></i>
                            </div>
                            {{--                        </button> --}}
                        </div>
                        <div class="card-body">

                            <form action="{{ route('product_registration.index') }}" method="get">

                                <div class="row">
                                    <div class="col-1-5">
                                        <label for="">Product Name</label>
                                        <div class="form-group mb-0">
                                            <select id="part_name" name="part_name">
                                                <option value="0" selected disabled>Select Product</option>
                                                @foreach ($products_title as $index => $part)
                                                    <option value="{{ $part->par_id }}"
                                                        {{ $product_name == $part->par_id ? 'selected' : '' }}>
                                                        {{ $part->par_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-0-5">
                                        <div class="form-group">
                                            <a href="{{ route('product_registration.index') }}" class="btn btn-primary btn-sm"
                                                id="" style="margin-top: 30px;">
                                                Clear
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <button tabindex="8" class="btn btn-primary btn-sm" id="customer_search"
                                                style="margin-top: 30px;">
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
                                            {{--                                        <th>User Name</th> --}}
                                            <th>Product Name</th>

                                            <th>Purchase Price</th>
{{--                                            <th>Bottom Price</th>--}}
                                            <th>Retail Price</th>
                                            {{--                                        <th>Average Price</th> --}}
                                            {{--                                        <th>Last Purchase Price</th> --}}
                                            <th>Total Quantity</th>
                                            <th>Actions</th>


                                            {{--                                        <th>Created At</th> --}}
                                            {{--                                        <th>Updated At</th> --}}
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



                                        @foreach ($query as $part)
                                            <tr>
                                                <td>{{ $sr }}</td>

                                                {{--                                            <td>{{$part->name}}</td> --}}
                                                <td>{{ $part->par_name }}</td>
                                                <td>{{ $part->par_purchase_price }}</td>

{{--                                                <td>{{ $part->par_bottom_price }}</td>--}}
                                                <td>{{ $part->par_sale_price }}</td>
                                                {{--                                            <td>{{$part->par_avg_price}}</td> --}}
                                                {{--                                            <td>{{$part->par_last_purchase_price}}</td> --}}
                                                <td>{{ $part->par_total_qty }}</td>
                                                <td><a href="{{ route('product_registration.edit', $part->par_id) }}">Edit</a></td>


                                                {{--                                            <td>{{$brand->par_created_at}}</td> --}}
                                                {{--                                            <td>{{$brand->par_updated_at}}</td> --}}
                                            </tr>

                                            @php
                                                $sr++;
                                                !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                                            @endphp
                                        @endforeach


                                    </tbody>

                                </table>
                            </div>
                            {{ $query->appends(['segmentSr' => $countSeg, 'part_name' => $product_name])->links() }}
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
            $('#part_name').select2();
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
