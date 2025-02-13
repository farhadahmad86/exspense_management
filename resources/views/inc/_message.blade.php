@if (count($errors) > 0)
    <ul class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
        </button>
        @foreach ($errors->all() as $error)
            <li>

                {{ $error }}
            </li>
        @endforeach
    </ul>
@endif

@if (Session::get('info'))
    <div class="alert alert-info alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
        </button>
        <strong>Info!</strong> {{ Session::get('info') }}
    </div>
@endif

{{--@if (Session::get('success'))--}}
{{--    <div class="alert alert-success alert-dismissible" role="alert" style="background-color: #20b16e;border-color: #20b16e">--}}
{{--        <button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
{{--            <span aria-hidden="true">&times;</span>--}}
{{--            <span class="sr-only">Close</span>--}}
{{--        </button>--}}
{{--        <strong>Success!</strong> {{ Session::get('success') }}--}}
{{--    </div>--}}
{{--@endif--}}

@if (Session::get('warning'))
    <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
        </button>
        <strong>Warning!</strong> {{ Session::get('warning') }}
    </div>
@endif

{{--@if (Session::get('danger'))--}}
{{--    <div class="alert alert-danger alert-dismissible" role="alert">--}}
{{--        <button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
{{--            <span aria-hidden="true">&times;</span>--}}
{{--            <span class="sr-only">Close</span>--}}
{{--        </button>--}}
{{--        <strong>Error!</strong> {{ Session::get('danger') }}--}}
{{--    </div>--}}
{{--@endif--}}

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
@if (Session::get('success'))
    <script>
        Swal.fire({

            icon: 'success',
            title: '{{Session::get('success')}}',
            showConfirmButton: false,
            timer: 1800,
        })
    </script>
@endif
@if (Session::get('fail'))

    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ Session::get('fail') }}',
            timer: 3000,
            showConfirmButton: false,
            // footer: '<a href>Why do I have this issue?</a>'
        })
    </script>
@endif
