@extends('layouts.app', ['page' => __('Roles List'), 'pageSlug' => 'users', 'section' => 'users'])

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
                        <p class="mb-1">Roles List</p>
                    </div>
                </div>
            </div>
            @include('inc._message')
            <!-- row -->



            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Roles List</h4>

                        </div>
                        <div class="card-body">



                            <div class="table-responsive">
                                <table class="table table-striped table-bordered display" style="min-width: 845px">
                                    <thead>
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Role Name</th>
                                            {{--                                            <th>Created By</th> --}}
                                            {{--                                        <th>Date</th> --}}
                                            {{--                                            <th>Updated At</th> --}}
                                            <th>Actions</th>
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

                                        @foreach ($roles as $key => $role)
                                            <tr>
                                                <td>{{ $sr }}</td>
                                                <td>{{ $role->name }}</td>
                                                <td>
                                                    <a class="btn btn-secondary"
                                                        href="{{ route('roles.show', $role->id) }}">Show</a>
                                                    @can('role-edit')
                                                        <a class="btn btn-primary"
                                                            href="{{ route('roles.edit', $role->id) }}">Edit</a>
                                                    @endcan

                                                </td>
                                            </tr>
                                            @php
                                        $sr++
                                        @endphp
                                        @endforeach

                                        {{--                                    @foreach ($query as $brand) --}}
                                        {{--                                        <tr> --}}
                                        {{--                                            <td>{{$sr}}</td> --}}
                                        {{--                                            <td>{{$brand->vendor_name}}</td> --}}
                                        {{--                                            --}}{{--                                        <td>{{$brand->name}}</td> --}}
                                        {{--                                            <td>{{ date('d-m-Y', strtotime( $brand->vendor_created_at )) }}</td> --}}
                                        {{--                                            --}}{{--                                        <td>{{$brand->vendor_updated_at}}</td> --}}
                                        {{--                                            <td><a href="{{route('edit_vendor',$brand->vendor_id)}}"><i class="fas fa-edit"></i></a></td> --}}
                                        {{--                                        </tr> --}}

                                        {{--                                        @php --}}
                                        {{--                                            $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++; --}}
                                        {{--                                        @endphp --}}
                                        {{--                                    @endforeach --}}


                                    </tbody>

                                </table>

                                {{--                                {!! $roles->render() !!} --}}
                            </div>
                            {{ $roles->links() }}
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
            // $('#form').validate({ // initialize the plugin
            //
            //     rules: {
            //         brand: {
            //             required: true,
            //             pattern: /^[A-Za-z0-9. ]{3,30}$/
            //         }
            //     },
            //     messages: {
            //         brand: {
            //             required: "Required"
            //         }
            //
            //     },
            //
            //     ignore: [],
            //     errorClass: "invalid-feedback animated fadeInUp",
            //     errorElement: "div",
            //     errorPlacement: function (e, a) {
            //         jQuery(a).parents(".form-group > div").append(e)
            //     },
            //     highlight: function (e) {
            //         jQuery(e).closest(".form-group").removeClass("is-invalid").addClass("is-invalid")
            //     },
            //     success: function (e) {
            //         jQuery(e).closest(".form-group").removeClass("is-invalid"), jQuery(e).remove()
            //     },
            //
            // });

        });
    </script>
@stop
