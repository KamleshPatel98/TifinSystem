<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ getSetting('app_name') }} | @yield('title')</title>

    <!-- Bootstrap 5 -->
    <link href="{{ asset('assets/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.jpg') }}" type="image/x-icon">

    <style>
        body {
            background: #f2f2f2;
        }

        .login-card {
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .brand-section {
            background: linear-gradient(135deg, #2b3591, #221c55);
            color: #fff;
            text-align: center;
            padding: 40px 20px;
        }

        .brand-section img {
            max-height: 380px;
            object-fit: contain;
        }

        .form-section {
            padding: 50px 40px;
        }

        .btn-orange {
            background: linear-gradient(135deg, #151c5c, #221c55);
            border: none;
            color: #fff;
            border-radius: 25px;
            padding: 10px 25px;
        }

        .btn-orange:hover {
            opacity: 0.9;
        }

        .form-control {
            border-radius: 25px;
            padding: 10px 15px;
        }

        /* Tablet */
        @media (max-width: 991px) {
            .form-section {
                padding: 35px 25px;
            }
        }

        /* Mobile */
        @media (max-width: 768px) {

            .brand-section {
                display: none;
                /* same as your original design */
            }

            .form-section {
                padding: 30px 20px;
            }

            .login-card {
                border-radius: 12px;
            }

            .container {
                padding-left: 15px;
                padding-right: 15px;
            }
        }
    </style>
</head>

<body>

    <x-alert />

    <div class="container min-vh-100 d-flex align-items-center justify-content-center py-4">
        <div class="row login-card bg-white w-100" style="max-width: 900px;">

            <!-- Branding Section (Same as your laptop view) -->
            <div class="col-md-6 brand-section d-none d-md-flex flex-column justify-content-center">
                <h5 class="mb-2">Welcome to</h5>
                <h3 class="fw-bold mb-4">{{ getSetting('app_name') }} Company</h3>
                <img src="{{ asset('assets/images/tifin.jpg') }}" alt="Tifin Image" class="img-fluid mx-auto">
            </div>

            <!-- Form Section -->
            <div class="col-12 col-md-6 form-section">
                @yield('content')
            </div>

        </div>
    </div>

    <script src="{{ asset('assets/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/sweet-alert2/sweet-alert2.min.js') }}"></script>

    <x-alert />
    @stack('scripts')

</body>

</html>