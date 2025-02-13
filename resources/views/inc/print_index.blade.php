<!DOCTYPE html>
<html lang="ur">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href='{{asset("public/vendors/styles/print_main_style.css")}}' media="screen, print">
    <link rel="stylesheet" href='{{asset("public/vendors/styles/table_styles.css")}}' media="screen, print">

    <title> @yield('print_title') </title>

    <style type="text/css">
        @yield('print_styles')
    </style>


</head>

<body>

        @yield('print_cntnt')

{{--@if( isset($type) && $type !== 'grid')--}}
        <table class="table border-0 m-0 p-0">
            <tfoot>
                <tr class="bg-transparent">
                    <td colspan="4" class="border-0 m-0 p-0">
                        <div class="page-footer-space"></div>
                    </td>
                </tr>
            </tfoot>
        </table>

{{--    @yield('print_scrpt')--}}

</body>
</html>
{{--@endif--}}
