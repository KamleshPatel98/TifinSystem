<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ getSetting('app_name') }} | @yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.jpg') }}" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap 5 -->
    <link href="{{ asset('assets/bootstrap/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <script src="{{ asset('assets/sweet-alert2/sweet-alert2.min.js') }}"></script>
    <script src="{{ asset('assets/jquery/jquery.min.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('assets/jquery-ui/jquery-ui.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/select2/select2.min.css') }}">
    <style>
        .select2-container .select2-selection--single {
            height: 36px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 36px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }

        /* input {
        border: 0.1px solid #444444 !important;
    } */
    </style>

    @stack('styles')

    <script src="{{ asset('assets/select2/select2.min.js') }}"></script>
</head>

<body>
    <!-- Sidebar -->
    <div class="app-wrapper">
        <aside class="sidebar" id="sidebar">

            <!-- Mobile close button -->
            <div class="sidebar-header">
                <button class="btn fs-4 d-md-none" style="color: #ff7a18;" id="sidebarClose">
                    <i class="fa-solid fa-xmark"></i>
                </button>

                <h4 class="fw-bold" style="color: #ff7a18;">
                    <img src="{{ asset('assets/images/logo.jpg') }}" alt="Logo" width="40" height="40" class="me-2">
                    {{ getSetting('app_name') }}
                </h4>

                <button class="btn btn-outline-secondary me-2" id="sidebarWindowHide">
                    <i class="fa-solid fa-bars-staggered"></i>
                </button>
            </div>

            <ul class="nav flex-column mt-3" id="sidebarAccordion">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('auth.dashboard') ? 'active' : '' }}" href="{{ route('auth.dashboard') }}">
                        <i class="fa-solid fa-house-chimney"></i>
                        Dashboard
                    </a>
                </li>

                @php
                $geograhyRoutes = [
                'states.*',
                'cities.*',
                'areas.*',
                ];

                $isGeographyActive = request()->routeIs($geograhyRoutes);
                @endphp
                <!-- Geography -->
                <li class="nav-item">
                    <a class="nav-link {{ $isGeographyActive ? '' : 'collapsed' }}"
                        data-bs-toggle="collapse"
                        href="#geoMenu"
                        aria-expanded="false">
                        <i class="fa-solid fa-map-location-dot"></i>
                        Geography
                        <i class="fa-solid fa-angle-down ms-auto"></i>
                    </a>
                    <ul class="collapse nav flex-column submenu {{ $isGeographyActive ? 'show' : '' }}"
                        id="geoMenu"
                        data-bs-parent="#sidebarAccordion">

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('states.*') ? 'active' : '' }}" href="{{ route('states.index') }}">
                                <i class="fa-solid fa-map-pin"></i> State
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('cities.*') ? 'active' : '' }}" href="{{ route('cities.index') }}">
                                <i class="fa-solid fa-building-columns"></i> City
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('areas.*') ? 'active' : '' }}" href="{{ route('areas.index') }}">
                                <i class="fa-solid fa-street-view"></i> Area
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </aside>

        <!-- Main content -->
        <main class="content">
            <nav class="navbar navbar-light bg-white shadow-sm mb-4">
                <div class="container-fluid d-flex justify-content-between align-items-center">

                    <!-- Left: Toggle + Page title -->
                    <div class="d-flex align-items-center">
                        <button class="btn btn-outline-secondary me-2" id="sidebarWindowShow" style="display: none;">
                            ☰
                        </button>
                        <button class="btn btn-outline-secondary d-md-none me-2" id="sidebarToggle">
                            ☰
                        </button>
                        <span class="navbar-brand mb-0" id="navCompanyName">
                            <img src="{{ asset('assets/images/logo.jpg') }}" alt="Logo" class="company-name" width="40" height="40" class="">
                            {{ getSetting('app_name') }}
                        </span> <br>
                    </div>

                    <!-- Right: Company name -->
                    <div class="company-name">
                        <!-- Right: Admin Icon Dropdown -->
                        <div class="dropdown company-dropdown">
                            <button
                                class="btn company-btn dropdown-toggle"
                                type="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="fa-solid fa-user"></i>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="fa-regular fa-user"></i> Profile
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="fa-solid fa-key"></i> Change Password
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="">
                                        <i class="fa-solid fa-globe"></i> Web Data
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger" href="{{ route('auth.logout') }}">
                                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </nav>

            <div class="content-body">
                @yield('content')
            </div>
        </main>
    </div>

    <x-alert />
    <script>
        // csrf token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // success toast
        function showSuccess(msg) {
            Swal.fire({
                icon: 'success',
                title: 'Done!',
                text: msg,
                timer: 2000,
                showConfirmButton: false
            });
        }

        // error alert
        function showError(msg) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: msg
            });
        }
    </script>
    <script src="{{ asset('assets/bootstrap/bootstrap.min.js') }}"></script>

    <script>
        const sidebar = document.getElementById("sidebar");
        const toggleBtn = document.getElementById("sidebarToggle");
        const closeBtn = document.getElementById("sidebarClose");

        function isMobile() {
            return window.innerWidth <= 768;
        }

        // Mobile: open
        toggleBtn.addEventListener("click", () => {
            if (isMobile()) {
                sidebar.classList.add("show");
            }
        });

        // Mobile: close
        closeBtn.addEventListener("click", () => {
            if (isMobile()) {
                sidebar.classList.remove("show");
            }
        });

        // Safety: resize desktop <-> mobile
        window.addEventListener("resize", () => {
            if (!isMobile()) {
                sidebar.classList.remove("show");
            }
        });

        const hideBtn = $('#sidebarWindowHide');
        const showBtn = $('#sidebarWindowShow');

        hideBtn.on("click", function() {
            $('#sidebar').addClass("hide");
            $('#content').addClass("full");
            $('#navCompanyName').show();

            hideBtn.hide();
            showBtn.show();
        });

        showBtn.on("click", function() {
            $('#sidebar').removeClass("hide");
            $('#content').removeClass("full");
            $('#navCompanyName').hide();

            hideBtn.show();
            showBtn.hide();
        });
    </script>

    <script>
        // select2
        $(document).ready(function() {
            $('.select-dropdown').select2({
                width: '100%',
                placeholder: 'Select an option',
                allowClear: true
            });
            $('.select-dropdown.multiple').select2({
                width: '100%',
                multiple: true,
                placeholder: 'Select options',
                allowClear: true
            });
            $('#addModal').on('shown.bs.modal', function() {
                $('.modal-select-dropdown').select2({
                    width: '100%',
                    placeholder: 'Select an option',
                    allowClear: true,
                    dropdownParent: $('#addModal')
                });
            });
        });
    </script>

    <script src="{{ asset('assets/jquery-ui/jquery-ui.min.js') }}"></script>
    <script>
        // Datepicker
        $(document).ready(function() {
            var currentYear = new Date().getFullYear();
            $('.datepicker').datepicker({
                dateFormat: "dd-mm-yy",
                changeMonth: true,
                changeYear: true,
                yearRange: "1950:2035",
            });
        });
    </script>
    @stack('scripts')
</body>

</html>