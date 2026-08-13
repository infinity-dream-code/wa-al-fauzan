@php use Carbon\Carbon; @endphp
    <!DOCTYPE html>

<html
    lang="en"
    class="light-style layout-navbar-fixed layout-menu-fixed layout-compact"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="{{asset('')}}"
    data-template="vertical-menu-template">
<head>
    <meta charset="utf-8"/>
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>

    <title>@yield('title', config('app.name'))</title>

    <meta name="description" content=""/>

    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{asset('icon1.jpeg')}}"/>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
        rel="stylesheet"/>

    <!-- Icons -->
    <link rel="stylesheet" href="{{asset('main/fonts/remixicons/remixicon.min.css')}}"/>

    <!-- Menu waves for no-customizer fix -->
    {{--    <link rel="stylesheet" href="{{asset('main/libs/node-waves/node-waves.css')}}"/>--}}

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('main/libs/perfect-scrollbar/perfect-scrollbar.css')}}"/>
    <link rel="stylesheet" href="{{asset('main/libs/sweetalert2/sweetalert2.css')}}"/>
    <link rel="stylesheet" href="{{asset('main/libs/spinkit/spinkit.css')}}"/>

    <!-- Page CSS -->
    @yield('style')

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('css/demo.css')}}"/>

    <link rel="stylesheet" href="{{asset('main/css/core.css')}}" class="template-customizer-core-css"/>
    <link rel="stylesheet" href="{{asset('main/css/theme-default.css')}}" class="template-customizer-theme-css"/>

    <style>
        .form-fieldset {
            padding: 1rem;
            margin-bottom: 1rem;
            background: var(--bs-body-bg);
            border: var(--bs-border-width) var(--bs-border-style) var(--bs-border-color);
            border-radius: 0.625rem;
            /*box-shadow: 0 .25rem .875rem 0 rgba(16, 17, 33, .26);*/
        }

        .modal-blur {
            -webkit-backdrop-filter: blur(4px);
            backdrop-filter: blur(4px);
        }

        .transparent-swal2 .swal2-popup {
            background-color: transparent !important; /* Make dialog background transparent */
            box-shadow: none !important; /* Remove box-shadow */
        }

        .swal2-container.transparent-swal2 {
            background-color: rgba(0, 0, 0, 0.6); /* Adjust backdrop color and transparency */
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }

        .table_dt_no {
            width: 25px !important;
            max-width: 25px !important;
            min-width: 25px !important;
        }
    </style>
    <!-- Helpers -->
    <script src="{{asset('main/js/helpers.js')}}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{asset('main/js/template-customizer.js')}}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('js/config.js')}}"></script>

</head>

<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->
        @if(Auth::user()->hasRole('admin'))
            @include('layouts.adminMenu_new')
        @elseif(Auth::user()->hasRole('keu'))
            @include('layouts.adminMenu_new')
        @elseif(Auth::user()->hasRole('siswa'))

        @endif
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->

            <nav
                class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                id="layout-navbar">
                <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                        <i class="ri-menu-fill ri-22px"></i>
                    </a>
                </div>

                <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                    <div class="navbar-nav align-items-center d-xs-none">
                        <span class="d-none d-md-inline-block">
                            <span>{{config('app.name')}} - </span>
                            <span>{{ Carbon::now()->locale('id_ID')->translatedFormat('l, d F Y') }} - </span>
                            <span id="clock"></span>
                        </span>
                    </div>

                    <ul class="navbar-nav flex-row align-items-center ms-auto">

                        <!-- Style Switcher -->
                        <li class="nav-item dropdown-style-switcher dropdown me-1 me-xl-0">
                            <a class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
                               href="javascript:void(0);" data-bs-toggle="dropdown">
                                <i class='ri-22px'></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                                        <span class="align-middle"><i class='ri-sun-line ri-22px me-3'></i>Terang</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                                        <span class="align-middle"><i
                                                class="ri-moon-clear-line ri-22px me-3"></i>Gelap</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                                        <span class="align-middle"><i
                                                class="ri-computer-line ri-22px me-3"></i>Sistem</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- / Style Switcher-->

                        <!-- User -->
                        <li class="nav-item navbar-dropdown dropdown-user dropdown">
                            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                               data-bs-toggle="dropdown">
                                <div class="avatar avatar-online">
                                    <img src="{{asset('icon1.jpeg')}}" alt class="rounded-circle">
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-2">
                                                <div class="avatar avatar-online">
                                                    <img src="{{asset('icon1.jpeg')}}" alt class="rounded-circle">
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <span class="fw-medium d-block small">{{config('app.name')}}</span>
                                                <small class="text-muted"> {{Auth::user()->name}} </small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <div class="dropdown-divider"></div>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="ri-user-3-line ri-22px me-3"></i><span
                                            class="align-middle">Profil</span>
                                    </a>
                                </li>
                                <li>
                                    <div class="d-grid px-4 pt-2 pb-1">
                                        <a class="btn btn-sm btn-danger d-flex" href="{{route('logout')}}">
                                            <small class="align-middle">Logout</small>
                                            <i class="ri-logout-box-r-line ms-2 ri-16px"></i>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>                        <!--/ User -->
                    </ul>
                </div>
            </nav>

            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->
                <div class="flex-grow-1 container-p-y container-fluid">
                    @yield('content')
                </div>
                <!-- / Content -->

                <!-- Footer -->
                <footer class="content-footer footer bg-footer-theme">
                    <div class="container-xxl">
                        <div
                            class="footer-container d-flex align-items-center justify-content-between py-3 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                ©
                                <script>
                                    document.write(new Date().getFullYear());
                                </script>
                                , made with <span class="text-danger"><i class="tf-icons ri ri-heart-3-fill"></i></span>
                                by
                                <a href="#" target="_blank"
                                   class="footer-link fw-medium">PT. Inovasi Cipta Teknologi</a>
                            </div>
                            <div class="d-none d-lg-inline-block">
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- / Footer -->

                <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
</div>
<!-- / Layout wrapper -->

<!-- Core JS -->
<!-- build:js assets/js/core.js -->
<script src="{{asset('main/libs/jquery/jquery.js')}}"></script>
<script src="{{asset('main/js/bootstrap.js')}}"></script>
<script src="{{asset('main/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
<script src="{{asset('main/js/menu.js')}}"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{asset('main/libs/sweetalert2/sweetalert2.js')}}"></script>
<!-- Main JS -->
<script src="{{asset('js/main.js')}}"></script>

<script src="{{asset('js/alerts.js')}}"></script>

<!-- Page JS -->
@yield('script')

@if(session()->has('alert'))
    <script>
        {!! session('alert') !!}
    </script>
@endif

@if (session('error'))
    <script>
        console.log('error');
        errorAlert('{{ session('error') }}');
    </script>
@endif
<script>
    function updateClock() {
        let now = new Date();
        let hours = now.getHours();
        let minutes = now.getMinutes();
        let seconds = now.getSeconds();

        document.getElementById('clock').innerHTML = hours.toString().padStart(2, '0') + ':' + minutes.toString().padStart(2, '0') + ':' + seconds.toString().padStart(2, '0');
    }

    updateClock();
    setInterval(updateClock, 1000);
</script>
</body>
</html>
