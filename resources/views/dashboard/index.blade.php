@extends('layout.index')
@section('title', 'Dashboard')

@section('content')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-2">
        <div class="mb-3">
            <h1 class="mb-1">Welcome, {{ Auth::user()->name }}</h1>
            <p class="fw-medium">You have <span class="text-primary fw-bold">{{ number_format($transactionCount) }}</span> Orders, Today</p>
        </div>
        <div class="input-icon-start position-relative mb-3">
                <span class="input-icon-addon fs-16 text-gray-9">
                    <i class="ti ti-calendar"></i>
                </span>
            <input type="text" class="form-control date-range bookingrange" placeholder="Search Product">
        </div>
    </div>

    <div class="alert bg-orange-transparent alert-dismissible fade show mb-4">
        <div>
            <span><i class="ti ti-info-circle fs-14 text-orange me-2"></i>Your Product </span> <span class="text-orange fw-semibold"> Apple Iphone 15 is running Low, </span> already below 5 Pcs., <a href="javascript:void(0);" class="link-orange text-decoration-underline fw-semibold" data-bs-toggle="modal" data-bs-target="#add-stock">Add Stock</a>
        </div>
        <button type="button" class="btn-close text-gray-9 fs-14" data-bs-dismiss="alert" aria-label="Close"><i class="ti ti-x"></i></button>
    </div>

    <div class="row">
        <div class="col-xl-3 col-sm-6 col-12 d-flex">
            <div class="card bg-primary sale-widget flex-fill">
                <div class="card-body d-flex align-items-center">
                        <span class="sale-icon bg-white text-primary">
                            <i class="ti ti-file-text fs-24"></i>
                        </span>
                    <div class="ms-2">
                        <p class="text-white mb-1">Total Transaction</p>
                        <div class="d-inline-flex align-items-center flex-wrap gap-2">
                            <h4 class="text-white">Rp {{ number_format($totalCost) }}</h4>
                            <span class="badge badge-soft-primary"><i class="ti ti-arrow-up me-1"></i>+22%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 col-12 d-flex">
            <div class="card bg-secondary sale-widget flex-fill">
                <div class="card-body d-flex align-items-center">
                        <span class="sale-icon bg-white text-secondary">
                            <i class="ti ti-repeat fs-24"></i>
                        </span>
                    <div class="ms-2">
                        <p class="text-white mb-1">Transaction Dine In</p>
                        <div class="d-inline-flex align-items-center flex-wrap gap-2">
                            <h4 class="text-white">Rp {{ number_format($transactionDineIn) }}</h4>
                            <span class="badge badge-soft-danger"><i class="ti ti-arrow-down me-1"></i>-22%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 col-12 d-flex">
            <div class="card bg-teal sale-widget flex-fill">
                <div class="card-body d-flex align-items-center">
                        <span class="sale-icon bg-white text-teal">
                            <i class="ti ti-gift fs-24"></i>
                        </span>
                    <div class="ms-2">
                        <p class="text-white mb-1">Transaction Take Away</p>
                        <div class="d-inline-flex align-items-center flex-wrap gap-2">
                            <h4 class="text-white">Rp {{ number_format($transactionTakeAway) }}</h4>
                            <span class="badge badge-soft-success"><i class="ti ti-arrow-up me-1"></i>+22%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 col-12 d-flex">
            <div class="card bg-info sale-widget flex-fill">
                <div class="card-body d-flex align-items-center">
                        <span class="sale-icon bg-white text-info">
                            <i class="ti ti-brand-pocket fs-24"></i>
                        </span>
                    <div class="ms-2">
                        <p class="text-white mb-1">Transaction Online</p>
                        <div class="d-inline-flex align-items-center flex-wrap gap-2">
                            <h4 class="text-white">Rp {{ number_format($transactionDelivery) }}</h4>
                            <span class="badge badge-soft-success"><i class="ti ti-arrow-up me-1"></i>+22%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-xl-3 col-sm-6 col-12 d-flex">
            <div class="card revenue-widget flex-fill">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                        <div>
                            <h4 class="mb-1">Rp 0</h4>
                            <p>Menu Coffee</p>
                        </div>
                        <span class="revenue-icon bg-cyan-transparent text-cyan">
                            <i class="fa-solid fa-layer-group fs-16"></i>
                        </span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <p class="mb-0"><span class="fs-13 fw-bold text-success">+35%</span> vs Last Month</p>
                        <a href="#" class="text-decoration-underline fs-13 fw-medium">View All</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 col-12 d-flex">
            <div class="card revenue-widget flex-fill">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                        <div>
                            <h4 class="mb-1">Rp 0</h4>
                            <p>Menu Non Coffee</p>
                        </div>
                        <span class="revenue-icon bg-teal-transparent text-teal">
                            <i class="ti ti-chart-pie fs-16"></i>
                        </span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <p class="mb-0"><span class="fs-13 fw-bold text-success">+35%</span> vs Last Month</p>
                        <a href="#" class="text-decoration-underline fs-13 fw-medium">View All</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 col-12 d-flex">
            <div class="card revenue-widget flex-fill">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                        <div>
                            <h4 class="mb-1">Rp 0</h4>
                            <p>Menu Food</p>
                        </div>
                        <span class="revenue-icon bg-orange-transparent text-orange">
                            <i class="ti ti-lifebuoy fs-16"></i>
                        </span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <p class="mb-0"><span class="fs-13 fw-bold text-success">+41%</span> vs Last Month</p>
                        <a href="expense-list.html" class="text-decoration-underline fs-13 fw-medium">View All</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 col-12 d-flex">
            <div class="card revenue-widget flex-fill">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                        <div>
                            <h4 class="mb-1">Rp 0</h4>
                            <p>Menu Snacks / Light Bites</p>
                        </div>
                        <span class="revenue-icon bg-indigo-transparent text-indigo">
                            <i class="ti ti-hash fs-16"></i>
                        </span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <p class="mb-0"><span class="fs-13 fw-bold text-danger">-20%</span> vs Last Month</p>
                        <a href="#" class="text-decoration-underline fs-13 fw-medium">View All</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-xxl-8 col-xl-7 col-sm-12 col-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="d-inline-flex align-items-center">
                        <span class="title-icon bg-soft-primary fs-16 me-2"><i class="ti ti-shopping-cart"></i></span>
                        <h5 class="card-title mb-0">Transaction</h5>
                    </div>
                    <ul class="nav btn-group custom-btn-group">
                        <a class="btn btn-outline-light" href="javascript:void(0);">1D</a>
                        <a class="btn btn-outline-light" href="javascript:void(0);">1W</a>
                        <a class="btn btn-outline-light" href="javascript:void(0);">1M</a>
                        <a class="btn btn-outline-light" href="javascript:void(0);">3M</a>
                        <a class="btn btn-outline-light" href="javascript:void(0);">6M</a>
                        <a class="btn btn-outline-light active" href="javascript:void(0);">1Y</a>
                    </ul>
                </div>
                <div class="card-body pb-0">
                    <div>
                        <div class="d-flex align-items-center gap-2">
                            <div class="border p-2 br-8">
                                <p class="d-inline-flex align-items-center mb-1"><i class="ti ti-circle-filled fs-8 text-primary-300 me-1"></i>Total Purchase</p>
                                <h4>3K</h4>
                            </div>
                            <div class="border p-2 br-8">
                                <p class="d-inline-flex align-items-center mb-1"><i class="ti ti-circle-filled fs-8 text-primary me-1"></i>Total Sales</p>
                                <h4>1K</h4>
                            </div>
                        </div>
                        <div id="sales-daychart"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Selling Products -->
        <div class="col-xxl-4 col-xl-5 d-flex">
            <div class="card flex-fill">
                <div class="card-header">
                    <div class="d-inline-flex align-items-center">
                        <span class="title-icon bg-soft-info fs-16 me-2"><i class="ti ti-info-circle"></i></span>
                        <h5 class="card-title mb-0">Payment Method Distribution</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="info-item border bg-light p-3 text-center">
                                <div class="mb-2 text-info fs-24">
                                    <i class="ti ti-user-check"></i>
                                </div>
                                <p class="mb-1">Cash</p>
                                <h5>6987</h5>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-item border bg-light p-3 text-center">
                                <div class="mb-2 text-orange fs-24">
                                    <i class="ti ti-users"></i>
                                </div>
                                <p class="mb-1">QRIS</p>
                                <h5>4896</h5>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-item border bg-light p-3 text-center">
                                <div class="mb-2 text-teal fs-24">
                                    <i class="ti ti-shopping-cart"></i>
                                </div>
                                <p class="mb-1">Debit</p>
                                <h5>487</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer pb-sm-0">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <h5>Customers Overview</h5>
                        <div class="dropdown dropdown-wraper">
                            <a href="javascript:void(0);" class="dropdown-toggle btn btn-sm btn-white"  data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-calendar me-1"></i>Today
                            </a>
                            <ul class="dropdown-menu p-3">
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item">Today</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item">Weekly</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item">Monthly</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-sm-5">
                            <div id="customer-chart"></div>
                        </div>
                        <div class="col-sm-7">
                            <div class="row gx-0">
                                <div class="col-sm-6">
                                    <div class="text-center border-end">
                                        <h2 class="mb-1">5.5K</h2>
                                        <p class="text-orange mb-2">First Time</p>
                                        <span class="badge badge-success badge-xs d-inline-flex align-items-center"><i class="ti ti-arrow-up-left me-1"></i>25%</span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="text-center">
                                        <h2 class="mb-1">3.5K</h2>
                                        <p class="text-teal mb-2">Return</p>
                                        <span class="badge badge-success badge-xs d-inline-flex align-items-center"><i class="ti ti-arrow-up-left me-1"></i>21%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <!-- Top Selling Products -->
        <div class="col-xxl-4 col-md-6 d-flex">
            <div class="card flex-fill">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div class="d-inline-flex align-items-center">
                        <span class="title-icon bg-soft-pink fs-16 me-2"><i class="ti ti-box"></i></span>
                        <h5 class="card-title mb-0">Top Selling Products</h5>
                    </div>
                </div>
                <div class="card-body sell-product">
                    @foreach($topSelling as $item)
                        <div class="d-flex align-items-center justify-content-between border-bottom">
                            <div class="d-flex align-items-center">
                                <a href="javascript:void(0);" class="avatar avatar-lg">
                                    <img src="{{ asset('images/menu/'.$item->menu->image) }}" alt="img">
                                </a>
                                <div class="ms-2">
                                    <h6 class="fw-bold mb-1"><a href="javascript:void(0);">{{ $item->menu->name }}</a></h6>
                                    <div class="d-flex align-items-center item-list">
                                        <p>Rp {{ number_format($item->menu->price) }}</p>
                                        <p>{{ number_format($item->sold_quantity) }}+ Sales</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- /Top Selling Products -->

        <!-- Low Stock Products -->
        <div class="col-xxl-4 col-md-6 d-flex">
            <div class="card flex-fill">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div class="d-inline-flex align-items-center">
                        <span class="title-icon bg-soft-danger fs-16 me-2"><i class="ti ti-alert-triangle"></i></span>
                        <h5 class="card-title mb-0">Low Stock Products</h5>
                    </div>
                    <a href="low-stocks.html" class="fs-13 fw-medium text-decoration-underline">View All</a>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="d-flex align-items-center">
                            <a href="javascript:void(0);" class="avatar avatar-lg">
                                <img src="assets/img/products/product-06.jpg" alt="img">
                            </a>
                            <div class="ms-2">
                                <h6 class="fw-bold mb-1"><a href="javascript:void(0);">Dell XPS 13</a></h6>
                                <p class="fs-13">ID : #665814</p>
                            </div>
                        </div>
                        <div class="text-end">
                            <p class="fs-13 mb-1">Instock</p>
                            <h6 class="text-orange fw-medium">08</h6>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="d-flex align-items-center">
                            <a href="javascript:void(0);" class="avatar avatar-lg">
                                <img src="assets/img/products/product-07.jpg" alt="img">
                            </a>
                            <div class="ms-2">
                                <h6 class="fw-bold mb-1"><a href="javascript:void(0);">Vacuum Cleaner Robot</a></h6>
                                <p class="fs-13">ID : #940004</p>
                            </div>
                        </div>
                        <div class="text-end">
                            <p class="fs-13 mb-1">Instock</p>
                            <h6 class="text-orange fw-medium">14</h6>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="d-flex align-items-center">
                            <a href="javascript:void(0);" class="avatar avatar-lg">
                                <img src="assets/img/products/product-08.jpg" alt="img">
                            </a>
                            <div class="ms-2">
                                <h6 class="fw-bold mb-1"><a href="javascript:void(0);">KitchenAid Stand Mixer</a></h6>
                                <p class="fs-13">ID : #325569</p>
                            </div>
                        </div>
                        <div class="text-end">
                            <p class="fs-13 mb-1">Instock</p>
                            <h6 class="text-orange fw-medium">21</h6>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="d-flex align-items-center">
                            <a href="javascript:void(0);" class="avatar avatar-lg">
                                <img src="assets/img/products/product-09.jpg" alt="img">
                            </a>
                            <div class="ms-2">
                                <h6 class="fw-bold mb-1"><a href="javascript:void(0);">Levi's Trucker Jacket</a></h6>
                                <p class="fs-13">ID : #124588</p>
                            </div>
                        </div>
                        <div class="text-end">
                            <p class="fs-13 mb-1">Instock</p>
                            <h6 class="text-orange fw-medium">12</h6>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-0">
                        <div class="d-flex align-items-center">
                            <a href="javascript:void(0);" class="avatar avatar-lg">
                                <img src="assets/img/products/product-10.jpg" alt="img">
                            </a>
                            <div class="ms-2">
                                <h6 class="fw-bold mb-1"><a href="javascript:void(0);">Lay's Classic</a></h6>
                                <p class="fs-13">ID : #365586</p>
                            </div>
                        </div>
                        <div class="text-end">
                            <p class="fs-13 mb-1">Instock</p>
                            <h6 class="text-orange fw-medium">10</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Low Stock Products -->

        <!-- Recent Sales -->
        <div class="col-xxl-4 col-md-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div class="d-inline-flex align-items-center">
                        <span class="title-icon bg-soft-pink fs-16 me-2"><i class="ti ti-box"></i></span>
                        <h5 class="card-title mb-0">Recent Sales</h5>
                    </div>
                </div>
                <div class="card-body">
                    @foreach($lowMoving as $item)
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center">
                                <a href="javascript:void(0);" class="avatar avatar-lg">
                                    <img src="{{ asset('images/menu/'.$item->image) }}" alt="img">
                                </a>
                                <div class="ms-2">
                                    <h6 class="fw-bold mb-1"><a href="javascript:void(0);">{{ $item->name }}</a></h6>
                                    <div class="d-flex align-items-center item-list">
                                        <p>Rp {{ number_format($item->price) }}</p>
                                        <p>{{ number_format($item->sold_quantity) }}+ Sales</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- /Recent Sales -->

    </div>
@endsection