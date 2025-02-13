<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $page }} - {{ session('company_name') ? session('company_name') : config('app.name') }}</title>
        <!-- Favicon -->
        @php
            $faviconUrl = session('company_logo') ? asset(session('company_logo')) : asset('public/assets/img/default-favicon.png');
        @endphp
        <link rel="icon" href="{{ $faviconUrl }}" type="image/x-icon">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@100;200;300;400;500;600&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.23.0/slimselect.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

        <!-- Icons -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <link href="{{ asset('public/assets') }}/css/nucleo-icons.css" rel="stylesheet" />

        <!-- CSS -->
        <link href="{{ asset('public/assets') }}/css/white-dashboard.css?v=1.0.0" rel="stylesheet" />
        <link href="{{ asset('public/assets') }}/css/theme.css" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body class="white-content {{ $class ?? '' }}">
        @auth()
            <div class="wrapper">
                    @include('layouts.navbars.sidebar')
                <div class="main-panel">
                    @include('layouts.navbars.navbar')

                    <div class="content">
                        @yield('content')
                    </div>
                    <div class="footer hidden-print">
                        <div class="copyright" style="float: none">
                            <p style="text-align: center;font-size: 14px;font-weight: 700;">Copyright © Designed &amp; Developed by
                                <a href="#" target="_blank" style="font-size: 16px;font-weight: 600;">Byte+</a>
                                <span id="current-year"></span>
                            </p>
                        </div>
                    </div>
                    <script>
                        document.getElementById('current-year').textContent = new Date().getFullYear();
                    </script>
                </div>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @else
            @include('layouts.navbars.navbar')
            <div class="wrapper wrapper-full-page">
                <div class="full-page {{ $contentClass ?? '' }}">
                    <div class="content">
                        <div class="container">
                            @yield('content')
                        </div>
                        <div class="footer hidden-print">
                            <div class="copyright" style="float: none">
                                <p style="text-align: center;font-size: 14px;font-weight: 700;">Copyright © Designed &amp; Developed by
                                    <a href="#" target="_blank" style="font-size: 16px;font-weight: 600;">Byte+</a>
                                    <span id="current-year"></span>
                                </p>
                            </div>
                        </div>
                        <script>
                            document.getElementById('current-year').textContent = new Date().getFullYear();
                        </script>
                    </div>
                </div>
            </div>
        @endauth

