<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dreams POS is a powerful Bootstrap based Inventory Management Admin Template designed for businesses, offering seamless invoicing, project tracking, and estimates.">
    <meta name="keywords" content="inventory management, admin dashboard, bootstrap template, invoicing, estimates, business management, responsive admin, POS system">
    <meta name="author" content="Dreams Technologies">
    <meta name="robots" content="index, follow">
    <title>Login - Kedai Selvin</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/apple-touch-icon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/tabler-icons/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

</head>
<body class="account-page">

<div id="global-loader" >
    <div class="whirly-loader"> </div>
</div>

<!-- Main Wrapper -->
<div class="main-wrapper">
    <div class="account-content">
        <div class="login-wrapper bg-img">
            <div class="login-content authent-content">
                <form action="{{ route('login.action') }}" method="POST">
                    @csrf
                    <div class="login-userset">
                        <div class="d-flex justify-content-center">
                            <img src="{{ asset('assets/img/authentication/login-logo.png') }}" alt="img" width="350">
                        </div>
                        <div class="login-userheading">
                            <h3>Sign In</h3>
                            <h4 class="fs-16">Access POS Kedai Selvin using your username and password.</h4>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username <span class="text-danger"> *</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control border-end-0" name="username">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password <span class="text-danger"> *</span></label>
                            <div class="pass-group">
                                <input type="password" class="pass-input form-control" name="password">
                                <span class="ti toggle-password ti-eye-off text-gray-9"></span>
                            </div>
                        </div>
                        <div class="form-login">
                            <button type="submit" class="btn btn-primary w-100">Sign In</button>
                        </div>
                        <div class="my-4 d-flex justify-content-center align-items-center copyright-text">
                            <p>Copyright &copy; {{ date('Y') }} Coffee Shop - Kedai Selvin</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}" type="7b291c6551d2dd756edd64cb-text/javascript"></script>
<script src="{{ asset('assets/js/feather.min.js') }}" type="7b291c6551d2dd756edd64cb-text/javascript"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}" type="7b291c6551d2dd756edd64cb-text/javascript"></script>
<script src="{{ asset('assets/js/script.js') }}" type="7b291c6551d2dd756edd64cb-text/javascript"></script>
<script src="https://preadmin.dreamstechnologies.com/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js" data-cf-settings="7b291c6551d2dd756edd64cb-|49" defer></script><script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"97f797f8a9a61dad","serverTiming":{"name":{"cfExtPri":true,"cfEdge":true,"cfOrigin":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"version":"2025.8.0","token":"3ca157e612a14eccbb30cf6db6691c29"}' crossorigin="anonymous"></script>
</body>

</html>