@extends('layouts.app', ['page' => __('Create Opening Stock'), 'pageSlug' => 'users', 'section' => 'users'])

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
        .input{
            border: none;
            background: none;
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
                        <p class="mb-1">Create Opening Stock</p>
                    </div>
                </div>
            </div>
        @include('inc._message')
        <!-- row -->



            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Create Opening Stock</h4>

                        </div>
                        <div class="card-body">

                            <form action="{{ route('add_openning') }}" method="get">

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
                                            <a href="{{ route('add_openning') }}" class="btn btn-primary btn-sm"
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

                            <form class="form-valide" id="form" action="{{route('store_openning')}}"
                                  method="post" onsubmit="return checkform()">
                                @csrf

                            <div class="table-responsive">
                                <table id="" class="table table-striped table-bordered display" style="min-width: 845px">
                                    <thead>
                                    <tr>
                                        <th>Sr#</th>
                                        {{--                                        <th>User Name</th>--}}
                                        <th>Product Name</th>

{{--                                        <th>Purchase Price</th>--}}
{{--                                        <th>Bottom Price</th>--}}
{{--                                        <th>Retail Price</th>--}}
                                        {{--                                        <th>Average Price</th>--}}
                                        {{--                                        <th>Last Purchase Price</th>--}}
                                        <th>Opening stock</th>
{{--                                        <th>Cutternt stock</th>--}}
{{--                                        <th>Total stock</th>--}}


                                        {{--                                        <th>Created At</th>--}}
                                        {{--                                        <th>Updated At</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>


                                    @php
                                        $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                                        $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                                        $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                                        $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                                        $prchsPrc = $slePrc = $avrgPrc = 0;
                                    @endphp


{{--                                    {{$counter = 1}}--}}
                                    @foreach($parts as $part)
                                    <tr>
                                        <td>{{$sr}}</td>

                                        <td hidden><input name="part_id[]"  class="input" readonly value="{{$part->par_id}}"></td>
{{--                                        <td><input id="part_name[]" class="input" readonly value="{{$part->par_sale_price}}"></td>--}}
                                        <td><input name="part_purchase[]" class="input" readonly value="{{$part->par_name}}"></td>
{{--                                        <td><input id="part_bottom[]" class="input" readonly value="{{$part->par_purchase_price}}"></td>--}}
{{--                                        <td><input id="part_retail[]" class="input" readonly value="{{$part->par_bottom_price}}"></td>--}}
{{--                                        <td><input id="part_opening[]" class="input" onkeyup="add_openning()"></td>--}}

                                        <td><input onkeypress="return numbersOnly(event)" name="qty[]" class="input" ></td>
{{--                                        <td><input onkeypress="return numbersOnly(event)" name="qty[]" class="input" value="{{$part->par_total_qty}}" ></td>--}}
{{--                                        <td><input id="part_id[]" class="input" readonly></td>--}}

                                    </tr>

{{--                                        {{$counter++}}--}}

                                    @php
                                        $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                                    @endphp
                                    @endforeach




                                    </tbody>

                                </table>
                            </div>
                            {{ $parts->links() }}
                                <button type="submit" class="btn btn-primary" tabindex="8">Save
                                </button>

                            </form>
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
        $(document).ready(function () {
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
                errorPlacement: function (e, a) {
                    jQuery(a).parents(".form-group > div").append(e)
                },
                highlight: function (e) {
                    jQuery(e).closest(".form-group").removeClass("is-invalid").addClass("is-invalid")
                },
                success: function (e) {
                    jQuery(e).closest(".form-group").removeClass("is-invalid"), jQuery(e).remove()
                },

            });


        });
        function add_openning(){
            alert("work");
        }
    </script>
@stop
