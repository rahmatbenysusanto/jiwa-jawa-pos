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

</head>

<body>

<div class="main-wrapper">
    <div class="container-fluid py-4">
        <div class="row g-3 align-items-stretch" style="min-height: 100vh;">
            <!-- LEFT: Cart -->
            <div class="col-12 col-lg-6 d-flex">
                <div class="card flex-fill shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Pesanan Anda</h5>
                        <span class="badge bg-primary-subtle text-primary" id="invoiceNumber"></span>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5 class="d-flex align-items-center mb-0">Order Details</h5>
                                <div class="badge bg-light text-gray-9 fs-12 fw-semibold py-2 border rounded">Items : <span class="text-teal" id="jumlahCart">0</span></div>
                            </div>
                            <div class="product-wrap mb-3" style="min-height: 150px!important;">
                                <div class="empty-cart" id="cartNull">
                                    <div class="mb-1">
                                        <img src="{{ asset('assets/img/icons/empty-cart.svg') }}" alt="img">
                                    </div>
                                    <p class="fw-bold">No Products Selected</p>
                                </div>
                                <div id="cartValue">
                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <thead>
                                            <tr>
                                                <th class="bg-transparent fw-bold">Product</th>
                                                <th class="bg-transparent fw-bold text-center">QTY</th>
                                                <th class="bg-transparent fw-bold">Price</th>
                                            </tr>
                                            </thead>
                                            <tbody id="listProductCart">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border-top">
                            <div class="order-total">
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-bold">Sub Total</td>
                                            <td class="text-end" id="subTotal">Rp 0</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Discount</td>
                                            <td class="text-danger text-end" id="discount">Rp 0</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Tax (11%)</td>
                                            <td class="text-end" id="totalTax">Rp 0</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Grand Total</td>
                                            <td class="text-end fw-bold" id="grandTotal">Rp 0</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex gap-2">
                            <a href="{{ route('logout') }}" class="btn btn-sm btn-danger">
                                <i data-feather="log-out" class="me-1"></i>
                                Exit
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="btnFullscreen">
                                <i data-feather="maximize"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6 d-flex">
                <div class="card flex-fill shadow-sm">
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <div class="text-center" id="defaultPayment">
                            <img src="{{ asset('assets/img/authentication/login-logo.png') }}" alt="Cafe Logo" class="img-fluid mb-3">
                            <h2 class="mb-0">Selamat Datang</h2>
                            <p class="text-muted">Silakan cek pesanan Anda di sisi kiri layar</p>
                        </div>
                        <div id="paymentQRIS" style="display: none">
                            <div class="modal-body text-center">
                                <h2 class="fw-bold mb-2" id="storeName">Kedai Selvin</h2>
                                <hr>

                                <canvas id="qrisCanvas" width="350" height="350" style="margin:auto; display:block;"></canvas>

                                <p class="mt-3 mb-1 fw-semibold">Total Bayar:</p>
                                <h4 class="fw-bold text-dark mb-3" id="qrisAmount">Rp 0</h4>

                                <p class="text-muted mb-1" style="font-size:16px;">Scan menggunakan aplikasi e-wallet Anda</p>
                                <img src="{{ asset('assets/img/qris.webp') }}" alt="QRIS" width="100" class="mt-2">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        const btn = document.getElementById('btnFullscreen');
        const target = document.documentElement; // atau document.querySelector('.main-wrapper')

        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                if (target.requestFullscreen) target.requestFullscreen();
            } else {
                if (document.exitFullscreen) document.exitFullscreen();
            }
        }

        btn.addEventListener('click', toggleFullscreen);
    })();
</script>

