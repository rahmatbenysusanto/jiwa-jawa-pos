<!DOCTYPE html>
<html lang="en" data-layout-mode="light_mode">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dreams POS is a powerful Bootstrap based Inventory Management Admin Template designed for businesses, offering seamless invoicing, project tracking, and estimates.">
    <meta name="keywords" content="inventory management, admin dashboard, bootstrap template, invoicing, estimates, business management, responsive admin, POS system">
    <meta name="author" content="Dreams Technologies">
    <meta name="robots" content="index, follow">
    <title>@yield('title') - Kedai Selvin</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/apple-touch-icon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/tabler-icons/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/owlcarousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/owlcarousel/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/%40simonwep/pickr/themes/nano.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <script src="{{ asset('assets/js/theme-script.js') }}"></script>

    @yield('css')

</head>

<body>

<div class="main-wrapper">
    <div class="header">
        <div class="main-header">
            <div class="header-left active">
                <a href="{{ route('dashboard') }}" class="logo logo-normal">
                    <img src="{{ asset('assets/img/logo.svg') }}" alt="Img">
                </a>
                <a href="{{ route('dashboard') }}" class="logo logo-white">
                    <img src="assets/img/logo-white.svg" alt="Img">
                </a>
                <a href="{{ route('dashboard') }}" class="logo-small">
                    <img src="assets/img/logo-small.png" alt="Img">
                </a>
            </div>
            <a id="mobile_btn" class="mobile_btn" href="#sidebar">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>

            <ul class="nav user-menu">

                <li class="nav-item nav-searchinputs">

                </li>

                <li class="nav-item nav-item-box">
                    <a href="javascript:void(0);" id="btnFullscreen">
                        <i class="ti ti-maximize"></i>
                    </a>
                </li>

                <li class="nav-item dropdown has-arrow main-drop profile-nav">
                    <a href="javascript:void(0);" class="nav-link userset" data-bs-toggle="dropdown">
                        <span class="user-info p-0">
                            <span class="user-letter">
                                <img src="{{ asset('assets/img/profiles/avator1.jpg') }}" alt="Img" class="img-fluid">
                            </span>
                        </span>
                    </a>
                    <div class="dropdown-menu menu-drop-user">
                        <div class="profileset d-flex align-items-center">
								<span class="user-img me-2">
									<img src="{{ asset('assets/img/profiles/avator1.jpg') }}" alt="Img">
								</span>
                            <div>
                                <h6 class="fw-medium">{{ Auth::user()->name }}</h6>
                                <p>Admin</p>
                            </div>
                        </div>
                        <hr class="my-2">
                        <a class="dropdown-item logout pb-0" href="{{ route('logout') }}"><i class="ti ti-logout me-2"></i>Logout</a>
                    </div>
                </li>
            </ul>

            <div class="dropdown mobile-user-menu">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <!-- Logo -->
        <div class="sidebar-logo active">
            <a href="{{ route('dashboard') }}" class="logo logo-normal">
                <img src="{{ asset('assets/img/logo.svg') }}" alt="Img">
            </a>
            <a href="{{ route('dashboard') }}" class="logo logo-white">
                <img src="assets/img/logo-white.svg" alt="Img">
            </a>
            <a href="{{ route('dashboard') }}" class="logo-small">
                <img src="assets/img/logo-small.png" alt="Img">
            </a>
            <a id="toggle_btn" href="javascript:void(0);">
                <i data-feather="chevrons-left" class="feather-16"></i>
            </a>
        </div>
        <!-- /Logo -->
        <div class="modern-profile p-3 pb-0">
            <div class="text-center rounded bg-light p-3 mb-4 user-profile">
                <div class="avatar avatar-lg online mb-3">
                    <img src="assets/img/customer/customer15.jpg" alt="Img" class="img-fluid rounded-circle">
                </div>
                <h6 class="fs-14 fw-bold mb-1">Adrian Herman</h6>
                <p class="fs-12 mb-0">System Admin</p>
            </div>
            <div class="sidebar-nav mb-3">
                <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded nav-justified bg-transparent" role="tablist">
                    <li class="nav-item"><a class="nav-link active border-0" href="#">Menu</a></li>
                    <li class="nav-item"><a class="nav-link border-0" href="chat.html">Chats</a></li>
                    <li class="nav-item"><a class="nav-link border-0" href="email.html">Inbox</a></li>
                </ul>
            </div>
        </div>
        <div class="sidebar-header p-3 pb-0 pt-2">
            <div class="text-center rounded bg-light p-2 mb-4 sidebar-profile d-flex align-items-center">
                <div class="avatar avatar-md onlin">
                    <img src="assets/img/customer/customer15.jpg" alt="Img" class="img-fluid rounded-circle">
                </div>
                <div class="text-start sidebar-profile-info ms-2">
                    <h6 class="fs-14 fw-bold mb-1">Adrian Herman</h6>
                    <p class="fs-12">System Admin</p>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between menu-item mb-3">
                <div>
                    <a href="{{ route('dashboard') }}" class="btn btn-sm btn-icon bg-light">
                        <i class="ti ti-layout-grid-remove"></i>
                    </a>
                </div>
                <div>
                    <a href="chat.html" class="btn btn-sm btn-icon bg-light">
                        <i class="ti ti-brand-hipchat"></i>
                    </a>
                </div>
                <div>
                    <a href="email.html" class="btn btn-sm btn-icon bg-light position-relative">
                        <i class="ti ti-message"></i>
                    </a>
                </div>
                <div class="notification-item">
                    <a href="activities.html" class="btn btn-sm btn-icon bg-light position-relative">
                        <i class="ti ti-bell"></i>
                        <span class="notification-status-dot"></span>
                    </a>
                </div>
                <div class="me-0">
                    <a href="general-settings.html" class="btn btn-sm btn-icon bg-light">
                        <i class="ti ti-settings"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="sidebar-inner slimscroll">
            <div id="sidebar-menu" class="sidebar-menu">
                <ul>
                    <li class="submenu-open">
                        <h6 class="submenu-hdr">Main</h6>
                        <ul>
                            <li class="submenu-open">
                                <ul>
                                    <li class="{{ $title == 'Dashboard' ? 'active' : '' }}">
                                        <a href="{{ route('dashboard') }}">
                                            <i class="ti ti-layout-grid fs-16 me-2"></i>
                                            <span>Dashboard</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="submenu-open mt-2">
                                <h6 class="submenu-hdr">Menu</h6>
                                <ul>
                                    <li class="{{ $title == 'Menu Category' ? 'active' : '' }}">
                                        <a href="{{ route('menu.category') }}">
                                            <i class="ti ti-list-details fs-16 me-2"></i>
                                            <span>Category</span>
                                        </a>
                                    </li>
                                    <li class="{{ in_array($title, ['Menu List', 'Create Menu']) ? 'active' : '' }}">
                                        <a href="{{ route('menu.list') }}">
                                            <i class="ti ti-book fs-16 me-2"></i>
                                            <span>List Menu</span>
                                        </a>
                                    </li>
                                    <li class="{{ $title == 'Menu Addon' ? 'active' : '' }}">
                                        <a href="{{ route('menu.addon') }}">
                                            <i class="ti ti-checklist fs-16 me-2"></i>
                                            <span>Add on</span>
                                        </a>
                                    </li>
                                    <li class="{{ $title == 'Discount' ? 'active' : '' }}">
                                        <a href="{{ route('discount') }}">
                                            <i class="ti ti-discount-check fs-16 me-2"></i>
                                            <span>Discount</span>
                                        </a>
                                    </li>
                                    <li class="{{ $title == 'Recipe' ? 'active' : '' }}">
                                        <a href="{{ route('menu.recipe') }}">
                                            <i class="ti ti-book-2 fs-16 me-2"></i>
                                            <span>Recipe</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="submenu-open mt-2">
                                <h6 class="submenu-hdr">Transaction</h6>
                                <ul>
                                    <li class="{{ $title == 'POS' ? 'active' : '' }}">
                                        <a href="{{ route('pos.index') }}">
                                            <i class="ti ti-device-laptop fs-16 me-2"></i>
                                            <span>Point Of Sale (POS)</span>
                                        </a>
                                    </li>
                                    <li class="{{ $title == 'Customer Display' ? 'active' : '' }}">
                                        <a href="{{ route('customer.display') }}">
                                            <i class="ti ti-shopping-bag fs-16 me-2"></i>
                                            <span>Customer Display</span>
                                        </a>
                                    </li>
                                    <li class="{{ $title == 'Transaction' ? 'active' : '' }}">
                                        <a href="{{ route('transaction.index') }}">
                                            <i class="ti ti-device-analytics fs-16 me-2"></i>
                                            <span>List Transaction</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="submenu-open mt-2">
                                <h6 class="submenu-hdr">Inventory</h6>
                                <ul>
                                    <li class="{{ $title == 'Material Category' ? 'active' : '' }}">
                                        <a href="{{ route('inventory.category') }}">
                                            <i class="ti ti-carousel-vertical fs-16 me-2"></i>
                                            <span>Category</span>
                                        </a>
                                    </li>
                                    <li class="{{ $title == 'Material' ? 'active' : '' }}">
                                        <a href="{{ route('inventory.material') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box">
                                                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                                <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                            </svg>
                                            <span>Material</span>
                                        </a>
                                    </li>
                                    <li class="{{ $title == 'Purchase Order' ? 'active' : '' }}">
                                        <a href="{{ route('inventory.purchase.order') }}">
                                            <i class="ti ti-file-unknown fs-16 me-2"></i>
                                            <span>Purchase Order</span>
                                        </a>
                                    </li>
                                    <li class="{{ $title == 'Manage Stock' ? 'active' : '' }}">
                                        <a href="{{ route('inventory.manage.stock') }}">
                                            <i class="ti ti-stack-3 fs-16 me-2"></i>
                                            <span>Manage Stock</span>
                                        </a>
                                    </li>
                                    <li class="{{ $title == 'Stock Consumption' ? 'active' : '' }}">
                                        <a href="{{ route('inventory.stock.consumption') }}">
                                            <i class="ti ti-stairs-up fs-16 me-2"></i>
                                            <span>Stock Consumption</span>
                                        </a>
                                    </li>
                                    <li class="{{ $title == 'Transfer Stock' ? 'active' : '' }}">
                                        <a href="{{ route('inventory.transfer.stock') }}">
                                            <i class="ti ti-stack-pop fs-16 me-2"></i>
                                            <span>Transfer Stock</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="submenu-open mt-2">
                                <h6 class="submenu-hdr">Report</h6>
                                <ul>
                                    <li class="{{ $title == 'Sales Report' ? 'active' : '' }}">
                                        <a href="{{ route('report.sales') }}">
                                            <i class="ti ti-report-money fs-16 me-2"></i>
                                            <span>Sales Report</span>
                                        </a>
                                    </li>

                                    <li class="{{ $title == 'Top Selling Report' ? 'active' : '' }}">
                                        <a href="{{ route('report.top.selling') }}">
                                            <i class="ti ti-chart-bar fs-16 me-2"></i>
                                            <span>Top Selling Menu</span>
                                        </a>
                                    </li>

                                    <li class="{{ $title == 'Low Moving Report' ? 'active' : '' }}">
                                        <a href="{{ route('report.low.moving') }}">
                                            <i class="ti ti-trending-down fs-16 me-2"></i>
                                            <span>Low Moving Menu</span>
                                        </a>
                                    </li>

                                    <li class="{{ $title == 'Stock Report' ? 'active' : '' }}">
                                        <a href="{{ route('report.stock') }}">
                                            <i class="ti ti-box fs-16 me-2"></i>
                                            <span>Stock</span>
                                        </a>
                                    </li>

                                    <li class="{{ $title == 'Discount Report' ? 'active' : '' }}">
                                        <a href="{{ route('report.discount') }}">
                                            <i class="ti ti-discount-2 fs-16 me-2"></i>
                                            <span>Discount</span>
                                        </a>
                                    </li>

                                    <li class="{{ $title == '' ? 'active' : '' }}">
                                        <a href="#">
                                            <i class="ti ti-package fs-16 me-2"></i>
                                            <span>Products</span>
                                        </a>
                                    </li>

                                    <li class="{{ $title == 'Store Performance Report' ? 'active' : '' }}">
                                        <a href="{{ route('report.store.performance') }}">
                                            <i class="ti ti-graph fs-16 me-2"></i>
                                            <span>Store Performance</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="submenu-open mt-2">
                                <h6 class="submenu-hdr">POS Setting</h6>
                                <ul>
                                    <li class="{{ $title == 'Outlet' ? 'active' : '' }}">
                                        <a href="{{ route('outlet.index') }}">
                                            <i class="ti ti-map-pin fs-16 me-2"></i>
                                            <span>Outlet</span>
                                        </a>
                                    </li>
                                    <li class="{{ $title == 'User' ? 'active' : '' }}">
                                        <a href="{{ route('user.index') }}">
                                            <i class="ti ti-user fs-16 me-2 fs-16 me-2"></i>
                                            <span>User</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="page-wrapper">
        <div class="content">

            @yield('content')

        </div>
        <div class="copyright-footer d-flex align-items-center justify-content-between border-top bg-white gap-3 flex-wrap">
            <p class="fs-13 text-gray-9 mb-0">{{ date('Y') }} &copy; Kedai Selvin. All Right Reserved</p>
            <p>Designed & Developed By <a href="javascript:void(0);" class="link-primary">Dreams</a></p>
        </div>
    </div>

</div>

<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/js/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/plugins/apexchart/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/plugins/apexchart/chart-data.js') }}"></script>
<script src="{{ asset('assets/plugins/chartjs/chart.min.js') }}"></script>
<script src="{{ asset('assets/plugins/chartjs/chart-data.js') }}"></script>
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/plugins/owlcarousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
<script src="{{ asset('assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>
<script src="{{ asset('assets/plugins/%40simonwep/pickr/pickr.es5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/js/theme-colorpicker.js') }}"></script>
<script src="{{ asset('assets/js/calculator.js') }}"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
<script src="{{ asset('assets/js/theme-script.js') }}"></script>

@yield('js')

@if($message = Session::get('success'))
    <script>
        Swal.fire({
            title: 'Success!',
            title: '{{ $message }}',
            icon: 'success'
        });
    </script>
@endif

@if($message = Session::get('error'))
    <script>
        Swal.fire({
            title: 'Error!',
            title: '{{ $message }}',
            icon: 'error'
        });
    </script>
@endif

</body>

</html>