{{--        <script src="{{ asset('public/assets') }}/js/core/jquery.min.js"></script>--}}
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

        <!-- jQuery UI -->
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <script src="{{ asset('public/assets') }}/js/core/popper.min.js"></script>
        <script src="{{ asset('public/assets') }}/js/core/bootstrap.min.js"></script>
        <script src="{{ asset('public/assets') }}/js/plugins/perfect-scrollbar.jquery.min.js"></script>
        <!-- Chart JS -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        {{-- <script src="{{ asset('public/assets') }}/js/plugins/chartjs.min.js"></script> --}}
        <!--  Notifications Plugin    -->
        <script src="{{ asset('public/assets') }}/js/plugins/bootstrap-notify.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="{{ asset('public/assets') }}/js/white-dashboard.min.js?v=1.0.0"></script>
        <script src="{{ asset('public/assets') }}/js/theme.js"></script>
        <script>
            $(document).ready(function() {
                $().ready(function() {
                    $sidebar = $('.sidebar');
                    $navbar = $('.navbar');
                    $main_panel = $('.main-panel');

                    $full_page = $('.full-page');

                    $sidebar_responsive = $('body > .navbar-collapse');
                    sidebar_mini_active = true;
                    white_color = false;

                    window_width = $(window).width();

                    fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

                    $('.fixed-plugin a').click(function(event) {
                        if ($(this).hasClass('switch-trigger')) {
                            if (event.stopPropagation) {
                                event.stopPropagation();
                            } else if (window.event) {
                                window.event.cancelBubble = true;
                            }
                        }
                    });

                    $('.fixed-plugin .background-color span').click(function() {
                        $(this).siblings().removeClass('active');
                        $(this).addClass('active');

                        var new_color = $(this).data('color');

                        if ($sidebar.length != 0) {
                            $sidebar.attr('data', new_color);
                        }

                        if ($main_panel.length != 0) {
                            $main_panel.attr('data', new_color);
                        }

                        if ($full_page.length != 0) {
                            $full_page.attr('filter-color', new_color);
                        }

                        if ($sidebar_responsive.length != 0) {
                            $sidebar_responsive.attr('data', new_color);
                        }
                    });

                    $('.switch-sidebar-mini input').on("switchChange.bootstrapSwitch", function() {
                        var $btn = $(this);

                        if (sidebar_mini_active == true) {
                            $('body').removeClass('sidebar-mini');
                            sidebar_mini_active = false;
                            whiteDashboard.showSidebarMessage('Sidebar mini deactivated...');
                        } else {
                            $('body').addClass('sidebar-mini');
                            sidebar_mini_active = true;
                            whiteDashboard.showSidebarMessage('Sidebar mini activated...');
                        }

                        // we simulate the window Resize so the charts will get updated in realtime.
                        var simulateWindowResize = setInterval(function() {
                            window.dispatchEvent(new Event('resize'));
                        }, 180);

                        // we stop the simulation of Window Resize after the animations are completed
                        setTimeout(function() {
                            clearInterval(simulateWindowResize);
                        }, 1000);
                    });

                    $('.switch-change-color input').on("switchChange.bootstrapSwitch", function() {
                            var $btn = $(this);

                            if (white_color == true) {
                                $('body').addClass('change-background');
                                setTimeout(function() {
                                    $('body').removeClass('change-background');
                                    $('body').removeClass('white-content');
                                }, 900);
                                white_color = false;
                            } else {
                                $('body').addClass('change-background');
                                setTimeout(function() {
                                    $('body').removeClass('change-background');
                                    $('body').addClass('white-content');
                                }, 900);

                                white_color = true;
                            }
                    });

                    $('.light-badge').click(function() {
                        $('body').addClass('white-content');
                    });

                    $('.dark-badge').click(function() {
                        $('body').removeClass('white-content');
                    });
                });
            });
            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.23.0/slimselect.min.js"></script>
        <script>
            $(document).ready(function() {
                $("#from_date").datepicker();
                $("#to_date").datepicker();
            })
            function lettersOnly(e) {
                var keyCode = e.keyCode || e.which;
                var regex = /^[A-Za-z ]+$/;
                var isValid = regex.test(String.fromCharCode(keyCode));
                return isValid;
            }

            function numbersOnly(evt) {
                var charCode = (evt.which) ? evt.which : event.keyCode
                if (charCode > 31 && (charCode < 48 || charCode > 57))
                    return false;
                else {
                    // event.classList.add('was-validated')
                    return true;
                }
            }

            function validateInventoryInputs(InputIdArray) {
                let i = 0,
                    flag = false,
                    getInput = '';

                for (i; i < InputIdArray.length; i++) {
                    if (InputIdArray) {
                        getInput = document.getElementById(InputIdArray[i]);
                        if (getInput.value === '' || getInput.value === 0) {
                            getInput.focus();
                            getInput.classList.add('red-border');
                            flag = false;
                            break;
                        } else {
                            getInput.classList.remove('red-border');
                            flag = true;
                        }
                    }
                }
                return flag;
            }

            function numberFormatter(event) {
                var Number = $("#number").val();
                var Number_length = Number.length;
                if (Number_length == 4) {
                    $("#number").val(Number + "-");
                }

                if (Number_length > 11) {
                    event.preventDefault();
                }
                // numbersOnly(event);
                var charCode = (event.which) ? event.which : event.keyCode
                if (charCode > 31 && (charCode < 48 || charCode > 57))
                    return false;
                else {
                    // event.classList.add('was-validated')
                    numbersOnly(event);
                    return true;
                }


            }
            function cnicFormatter(event) {
                var cnic = $("#cnic").val();
                var cnic_length = cnic.length;

                // alert(cnic);
                // alert(cnic_length);

                if (cnic_length == 5) {
                    $("#cnic").val(cnic + "-");
                }

                if (cnic_length == 13) {
                    $("#cnic").val(cnic + "-");
                }

                if (cnic_length > 14) {
                    event.preventDefault();
                }
                var charCode = (event.which) ? event.which : event.keyCode
                if (charCode > 31 && (charCode < 48 || charCode > 57))
                    return false;
                else {
                    // event.classList.add('was-validated')
                    numbersOnly(event);
                    return true;
                }
            }

        </script>
        <script>

            $('input[type="checkbox"]').change(function (e) {

                var checked = $(this).prop("checked"),
                    container = $(this).parent(),
                    siblings = container.siblings();

                container.find('input[type="checkbox"]').prop({
                    interminate: false,
                    checked: checked
                });


                function checkSiblings(el) {

                    var parent = el.parent().parent(),
                        all = true;

                    el.siblings().each(function () {
                        return all = ($(this).children('input[type="checkbox"]').prop("checked") === checked);
                    });

                    if (all && checked) {

                        parent.childern('input[type="checkbox"]').prop("checked", checked);
                        parent.childern('input[type="checkbox"]').prop("indeterminate", (parent.find('input[type="checkbox"]:checked').length > 0));
                        checkSiblings(parent);

                    } else {

                        el.parents("li").children('input[type="checkbox"]').prop({
                            indeterminate: true,
                            checked: false
                        });

                    }


                }

                checkSiblings(container);
            });


            function display_li(id) {
                let display = document.getElementById("li-div[" + id + "]").style.display;
                console.log(display);
                if (display == "none") {
                    document.getElementById("li-div[" + id + "]").style.display = "block";
                } else {
                    document.getElementById("li-div[" + id + "]").style.display = "none";
                }

            }
            // function showPassword() {
            //     var x = document.getElementById("password");
            //     var y = document.getElementById("eye");
            //     if (x.type == "password") {
            //         y.classList.add("fa-eye-slash");
            //         y.classList.remove("fa-eye");
            //         x.type = "text";
            //     } else {
            //         y.classList.add("fa-eye");
            //         y.classList.remove("fa-eye-slash");
            //         x.type = "password";
            //     }
            // }
            //
            // function showPassword2() {
            //     var x = document.getElementById("confirm_password");
            //     var y = document.getElementById("eye2");
            //     if (x.type == "password") {
            //         y.classList.add("fa-eye-slash");
            //         y.classList.remove("fa-eye");
            //         x.type = "text";
            //     } else {
            //         y.classList.add("fa-eye");
            //         y.classList.remove("fa-eye-slash");
            //         x.type = "password";
            //     }
            // }
        </script>
        @stack('js')
        @yield('script')
    </body>
</html>