<style>
    .card-header { background: #fff; }
    .badge.bg-primary-subtle {
        background-color: #efe9fb !important;
        color: #7F56D8 !important;
        border: 1px solid #e1d6fb;
    }
</style>

<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/qrious/dist/qrious.min.js"></script>
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script>
    document.getElementById('invoiceNumber').innerText = localStorage.getItem('invoice');
    document.getElementById('cartValue').style.display = 'none';

    Pusher.logToConsole = true;
    const pusher = new Pusher('e4ffb7304b4636918b68', {
        cluster: 'ap1'
    });
    const channel = pusher.subscribe('selvin-pos');
    channel.bind('transaction-data', function(data) {
        if (data.username === '{{ Auth::user()->username }}') {
            localStorage.setItem('invoice', JSON.stringify(data.invoice));
            switch (data.type) {
                case 'transaction-data':
                    cartData(data.invoice);
                    break;
                case 'payment':
                    paymentProcess(data.data);
                    break;
                case 'reset':
                    reset();
                    break;
            }

            document.getElementById('invoiceNumber').innerText = data.invoice;
        }
    });

    function rupiah(angka) {
        return new Intl.NumberFormat('id-ID').format(angka);
    }

    function cartData(invoiceNumber) {
        $.ajax({
            url: '{{ route('transaction.data.find') }}',
            method: 'GET',
            data: {
                invoiceNumber: invoiceNumber
            },
            success: (res) => {
                const data = res.data;

                localStorage.setItem('cart', JSON.stringify(JSON.parse(data.cart) ?? []));
                localStorage.setItem('discountTransaction', JSON.stringify(JSON.parse(data.discountTransaction) ?? []));

                viewChartList();
            }
        });
    }

    function paymentProcess(midtrans) {
        document.getElementById('defaultPayment').style.display = 'none';
        document.getElementById('paymentQRIS').style.display = 'block';

        const qrString = midtrans.raw.qr_string ?? null;
        const nominal = JSON.parse(localStorage.getItem('grandTotal')) ?? 0;

        if (qrString) {
            document.getElementById('qrisAmount').innerText = 'Rp ' + rupiah(nominal);
            const canvas = document.getElementById('qrisCanvas');
            new QRious({
                element: canvas,
                value: qrString,
                size: 350
            });
        } else {
            Swal.fire({
                title: 'Error!',
                text: 'QRIS data is not available. Please check API response.',
                icon: 'error',
            });
        }
    }

    function reset() {
        window.location.reload();
    }

    function viewChartList() {
        const cart = JSON.parse(localStorage.getItem('cart')) ?? [];
        let html = '';

        if (cart === null || cart === []) {
            document.getElementById('cartValue').style.display = 'none';
            document.getElementById('cartNull').style.display = 'block';
        } else {
            document.getElementById('cartValue').style.display = 'block';
            document.getElementById('cartNull').style.display = 'none';

            cart.forEach((item, index) => {
                let variantHtml = '';
                let addonHtml = 'Addon: <br>';

                // Variant
                (item.data.variant ?? []).forEach((variant) => {
                    (variant.option).forEach((option) => {
                        if (option.select === 1) {
                            variantHtml += variant.name + ': ' + option.name + ' - Rp ' + rupiah(option.price) +'<br>';
                        }
                    });
                });

                // Addon
                (item.data.addon ?? []).forEach((addon) => {
                    addonHtml += addon.name + ': Rp ' + addon.total + '<br>';
                });

                let price = '';
                let discountProductHtml = '';
                if (parseInt(item.priceDiscount) === 0) {
                    price = `<div>Rp ${rupiah(item.grandTotal)}</div>`;
                } else {
                    price = `
                            <div class="text-decoration-line-through">Rp ${rupiah((parseInt(item.totalPrice) + parseInt(item.priceDelta)) * parseInt(item.qty))}</div>
                            ${item.priceDiscount !== 0 ? `<div class="text-danger">- Rp ${rupiah(parseInt(item.priceDiscount) * parseInt(item.qty))}</div>` : ''}
                            <div>Rp ${rupiah(item.grandTotal)}</div>
                        `;

                    (item.data.discountProduct ?? []).forEach((discount) => {
                        if (parseInt(discount.select) === 1) {
                            discountProductHtml = `<div class="text-danger">Disc: ${discount.name}</div>`;
                        }
                    });
                }

                html += `
                         <tr>
                            <td>
                                <div class="d-flex align-items-center mb-1">
                                    <h6 class="fs-16 fw-medium"><a onclick="editProductCart(${index})">${item.name}</a></h6>
                                </div>
                                <div>Base Price : Rp ${rupiah(item.basePrice)}</div>
                                ${variantHtml}
                                ${item.priceAddon !== 0 ? addonHtml : ''}
                                ${discountProductHtml}
                            </td>
                            <td class="fw-bold text-center">${item.qty}</td>
                            <td class="fw-bold">
                                ${price}
                            </td>
                        </tr>
                    `;
            });

            calculatePrice();
            calculateJumlahCart();
        }

        document.getElementById('listProductCart').innerHTML = html;
    }

    function calculatePrice() {
        const cart = JSON.parse(localStorage.getItem('cart')) ?? [];
        const discountTransaction = JSON.parse(localStorage.getItem('discountTransaction')) ?? [];

        let subTotal = 0;
        let totalTax = 0;
        let discount = 0;
        let grandTotal = 0;

        cart.forEach((item) => {
            subTotal += parseInt(item.totalPrice) * parseInt(item.qty);
            discount += parseInt(item.priceDiscount) * parseInt(item.qty);
        });

        const findDiskonTrans = Array.isArray(discountTransaction) ? discountTransaction.find((item) => parseInt(item.select) === 1) : undefined;

        if (findDiskonTrans) {
            if (findDiskonTrans.type === 'nominal') {
                discount += parseInt(findDiskonTrans.value);
            } else {
                discount += (subTotal - discount) * (parseInt(findDiskonTrans.value) / 100);
            }
        }

        totalTax = (subTotal - discount) * 0.11;

        grandTotal = subTotal - discount + totalTax;

        localStorage.setItem('subTotal', JSON.stringify(subTotal));
        localStorage.setItem('totalTax', JSON.stringify(totalTax));
        localStorage.setItem('discount', JSON.stringify(discount));
        localStorage.setItem('grandTotal', JSON.stringify(grandTotal));

        document.getElementById('subTotal').innerText = 'Rp '+rupiah(subTotal);
        document.getElementById('discount').innerText = 'Rp '+rupiah(discount);
        document.getElementById('totalTax').innerText = 'Rp '+rupiah(totalTax);
        document.getElementById('grandTotal').innerText = 'Rp '+rupiah(grandTotal);

        localStorage.setItem('grandTotal', JSON.stringify(grandTotal));
    }

    function calculateJumlahCart() {
        const cart = JSON.parse(localStorage.getItem('cart')) ?? [];
        let items = 0;

        cart.forEach((item) => {
            items += parseInt(item.qty);
        });

        document.getElementById('jumlahCart').innerText = items;
    }
</script>


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