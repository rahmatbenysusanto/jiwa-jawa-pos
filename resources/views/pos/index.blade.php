@extends('layout.index')
@section('title', 'POS')
@section('css')
    <style>
        .variant-group-title{
            font-weight: 600;
            margin-bottom: .5rem;
        }
        .variant-card {
            border: 1px solid #e5e7eb; /* abu2 tipis */
            border-radius: .75rem;
            padding: .6rem .75rem;
            user-select: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: transform .05s ease, border-color .15s ease, box-shadow .15s ease;
            background: #fff;
        }
        .variant-card:active { transform: scale(.99); }
        .variant-card.active {
            border-color: #7F56D8;
            box-shadow: 0 0 0 3px rgba(127,86,216,.15);
            background: #f9f7ff;
        }
        .variant-name { font-weight: 600; margin-right: .5rem; }
        .variant-price { font-size: .9rem; opacity: .8; white-space: nowrap; }

        .addon-group-title{
            font-weight:700; font-size:1rem; margin-bottom:.5rem;
            display:flex; align-items:center; gap:.5rem;
        }
        .addon-variant-card{
            border:1px solid #e5e7eb; border-radius:.75rem; padding:.65rem .8rem;
            cursor:pointer; background:#fff; height:100%;
        }
        .addon-variant-card:hover{ background:#f8f9fa; }
        .addon-variant-name{ font-weight:600; }
        .addon-variant-price{ font-size:.9rem; opacity:.85; white-space:nowrap; }
        .card-discount {
            border-color: #7F56D8;
            box-shadow: 0 0 0 3px rgba(127,86,216,.15);
            background: #f9f7ff;
        }
    </style>
@endsection

@section('content')
    <div class="row align-items-start pos-wrapper">

        <div class="col-md-12 col-lg-7 col-xl-8">
            <div class="pos-categories tabs_wrapper">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
                    <div>
                        <h5 class="mb-1">Welcome,  {{ Auth::user()->name }}</h5>
                        <p id="waktuSekarang"></p>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="input-icon-start pos-search position-relative">
                            <span class="input-icon-addon">
                                <i class="ti ti-search"></i>
                            </span>
                            <input type="text" class="form-control" placeholder="Search Product">
                        </div>
                        <a class="btn btn-sm btn-primary" onclick="viewAllCategory()">View All Categories</a>
                    </div>
                </div>
                <ul class="tabs owl-carousel pos-category3 mb-4">
                    <li id="all" class="active">
                        <h6>
                            <a href="javascript:void(0);">All Categories</a>
                        </h6>
                    </li>
                    @foreach($categories as $item)
                        <li id="category_{{ $item->id }}">
                            <h6>
                                <a href="javascript:void(0);">{{ $item->name }}</a>
                            </h6>
                        </li>
                    @endforeach
                </ul>
                <div class="pos-products">
                    <div class="tabs_container" id="listMenu">

                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-lg-5 col-xl-4 ps-0 theiaStickySidebar">
            <aside class="product-order-list">
                <div class="customer-info">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                        <h4 class="mb-0">New Order</h4>
                        <span class="badge badge-purple badge-xs fs-10 fw-medium ms-2">{{ $invoiceNumber }}</span>
                    </div>
                </div>
                <div class="product-added block-section mt-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="d-flex align-items-center mb-0">Order Details</h5>
                        <div class="badge bg-light text-gray-9 fs-12 fw-semibold py-2 border rounded">Items : <span class="text-teal" id="jumlahCart">0</span></div>
                    </div>
                    <div class="product-wrap">
                        <div class="empty-cart" id="cartNull">
                            <div class="mb-1">
                                <img src="{{ asset('assets/img/icons/empty-cart.svg') }}" alt="img">
                            </div>
                            <p class="fw-bold">No Products Selected</p>
                        </div>
                        <div class="product-list border-0 p-0" id="cartValue">
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th class="bg-transparent fw-bold">Product</th>
                                            <th class="bg-transparent fw-bold">QTY</th>
                                            <th class="bg-transparent fw-bold">Price</th>
                                            <th class="bg-transparent fw-bold text-end"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="listProductCart">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block-section order-method bg-light m-0">
                    <div class="order-total">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tr>
                                    <td>Sub Total</td>
                                    <td class="text-end" id="subTotal">Rp 0</td>
                                </tr>
                                <tr>
                                    <td>Discount</td>
                                    <td class="text-danger text-end" id="discount">Rp 0</td>
                                </tr>
                                <tr>
                                    <td>Tax (11%)</td>
                                    <td class="text-end" id="totalTax">Rp 0</td>
                                </tr>
                                <tr>
                                    <td>Grand Total</td>
                                    <td class="text-end" id="grandTotal">Rp 0</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row gx-2">
                        <div class="col-sm-4">
                            <a class="btn btn-teal d-flex align-items-center justify-content-center w-100 mb-2" onclick="discountTransaction()"><i  class="ti ti-percentage me-2"></i>Discount</a>
                            <a class="btn btn-indigo d-flex align-items-center justify-content-center w-100 mb-2" onclick="addNote()"><i  class="ti ti-file-description me-2"></i>Note</a>
                        </div>
                        <div class="col-sm-4">
                            <a class="btn btn-purple d-flex align-items-center justify-content-center w-100 mb-2" onclick="splitPayment()"><i  class="ti ti-receipt-tax me-2"></i>Split Payment</a>
                            <a class="btn btn-info d-flex align-items-center justify-content-center w-100 mb-2" onclick="delivery()"><i class="ti ti-map-pin-check me-2"></i>Delivery</a>
                        </div>
                        <div class="col-sm-4" id="changePayment">
                            <a class="btn btn-danger d-flex align-items-center justify-content-center w-100 mb-2" onclick="resetTransaction()"><i class="ti ti-reload me-2"></i>Reset</a>
                            <a class="btn btn-cyan d-flex align-items-center justify-content-center w-100 mb-2" onclick="payment()"><i  class="ti ti-cash-banknote me-2"></i>Payment</a>
{{--                            <button id="btnPrint" type="button" class="btn btn-primary">Print</button>--}}
                        </div>
                    </div>
                </div>
                <div class="block-section payment-method mt-3">
                    <div class="btn-block m-0">
                        <div class="d-flex gap-2" id="buttonAfterProcess">

                        </div>
                        <a class="btn btn-success w-100" id="buttonPay" onclick="paymentProcess()">
                            Pay : Rp 0
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <div id="productDetailModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Product Detail</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="product-detail-id">

                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Name Product</label>
                                <input type="text" class="form-control" id="product-detail-name" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Category Product</label>
                                <input type="text" class="form-control" id="product-detail-category" readonly>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Name SKU</label>
                                <input type="text" class="form-control" id="product-detail-sku" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Base Price</label>
                                <input type="text" class="form-control" id="product-detail-base-price" readonly>
                            </div>
                        </div>
                    </div>

                    <h4 class="modal-title mb-1">Variant Product</h4>
                    <div class="row" id="listVariantProduct">

                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-2 mt-3">
                        <h4 class="modal-title mb-1">Addon</h4>
                        <a class="btn btn-info btn-sm" onclick="openAddonModal()">+ Addon</a>
                    </div>
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th class="text-center">QTY</th>
                                <th>Total Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="viewListAddon">

                        </tbody>
                    </table>

                    <div class="mt-3">
                        <h4 class="modal-title mb-1">Discount</h4>
                        <div class="row" id="discountProduct">

                        </div>
                    </div>
                </div>
                <div class="modal-footer gap-2">
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addProduct()">Add Product</button>
                </div>
            </div>
        </div>
    </div>

    <div id="addonModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Addon Product</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <div id="addon-groups" class="vstack gap-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="editProductCartModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Product Detail</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="product-edit-id">

                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Name Product</label>
                                <input type="text" class="form-control" id="product-edit-name" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Category Product</label>
                                <input type="text" class="form-control" id="product-edit-category" readonly>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Name SKU</label>
                                <input type="text" class="form-control" id="product-edit-sku" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Base Price</label>
                                <input type="text" class="form-control" id="product-edit-base-price" readonly>
                            </div>
                        </div>
                    </div>

                    <h4 class="modal-title mb-1">Variant Product</h4>
                    <div class="row" id="listVariantProductEdit">

                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-2 mt-3">
                        <h4 class="modal-title mb-1">Addon</h4>
                        <a class="btn btn-info btn-sm" onclick="openAddonEditModal()">+ Addon</a>
                    </div>
                    <table class="table align-middle">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th class="text-center">QTY</th>
                            <th>Total Price</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="viewListAddonEdit">

                        </tbody>
                    </table>

                    <div class="mt-3">
                        <h4 class="modal-title mb-1">Discount</h4>
                        <div class="row" id="discountProductEdit">

                        </div>
                    </div>
                </div>
                <div class="modal-footer gap-2">
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="editProduct()">Edit Product</button>
                </div>
            </div>
        </div>
    </div>

    <div id="addonEditModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Addon Product</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <div id="addon-edit-list" class="vstack gap-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="noteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Note Transaction</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <textarea class="form-control" id="note" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer gap-2">
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveNote()">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div id="splitPaymentModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Split Payment</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="additem-info">
                        <div class="bg-light p-3 add-info" id="listSplitPayment">

                        </div>
                    </div>
                    <div class="text-end">
                        <a class="btn btn-primary btn-md" onclick="addSplitPayment()">Add More</a>
                    </div>
                </div>
                <div class="modal-footer gap-2">
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="splitPaymentProcess()">Split Payment</button>
                </div>
            </div>
        </div>
    </div>

    <div id="deliveryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Delivery Transaction</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row" id="listDelivery">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="paymentModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Payment</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <select class="form-control" id="paymentMethod" onchange="changePaymentMethod(this.value)">

                    </select>
                </div>
            </div>
        </div>
    </div>

    <div id="discountTransactionModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Discount Transaction</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row" id="discountTransaction">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalQris" tabindex="-1" aria-labelledby="modalQrisLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius:15px; padding:20px;">
                <div class="modal-body text-center">
                    <h5 class="fw-bold mb-2" id="storeName">Kedai Selvin</h5>
                    <p class="mb-1 text-muted" id="storeLocation">Bekasi Indonesia</p>
                    <hr>

                    <canvas id="qrisCanvas" width="250" height="250" style="margin:auto; display:block;"></canvas>

                    <p class="mt-3 mb-1 fw-semibold">Total Bayar:</p>
                    <h4 class="fw-bold text-dark mb-3" id="qrisAmount">Rp 0</h4>

                    <p class="text-muted mb-1" style="font-size:13px;">Scan menggunakan aplikasi e-wallet Anda</p>
                    <img src="{{ asset('assets/img/qris.webp') }}" alt="QRIS" width="80" class="mt-2">
                </div>
            </div>
        </div>
    </div>

    <div id="paymentDebitModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Payment Debit</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Approval Code</label>
                        <input type="text" class="form-control" id="approvalCode" placeholder="749XXXX">
                    </div>
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-primary" onclick="saveApprovalCode()">Save Approval Code</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="changePaymentModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Change Payment</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <select class="form-control" id="changePayment">
                        <option value="">-- Choose Payment Method --</option>
                        <option>Cash</option>
                        <option>QRIS</option>
                        <option>Debit</option>
                        <option>Transfer</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-primary" onclick="processChangePayment()">Change Payment Method</a>
                </div>
            </div>
        </div>
    </div>

    <div id="changePaymentDebitModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Payment Debit</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Approval Code</label>
                        <input type="text" class="form-control" id="approvalCodeChangePayment" placeholder="749XXXX">
                    </div>
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-primary" onclick="changePaymentSaveApprovalCode()">Save Approval Code</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/qz-tray/qz-tray.js"></script>
    <script>
        // 0) DEV ONLY: matikan kebutuhan sertifikat & tanda tangan
        qz.security.setCertificatePromise((resolve, reject) => resolve(null));
        qz.security.setSignaturePromise((toSign) => (resolve, reject) => resolve(null));

        async function ensureQZ() {
            if (!qz.websocket.isActive()) {
                // pakai ws (insecure) di localhost
                await qz.websocket.connect({ host: 'localhost', usingSecure: false });
            }
        }

        async function printNota() {
            try {
                await ensureQZ();

                const matches = await qz.printers.find("HaoYin");
                const printer = matches[0] || await qz.printers.getDefault();
                if (!printer) throw new Error('Printer tidak ditemukan di macOS');

                // 2) config: ALT PRINTING penting di macOS agar RAW ESC/POS tembus
                const cfg = qz.configs.create(printer, {
                    altPrinting: true,              // kunci di macOS
                    // encoding: 'CP437',           // opsional, sesuai self-test kamu
                });

                // 3) uji RAW termudah: teks polos + feed
                const data = ["TEST RAW\nKEDAI SELVIN\n\n\n"]; // dulu tanpa ESC
                await qz.print(cfg, data);

                // 4) jika barusan berhasil, lanjut ESC/POS
                const ESC = '\x1B', GS = '\x1D';
                const escpos = [
                    ESC+"@", ESC+"a"+"\x01", "KEDAI SELVIN\n", "Solo\n\n",
                    ESC+"a"+"\x00",
                    "Americano  x1      18.000\n",
                    "Croissant  x1      12.000\n",
                    "---------------------------\n",
                    "Total               30.000\n",
                    "Metode: DEBIT\n",
                    "Approval: 749832\n",
                    "Last4  : 1234\n",
                    "\n\n\n"
                    // GS+"V"+"\x00" // cutter jika ada auto-cutter
                ];
                await qz.print(cfg, escpos);

                alert('Print terkirim ✓');
            } catch (e) {
                console.error(e);
                alert('Gagal print: ' + (e.message || e));
            }
        }

        document.getElementById('btnPrint').addEventListener('click', printNota);
    </script>

    <script>
        localStorage.clear();
        loadAllMenu();
        loadDataDelivery();
        document.getElementById('cartValue').style.display = 'none';

        function rupiah(angka) {
            return new Intl.NumberFormat('id-ID').format(angka);
        }

        function loadDataDelivery() {
            localStorage.setItem('delivery', JSON.stringify([
                {
                    name: 'Dine In',
                    select: 1
                },
                {
                    name: 'Take Away',
                    select: 0
                },
                {
                    name: 'Delivery',
                    select: 0
                },
            ]));
        }

        function viewAllCategory() {
            document.getElementById('allProduct').classList.add('active');
            document.getElementById('all').classList.add('active');
            document.getElementById('categoryMenuList').classList.remove('active');

            const category = {!! json_encode($categories) !!};
            category.forEach((item) => {
                document.getElementById(`category_${item.id}`).classList.remove('active');
            });
        }

        function loadAllMenu() {
            $.ajax({
                url: '{{ route('pos.menu') }}',
                method: 'GET',
                success: (res) => {
                    const allMenu = res.all;
                    const menu = res.category;
                    let html = '';

                    // All Menu
                    html += `
                        <div  class="tab_content active" data-tab="all" id="allProduct">
                            <div class="row row-cols-xxl-5 g-3">
                    `;

                    allMenu.forEach((product) => {
                        html += `
                            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 col-xxl cursor-pointer" onclick="selectProduct('${product.id}')">
                                <div class="product-info card mb-0">
                                    <a onclick="selectProduct('${product.id}')" class="product-image">
                                        <img src="{{ asset('assets/img/products/pos-product-02.jpg')}}" alt="Products">
                                    </a>
                                    <h6 class="cat-name"><a onclick="selectProduct('${product.id}')">${product.category.name}</a></h6>
                                    <h6 class="product-name"><a onclick="selectProduct('${product.id}')">${product.name}</a></h6>
                                    <div class="d-flex align-items-center justify-content-between price">
                                        <span>30 Pcs</span>
                                        <p>Rp ${rupiah(product.price)}</p>
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    html += `
                        </div>
                            </div>
                    `;

                    // Menu By Category
                    menu.forEach((menuCategory) => {
                        html += `
                            <div  class="tab_content" data-tab="${menuCategory.idName}" id="categoryMenuList">
                                <div class="row row-cols-xxl-5 g-3">
                        `;

                        (menuCategory.menu).forEach((product) => {
                            html += `
                                <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 col-xxl cursor-pointer" onclick="selectProduct('${product.id}')">
                                    <div class="product-info card mb-0">
                                        <a onclick="selectProduct('${product.id}')" class="product-image">
                                            <img src="{{ asset('assets/img/products/pos-product-02.jpg')}}" alt="Products">
                                        </a>
                                        <h6 class="cat-name"><a onclick="selectProduct('${product.id}')">${product.category.name}</a></h6>
                                        <h6 class="product-name"><a onclick="selectProduct('${product.id}')">${product.name}</a></h6>
                                        <div class="d-flex align-items-center justify-content-between price">
                                            <span>30 Pcs</span>
                                            <p>Rp ${rupiah(product.price)}</p>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });

                        html += `
                            </div>
                                </div>
                        `;
                    });

                    document.getElementById('listMenu').innerHTML = html;
                }
            });
        }

        function selectProduct(productId) {
            localStorage.setItem('addon', JSON.stringify([]));

            $.ajax({
                url: '{{ route('pos.product.find') }}',
                method: 'GET',
                data: { id: productId },
                success: (res) => {
                    const product  = res.data;
                    const discount = res.discount || [];

                    localStorage.setItem('product', JSON.stringify({
                        id: product.id,
                        name: product.name,
                        price: parseInt(product.price),
                        sku: product.sku,
                        category: product.category.name,
                        combo: product.is_combo
                    }));

                    const discountWithSelect = discount.map(item => ({ ...item, select: 0 }));
                    localStorage.setItem('discountProduct', JSON.stringify(discountWithSelect));

                    const dataVariant = [];
                    (product.menu_variant || []).forEach((variant, indexVariant) => {
                        const valueVariant = [];
                        (variant.menu_variant_options || []).forEach((item) => {
                            valueVariant.push({
                                id: item.id,
                                name: item.name,
                                price: parseFloat(item.price_delta || 0),
                                select: item.is_default === 1 ? 1 : 0
                            });
                        });

                        if (!valueVariant.some(v => v.select === 1) && valueVariant.length > 0) {
                            valueVariant[0].select = 1;
                        }

                        dataVariant.push({
                            id: variant.id,
                            name: variant.name,
                            option: valueVariant,
                        });
                    });

                    localStorage.setItem('variant', JSON.stringify(dataVariant));
                    renderVariantCards();

                    localStorage.setItem('discountProduct', JSON.stringify(discount));
                    viewDiscountProduct();

                    document.getElementById('product-detail-id').value = product.id;
                    document.getElementById('product-detail-name').value = product.name;
                    document.getElementById('product-detail-sku').value = product.sku;
                    document.getElementById('product-detail-base-price').value = 'Rp ' + rupiah(product.price);
                    document.getElementById('product-detail-category').value = product.category.name;

                    viewListAddon();

                    $('#productDetailModal').modal('show');
                }
            });
        }

        function renderVariantCards() {
            const container = document.getElementById('listVariantProduct');
            const variants  = JSON.parse(localStorage.getItem('variant')) || [];
            let html = '';

            variants.forEach((variant, idx) => {
                html += `
                  <div class="col-12">
                    <div class="variant-group-title">${variant.name}</div>
                    <div class="row g-2" data-variant-index="${idx}">
                      ${variant.option.map(opt => {
                                const active = opt.select === 1 ? 'active' : '';
                                const priceText = opt.price > 0 ? `+ Rp ${rupiah(opt.price)}` :
                                    opt.price < 0 ? `- Rp ${rupiah(Math.abs(opt.price))}` :
                                        'Rp 0';
                                return `
                          <div class="col-6 col-md-4">
                            <div class="variant-card ${active}"
                                 data-option-id="${opt.id}"
                                 onclick="selectVariantOption(${idx}, ${opt.id}, this)">
                              <span class="variant-name">${opt.name}</span>
                              <span class="variant-price">${priceText}</span>
                            </div>
                          </div>
            `;
                        }).join('')}
                </div>
              </div>
            `;
            });

            container.innerHTML = html;
        }

        function selectVariantOption(variantIndex, optionId, el) {
            let variants = JSON.parse(localStorage.getItem('variant')) || [];
            const v = variants[variantIndex];
            if (!v) return;

            v.option = v.option.map(o => ({ ...o, select: o.id === optionId ? 1 : 0 }));
            localStorage.setItem('variant', JSON.stringify(variants));

            if (el) {
                const row = el.closest(`[data-variant-index="${variantIndex}"]`);
                row.querySelectorAll('.variant-card').forEach(card => card.classList.remove('active'));
                el.classList.add('active');
            } else {
                renderVariantCards();
            }

            if (typeof updateCartPreview === 'function') {
                updateCartPreview();
            }
        }

        function changeVariant(indexVariant, value) {
            const optionId = parseInt(value, 10);
            const row = document.querySelector(`[data-variant-index="${indexVariant}"]`);
            const el  = row ? row.querySelector(`.variant-card[data-option-id="${optionId}"]`) : null;
            selectVariantOption(indexVariant, optionId, el);
        }

        function openAddonModal() {
            $.ajax({
                url: '{{ route('pos.addon.all') }}',
                method: 'GET',
                success: (res) => {
                    const groups = Array.isArray(res.data) ? res.data : [];
                    let html = '';

                    groups.forEach(g => {
                        const variants = Array.isArray(g.addon_variant) ? g.addon_variant : [];
                        let htmlVariant = '';
                        variants.forEach(variant => {
                            htmlVariant += `
                                <div class="col-3" onclick="addProductAddon(${variant.id})">
                                    <div class="card border border-secondary">
                                        <div class="card-body">
                                            <div class="fw-semibold">${variant.name}</div>
                                            <div class="text-muted small">Rp ${rupiah(variant.price)}</div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });


                        html += `
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center fw-bold mb-2">
                                      <span>${g.name}</span>
                                      <span class="badge bg-secondary">${variants.length}</span>
                                    </div>
                                    <div class="row">
                                        ${htmlVariant}
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    document.getElementById('addon-groups').innerHTML = html;
                    $('#addonModal').modal('show');
                }
            });
        }

        function addProductAddon(addonVariantId) {
            if (addonVariantId === '') {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Please enter a valid addon variant',
                    icon: 'warning',
                });
                return true;
            }

            $.ajax({
                url: '{{ route('pos.addon.variant') }}',
                method: 'GET',
                data: {
                    id: addonVariantId,
                },
                success: (res) => {
                    const data = res.data;
                    const addon = JSON.parse(localStorage.getItem('addon')) ?? [];
                    const find = addon.find((item) => item.id === addonVariantId);
                    if (find) {
                        find.qty += 1;
                        find.total += parseFloat(find.price);
                    } else {
                        addon.push({
                            id: addonVariantId,
                            name: data.name,
                            price: parseFloat(data.price),
                            total: parseFloat(data.price),
                            qty: 1
                        });
                    }

                    localStorage.setItem('addon', JSON.stringify(addon));
                    viewListAddon();
                    $('#addonModal').modal('hide');
                }
            });
        }

        function viewListAddon() {
            const addon = JSON.parse(localStorage.getItem('addon')) ?? [];
            let html = '';

            addon.forEach((item, index) => {
                html += `
                    <tr>
                        <td>${item.name}</td>
                        <td>Rp ${rupiah(item.price)}</td>
                        <td class="text-center">
                            <div class="qty-item m-0">
                                <a onclick="changeQtyAddon(${index}, 'kurang')" class="dec d-flex justify-content-center align-items-center" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="minus" data-bs-original-title="minus">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus-circle feather-14">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="8" y1="12" x2="16" y2="12"></line>
                                    </svg>
                                </a>
                                <input type="text" class="form-control text-center" value="${item.qty}" readonly>
                                <a onclick="changeQtyAddon(${index}, 'tambah')" class="inc d-flex justify-content-center align-items-center" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="plus" data-bs-original-title="plus">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle feather-14">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="12" y1="8" x2="12" y2="16"></line>
                                        <line x1="8" y1="12" x2="16" y2="12"></line>
                                    </svg>
                                </a>
                            </div>
                        </td>
                        <td>Rp ${rupiah(item.total)}</td>
                        <td><a class="btn btn-danger btn-sm" onclick="deleteAddon(${index})"><i class="fa fa-trash"></a></td>
                    </tr>
                `;
            });

            document.getElementById('viewListAddon').innerHTML = html;
        }

        function changeQtyAddon(index, type) {
            const addon = JSON.parse(localStorage.getItem('addon')) ?? [];
            const find = addon[index];

            if (type === 'tambah') {
                find.qty += 1;
                find.total += parseFloat(find.price);
            } else {
                if (parseInt(find.qty) !== 1) {
                    find.qty -= 1;
                    find.total -= parseFloat(find.price);
                }
            }

            localStorage.setItem('addon', JSON.stringify(addon));
            viewListAddon();
        }

        function deleteAddon(index) {
            const addon = JSON.parse(localStorage.getItem('addon')) ?? [];
            addon.splice(index, 1);
            localStorage.setItem('addon', JSON.stringify(addon));
            viewListAddon();
        }

        function addProduct() {
            const cart = JSON.parse(localStorage.getItem('cart')) ?? [];
            const product = JSON.parse(localStorage.getItem('product')) ?? [];
            const variant = JSON.parse(localStorage.getItem('variant')) ?? [];
            const addon = JSON.parse(localStorage.getItem('addon')) ?? [];
            const discountProduct = JSON.parse(localStorage.getItem('discountProduct')) ?? [];

            let priceDelta = 0;
            variant.forEach((item) => {
                item.option.forEach((option) => {
                    if (option.select === 1) {
                        priceDelta += option.price;
                    }
                });
            });

            let priceAddon = 0;
            addon.forEach((item) => {
                priceAddon += item.total;
            });

            let priceDiscount = 0;
            discountProduct.forEach((item) => {
                if (parseInt(item.select) === 1) {
                    if (item.type === 'nominal') {
                        priceDiscount = item.value;
                    } else {
                        priceDiscount = (parseInt(product.price) + priceDelta + priceAddon) * item.value / 100;
                    }
                }
            });

            const totalPrice = parseInt(product.price) + priceDelta + priceAddon - parseInt(priceDiscount);

            cart.push({
                menuId: product.id,
                name: product.name,
                qty: 1,
                basePrice: Number(product.price),
                priceDelta: Number(priceDelta),
                priceAddon: Number(priceAddon),
                priceDiscount: Number(priceDiscount),
                totalPrice: Number(totalPrice),
                grandTotal: Number(totalPrice),
                data: {
                    product: product,
                    variant: variant,
                    addon: addon,
                    discountProduct: discountProduct
                }
            });

            localStorage.setItem('cart', JSON.stringify(cart));
            $('#productDetailModal').modal('hide');
            viewChartList();
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
                    (item.data.variant).forEach((variant) => {
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
                    if (item.priceDiscount === 0) {
                        price = `<div>Rp ${rupiah(item.grandTotal)}</div>`;
                    } else {
                        price = `
                            <div class="text-decoration-line-through">Rp ${rupiah((item.totalPrice + item.priceDelta) * item.qty)}</div>
                            ${item.priceDiscount !== 0 ? `<div class="text-danger">- Rp ${rupiah(item.priceDiscount * item.qty)}</div>` : ''}
                            <div>Rp ${rupiah(item.grandTotal)}</div>
                        `;

                        (item.data.discountProduct ?? []).forEach((discount) => {
                            if (discount.select === 1) {
                                discountProductHtml = `<div class="text-danger">Disc: ${discount.name}</div>`;
                            }
                        });
                    }

                    html += `
                         <tr>
                            <td>
                                <div class="d-flex align-items-center mb-1">
                                    <h6 class="fs-16 fw-medium"><a onclick="editProductCart(${index})">${item.name}</a></h6>
                                    <a class="ms-2 edit-icon" onclick="editProductCart(${index})"><i class="ti ti-edit"></i></a>
                                </div>
                                <div>Base Price : Rp ${rupiah(item.basePrice)}</div>
                                ${variantHtml}
                                ${item.priceAddon !== 0 ? addonHtml : ''}
                                ${discountProductHtml}
                            </td>
                            <td>
                                <div class="qty-item m-0">
                                    <a onclick="changeQtyProductCart(${index}, 'kurang')" class="dec d-flex justify-content-center align-items-center" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="minus" data-bs-original-title="minus">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus-circle feather-14">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="8" y1="12" x2="16" y2="12"></line>
                                        </svg>
                                    </a>
                                    <input type="text" class="form-control text-center" value="${item.qty}" readonly>
                                    <a onclick="changeQtyProductCart(${index}, 'tambah')" class="inc d-flex justify-content-center align-items-center" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="plus" data-bs-original-title="plus">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle feather-14">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="12" y1="8" x2="12" y2="16"></line>
                                            <line x1="8" y1="12" x2="16" y2="12"></line>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                            <td class="fw-bold">
                                ${price}
                            </td>
                            <td class="text-end">
                                <a class="btn-icon delete-icon" onclick="deleteCart(${index})">
                                    <i class="ti ti-trash"></i>
                                </a>
                            </td>
                        </tr>
                    `;
                });

                calculatePrice();
                calculateJumlahCart();
            }

            document.getElementById('listProductCart').innerHTML = html;
        }

        function changeQtyProductCart(index, type) {
            const cart = JSON.parse(localStorage.getItem('cart')) ?? [];
            const find = cart[index];

            if (type === 'tambah') {
                find.qty++
                find.grandTotal += parseInt(find.totalPrice);
            } else {
                if (parseInt(find.qty) !== 1) {
                    find.qty--
                    find.grandTotal -= parseInt(find.totalPrice);
                }
            }

            localStorage.setItem('cart', JSON.stringify(cart));
            viewChartList();
        }

        function deleteCart(index) {
            const cart = JSON.parse(localStorage.getItem('cart')) ?? [];
            cart.splice(index, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
            viewChartList();
        }

        function editProductCart(index) {
            const cart  = JSON.parse(localStorage.getItem('cart')) ?? [];
            const find  = cart[index];
            const product = find.data.product;
            const variant = find.data.variant;
            const addon   = find.data.addon;
            const discountProduct = find.data.discountProduct || [];

            window.EDITING_CART_INDEX = index;

            document.getElementById('product-edit-id').value = product.id;
            document.getElementById('product-edit-name').value = product.name;
            document.getElementById('product-edit-category').value = product.category;
            document.getElementById('product-edit-sku').value = product.sku;
            document.getElementById('product-edit-base-price').value = 'Rp ' + rupiah(product.price);

            localStorage.setItem('variant', JSON.stringify(variant));

            renderVariantCardsEdit('listVariantProductEdit');

            localStorage.setItem('addon', JSON.stringify(addon));
            if (typeof viewAddonEdit === 'function') viewAddonEdit();

            localStorage.setItem('discountProduct', JSON.stringify(discountProduct));
            viewDiscountProductEdit();

            if (typeof updateCartPreview === 'function') updateCartPreview();

            $('#editProductCartModal').modal('show');
        }

        function renderVariantCardsEdit(containerId) {
            const container = document.getElementById(containerId);
            const variants  = JSON.parse(localStorage.getItem('variant')) ?? [];
            let html = '';

            variants.forEach((variant, idx) => {
                html += `
                  <div class="col-12">
                    <div class="variant-group-title">${variant.name}</div>
                    <div class="row g-2" data-variant-index-edit="${idx}">
                      ${variant.option.map(opt=>{
                                const active = opt.select === 1 ? 'active':'';
                                const priceText = opt.price>0 ? `+ Rp ${rupiah(opt.price)}` : opt.price<0 ? `- Rp ${rupiah(Math.abs(opt.price))}` : 'Rp 0';
                                return `
                                  <div class="col-6 col-md-4">
                                    <div class="variant-card ${active}" data-option-id="${opt.id}"
                                      onclick="selectVariantOptionEdit(${idx}, ${opt.id}, this)">
                                      <span class="variant-name">${opt.name}</span>
                                      <span class="variant-price">${priceText}</span>
                                    </div>
                                  </div>
                                `;
                            }).join('')}
                    </div>
                  </div>
                `;
            });

            container.innerHTML = html;
        }

        function selectVariantOptionEdit(variantIndex, optionId, el) {
            let variants = JSON.parse(localStorage.getItem('variant')) ?? [];
            const v = variants[variantIndex];
            if (!v) return;

            v.option = v.option.map(o => ({ ...o, select: o.id === optionId ? 1 : 0 }));
            localStorage.setItem('variant', JSON.stringify(variants));

            if (el) {
                const row = el.closest(`[data-variant-index-edit="${variantIndex}"]`);
                row.querySelectorAll('.variant-card').forEach(card => card.classList.remove('active'));
                el.classList.add('active');
            } else {
                renderVariantCardsEdit('listVariantProductEdit');
            }

            if (typeof updateCartPreview === 'function') updateCartPreview();
        }

        function changeVariantEdit(indexVariant, value) {
            const optionId = parseInt(value, 10);
            const row = document.querySelector(`[data-variant-index-edit="${indexVariant}"]`);
            const el  = row ? row.querySelector(`.variant-card[data-option-id="${optionId}"]`) : null;
            selectVariantOptionEdit(indexVariant, optionId, el);
        }

        function viewAddonEdit() {
            const addon = JSON.parse(localStorage.getItem('addon')) ?? [];
            let html = '';

            addon.forEach((item, index) => {
                html += `
                    <tr>
                        <td>${item.name}</td>
                        <td>Rp ${rupiah(item.price)}</td>
                        <td class="text-center">
                            <div class="qty-item m-0">
                                <a onclick="changeQtyAddonEdit(${index}, 'kurang')" class="dec d-flex justify-content-center align-items-center" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="minus" data-bs-original-title="minus">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus-circle feather-14">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="8" y1="12" x2="16" y2="12"></line>
                                    </svg>
                                </a>
                                <input type="text" class="form-control text-center" value="${item.qty}" readonly>
                                <a onclick="changeQtyAddonEdit(${index}, 'tambah')" class="inc d-flex justify-content-center align-items-center" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="plus" data-bs-original-title="plus">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle feather-14">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="12" y1="8" x2="12" y2="16"></line>
                                        <line x1="8" y1="12" x2="16" y2="12"></line>
                                    </svg>
                                </a>
                            </div>
                        </td>
                        <td>Rp ${rupiah(item.total)}</td>
                        <td><a class="btn btn-danger btn-sm" onclick="deleteAddon(${index})"><i class="fa fa-trash"></a></td>
                    </tr>
                `;
            });

            document.getElementById('viewListAddonEdit').innerHTML = html;
        }

        function openAddonEditModal() {
            $.ajax({
                url: '{{ route('pos.addon.all') }}',
                method: 'GET',
                success: (res) => {
                    const groups = Array.isArray(res.data) ? res.data : [];
                    let html = '';

                    groups.forEach(g => {
                        const variants = Array.isArray(g.addon_variant) ? g.addon_variant : [];
                        let htmlVariant = '';
                        variants.forEach(variant => {
                            htmlVariant += `
                                <div class="col-3" onclick="addProductAddonEdit(${variant.id})">
                                    <div class="card border border-secondary">
                                        <div class="card-body">
                                            <div class="fw-semibold">${variant.name}</div>
                                            <div class="text-muted small">Rp ${rupiah(variant.price)}</div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });


                        html += `
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center fw-bold mb-2">
                                      <span>${g.name}</span>
                                      <span class="badge bg-secondary">${variants.length}</span>
                                    </div>
                                    <div class="row">
                                        ${htmlVariant}
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    document.getElementById('addon-edit-list').innerHTML = html;
                    $('#addonEditModal').modal('show');
                }
            });
        }

        function addProductAddonEdit(addonVariantId) {
            if (addonVariantId === '') {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Please enter a valid addon variant',
                    icon: 'warning',
                });
                return true;
            }

            $.ajax({
                url: '{{ route('pos.addon.variant') }}',
                method: 'GET',
                data: {
                    id: addonVariantId,
                },
                success: (res) => {
                    const data = res.data;
                    const addon = JSON.parse(localStorage.getItem('addon')) ?? [];
                    const find = addon.find((item) => item.id === addonVariantId);
                    if (find) {
                        find.qty += 1;
                        find.total += parseFloat(find.price);
                    } else {
                        addon.push({
                            id: addonVariantId,
                            name: data.name,
                            price: parseFloat(data.price),
                            total: parseFloat(data.price),
                            qty: 1
                        });
                    }

                    localStorage.setItem('addon', JSON.stringify(addon));
                    viewAddonEdit();
                    $('#addonEditModal').modal('hide');
                }
            });
        }

        function changeQtyAddonEdit(index, type) {
            const addon = JSON.parse(localStorage.getItem('addon')) ?? [];
            const find = addon[index];

            if (type === 'tambah') {
                find.qty += 1;
                find.total += parseFloat(find.price);
            } else {
                if (parseInt(find.qty) !== 1) {
                    find.qty -= 1;
                    find.total -= parseFloat(find.price);
                }
            }

            localStorage.setItem('addon', JSON.stringify(addon));
            viewAddonEdit();
        }

        function deleteAddonEdit(index) {
            const addon = JSON.parse(localStorage.getItem('addon')) ?? [];
            addon.splice(index, 1);
            localStorage.setItem('addon', JSON.stringify(addon));
            viewAddonEdit();
        }

        function editProduct() {
            const cart = JSON.parse(localStorage.getItem('cart')) ?? [];
            const variant = JSON.parse(localStorage.getItem('variant')) ?? [];
            const addon = JSON.parse(localStorage.getItem('addon')) ?? [];
            const discountProduct = JSON.parse(localStorage.getItem('discountProduct')) ?? [];
            const productId = document.getElementById('product-edit-id').value;
            const product = cart.find((item) => item.menuId === parseInt(productId));

            let priceDelta = 0;
            variant.forEach((item) => {
                item.option.forEach((option) => {
                    if (option.select === 1) {
                        priceDelta += option.price;
                    }
                });
            });

            let priceAddon = 0;
            addon.forEach((item) => {
                priceAddon += item.total;
            });

            let priceDiscount = 0;
            discountProduct.forEach((item) => {
                if (parseInt(item.select) === 1) {
                    if (item.type === 'nominal') {
                        priceDiscount = parseInt(item.value);
                    } else {
                        priceDiscount = (parseInt(product.price) + priceDelta + priceAddon) * item.value / 100;
                    }
                }
            });

            const totalPrice = parseInt(product.basePrice) + priceDelta + priceAddon - parseInt(priceDiscount);

            product.priceDelta = priceDelta;
            product.priceDiscount = priceDiscount;
            product.priceAddon = priceAddon;
            product.totalPrice = totalPrice;
            product.grandTotal = totalPrice * product.qty;
            product.data = {
                variant: variant,
                addon: addon,
                product: product.data.product,
                discountProduct: discountProduct
            }

            localStorage.setItem('cart', JSON.stringify(cart));
            $('#editProductCartModal').modal('hide');
            viewChartList();
        }

        function changeDiscountProduct(value) {
            let discountProduct = JSON.parse(localStorage.getItem('discountProduct')) ?? [];

            discountProduct.forEach((item) => {
                if (parseInt(item.id) === parseInt(value)) {
                    if (typeof item.select === 'undefined') {
                        item.select = 0;
                    }

                    item.select = item.select === 1 ? 0 : 1;
                }
            });

            localStorage.setItem('discountProduct', JSON.stringify(discountProduct));
            viewDiscountProduct();
        }

        function viewDiscountProduct() {
            const discountProduct = JSON.parse(localStorage.getItem('discountProduct')) ?? [];

            let htmlDiscount = '';
            discountProduct.forEach((item) => {
                const labelVal = item.type === 'nominal' ? 'Rp ' + rupiah(item.value) : (item.value + '%');
                htmlDiscount += `
                    <div class="col-3">
                        <a onclick="changeDiscountProduct(${item.id})">
                            <div class="card p-3 ${item.select === 1 ? 'card-discount' : ''}">
                                <div>${item.code}</div>
                                <div class="fw-bold">${item.name}</div>
                                <div class="fw-bold">${labelVal}</div>
                            </div>
                        </a>
                    </div>
                `;
            });
            document.getElementById('discountProduct').innerHTML = htmlDiscount;
        }

        function changeDiscountProductEdit(value) {
            const discountProduct = JSON.parse(localStorage.getItem('discountProduct')) ?? [];

            discountProduct.forEach((item) => {
                if (parseInt(item.id) === parseInt(value)) {
                    if (typeof item.select === 'undefined') {
                        item.select = 0;
                    }

                    item.select = item.select === 1 ? 0 : 1;
                }
            });

            localStorage.setItem('discountProduct', JSON.stringify(discountProduct));
            viewDiscountProductEdit();
        }

        function viewDiscountProductEdit() {
            const discountProduct = JSON.parse(localStorage.getItem('discountProduct')) ?? [];

            let htmlDiscount = '';
            discountProduct.forEach((item) => {
                const labelVal = item.type === 'nominal' ? 'Rp ' + rupiah(item.value) : (item.value + '%');
                htmlDiscount += `
                    <div class="col-3">
                        <a onclick="changeDiscountProductEdit(${item.id})">
                            <div class="card p-3 ${item.select === 1 ? 'card-discount' : ''}">
                                <div>${item.code}</div>
                                <div class="fw-bold">${item.name}</div>
                                <div class="fw-bold">${labelVal}</div>
                            </div>
                        </a>
                    </div>
                `;
            });
            document.getElementById('discountProductEdit').innerHTML = htmlDiscount;
        }

        function calculatePrice() {
            const cart = JSON.parse(localStorage.getItem('cart')) ?? [];
            const discountTransaction = JSON.parse(localStorage.getItem('discountTransaction')) ?? [];

            let subTotal = 0;
            let totalTax = 0;
            let discount = 0;
            let grandTotal = 0;

            cart.forEach((item) => {
                subTotal += item.totalPrice * item.qty;
                discount += item.priceDiscount * item.qty;
            });

            const findDiskonTrans = Array.isArray(discountTransaction) ? discountTransaction.find((item) => item.select === 1) : undefined;

            if (findDiskonTrans) {
                if (findDiskonTrans.type === 'nominal') {
                    discount += findDiskonTrans.value;
                } else {
                    discount += (subTotal - discount) * (findDiskonTrans.value / 100);
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
            document.getElementById('buttonPay').innerText = 'Pay : Rp '+ rupiah(grandTotal);

            localStorage.setItem('grandTotal', JSON.stringify(grandTotal));

            saveTransactionData();
        }

        function calculateJumlahCart() {

            const cart = JSON.parse(localStorage.getItem('cart')) ?? [];
            let items = 0;

            cart.forEach((item) => {
                items += item.qty;
            });

            document.getElementById('jumlahCart').innerText = items;
        }

        function addNote() {
            document.getElementById('note').value = JSON.parse(localStorage.getItem('note')) ?? '';

            $('#noteModal').modal('show');
        }

        function saveNote() {
            const note = document.getElementById('note').value;
            localStorage.setItem('note', JSON.stringify(note));
            $('#noteModal').modal('hide');
        }

        function splitPayment() {
            viewSplitPayment();
            $('#splitPaymentModal').modal('show');
        }

        function viewSplitPayment() {
            const splitPayment = JSON.parse(localStorage.getItem('splitPayment')) ?? [];
            let html = '';

            splitPayment.forEach((item, index) => {
                html += `
                    <div class="row align-items-center g-2 mb-3">
                        <div class="col-lg-2">
                            <h6 class="fs-14 fw-semibold">Payment ${index + 1}</h6>
                        </div>
                        <div class="col-lg-4">
                            <select class="form-control" onchange="changeSplitPayment(${index}, 'paymentMethod', this.value)">
                                <option value="">-- Choose Payment Method --</option>
                                <option ${item.paymentMethod === 'Cash' ? 'selected' : ''}>Cash</option>
                                <option ${item.paymentMethod === 'QRIS' ? 'selected' : ''}>QRIS</option>
                                <option ${item.paymentMethod === 'Debit' ? 'selected' : ''}>Debit</option>
                                <option ${item.paymentMethod === 'Transfer' ? 'selected' : ''}>Transfer</option>
                            </select>
                        </div>
                        <div class="col-lg-5">
                            <input type="number" class="form-control" placeholder="Enter Amount" oninput="changeSplitPayment(${index}, 'amount', this.value)">
                        </div>
                        <div class="col-lg-1"><a class="btn btn-danger btn-sm" onclick="deleteSplitPayment('${index}')"><i class="fa fa-trash"></i></a></div>
                    </div>
                `;
            });

            document.getElementById('listSplitPayment').innerHTML = html;
        }

        function deleteSplitPayment(index) {
            const splitPayment = JSON.parse(localStorage.getItem('splitPayment')) ?? [];
            splitPayment.splice(index, 1);
            localStorage.setItem('splitPayment', JSON.stringify(splitPayment));
            viewSplitPayment();
        }

        function changeSplitPayment(index, type, value) {
            const splitPayment = JSON.parse(localStorage.getItem('splitPayment')) ?? [];
            const find = splitPayment[index];

            if (type === 'paymentMethod') {
                find.paymentMethod = value;
            } else {
                find.amount = parseInt(value);
            }

            localStorage.setItem('splitPayment', JSON.stringify(splitPayment));
        }

        function addSplitPayment() {
            const splitPayment = JSON.parse(localStorage.getItem('splitPayment')) ?? [];

            splitPayment.push({
                paymentMethod: '',
                amount: 0
            });

            localStorage.setItem('splitPayment', JSON.stringify(splitPayment));
            viewSplitPayment();
        }

        function splitPaymentProcess() {
            $('#splitPaymentModal').modal('hide');
        }

        function resetTransaction() {
            Swal.fire({
                title: "Are you sure?",
                text: "Reset Transaction",
                icon: "warning",
                showCancelButton: true,
                customClass: {
                    confirmButton: "btn btn-primary w-xs me-2 mt-2",
                    cancelButton: "btn btn-danger w-xs mt-2"
                },
                confirmButtonText: "Yes, Reset it!",
                buttonsStyling: false,
                showCloseButton: true
            }).then((i) => {
                if (i.value) {
                    window.location.reload();
                }
            });
        }

        function delivery() {
            const delivery = JSON.parse(localStorage.getItem('delivery')) ?? [];
            let html = '';

            delivery.forEach((item, index) => {
                html += `
                    <div class="col-4">
                        <a onclick="changeDelivery(${index})">
                            <div class="card p-2 text-center ${item.select === 1 ? 'card-discount' : ''}">
                                <span class="fw-bold">${item.name}</span>
                            </div>
                        </a>
                    </div>
                `;
            });

            document.getElementById('listDelivery').innerHTML = html;

            $('#deliveryModal').modal('show');
        }

        function changeDelivery(index) {
            const delivery = JSON.parse(localStorage.getItem('delivery')) ?? [];

            delivery.forEach((item) => {
                item.select = 0;
            });

            delivery[index].select = 1;
            localStorage.setItem('delivery', JSON.stringify(delivery));

            let html = '';
            delivery.forEach((item, index) => {
                html += `
                    <div class="col-4">
                        <a onclick="changeDelivery(${index})">
                            <div class="card p-2 text-center ${item.select === 1 ? 'card-discount' : ''}">
                                <span class="fw-bold">${item.name}</span>
                            </div>
                        </a>
                    </div>
                `;
            });

            document.getElementById('listDelivery').innerHTML = html;
        }

        function payment() {
            const splitPayment = JSON.parse(localStorage.getItem('splitPayment')) ?? [];
            const paymentMethod = JSON.parse(localStorage.getItem('paymentMethod')) ?? '';

            console.info(splitPayment);
            if (splitPayment.length === 0) {
                $.ajax({
                    url: '{{ route('pos.payment.method') }}',
                    method: 'GET',
                    success: (res) => {
                        const data = res.data;
                        let html = '<option>-- Choose Payment --</option>';

                        data.forEach((item) => {
                            html += `<option value="${item.name}" ${paymentMethod === item.name ? 'selected' : ''}>${item.name}</option>`;
                        });

                        document.getElementById('paymentMethod').innerHTML = html;
                    }
                });
            } else {
                const splitPayment = JSON.parse(localStorage.getItem('splitPayment')) ?? [];

                let html = '<option>-- Choose Payment --</option>';

                splitPayment.forEach((item) => {
                    html += `<option value="${item.paymentMethod}" ${paymentMethod === item.paymentMethod ? 'selected' : ''}>${item.paymentMethod}</option>`;
                });

                document.getElementById('paymentMethod').innerHTML = html;
            }

            $('#paymentModal').modal('show');
        }

        function changePaymentMethod(value) {
            localStorage.setItem('paymentMethod', JSON.stringify(value));
            $('#paymentModal').modal('hide');
        }

        function discountTransaction() {
            $.ajax({
                url: '{{ route('discount.find.transaction') }}',
                method: 'GET',
                success: (res) => {
                    const data = res.data;
                    const discount = JSON.parse(localStorage.getItem('discountTransaction')) ?? [];

                    if (discount.length === 0) {
                        const result = data.map(item => ({
                            ...item,
                            select: 0
                        }));
                        localStorage.setItem('discountTransaction', JSON.stringify(result));
                    }

                    viewDiscountTransaction();
                    $('#discountTransactionModal').modal('show');
                }
            });
        }

        function viewDiscountTransaction() {
            const discount = JSON.parse(localStorage.getItem('discountTransaction')) ?? [];
            let html = '';

            discount.forEach((item) => {
                html += `
                    <div class="col-3">
                        <a onclick="changeDiscountTransaction(${item.id})">
                            <div class="card p-3 ${item.select === 1 ? 'card-discount' : ''}">
                                <div>${item.code}</div>
                                <div class="fw-bold">${item.name}</div>
                                <div class="fw-bold">${item.type === 'nominal' ? 'Rp '+rupiah(item.value) : parseInt(item.value)+'%'}</div>
                            </div>
                        </a>
                    </div>
                `;
            });
            document.getElementById('discountTransaction').innerHTML = html;
        }

        function changeDiscountTransaction(value) {
            const discount = JSON.parse(localStorage.getItem('discountTransaction')) ?? [];
            discount.forEach((item) => {
                if (parseInt(item.id) === parseInt(value)) {
                    if (typeof item.select === 'undefined') {
                        item.select = 0;
                    }
                    item.select = item.select === 1 ? 0 : 1;
                }
            });
            localStorage.setItem('discountTransaction', JSON.stringify(discount));
            calculatePrice();
            viewDiscountTransaction();
        }

        function paymentProcess() {
            Swal.fire({
                title: "Are you sure?",
                text: "Process this order",
                icon: "warning",
                showCancelButton: true,
                customClass: {
                    confirmButton: "btn btn-primary w-xs me-2 mt-2",
                    cancelButton: "btn btn-danger w-xs mt-2"
                },
                confirmButtonText: "Yes, Process it!",
                buttonsStyling: false,
                showCloseButton: true
            }).then((i) => {
                if (i.value) {

                    // Validation
                    const cart = JSON.parse(localStorage.getItem('cart')) ?? [];
                    if (cart.length === 0) {
                        Swal.fire({
                           title: 'Warning!',
                           text: 'Cart cannot be empty, please select the product',
                           icon: 'warning',
                        });
                        return true;
                    }

                    const paymentMethod = JSON.parse(localStorage.getItem('paymentMethod')) ?? ''
                    if (paymentMethod === '') {
                        Swal.fire({
                            title: 'Warning!',
                            text: 'Payment method cannot be empty',
                            icon: 'warning',
                        });
                        return true;
                    }

                    const splitPayment = JSON.parse(localStorage.getItem('splitPayment')) ?? [];
                    if (splitPayment.length !== 0) {
                        // Split Payment
                        const grandTotal = parseInt(JSON.parse(localStorage.getItem('grandTotal')) ?? 0);
                        let totalSplit = 0;
                        splitPayment.forEach((item) => {
                            totalSplit += item.amount;
                        });

                        if (grandTotal !== totalSplit) {
                            Swal.fire({
                                title: 'Warning!',
                                text: 'The nominal split payment does not match the total transaction.',
                                icon: 'warning',
                            });
                            return true;
                        }
                    }

                    saveTransactionData();

                    $.ajax({
                        url: '{{ route('transaction.store') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            cart: cart,
                            discountTransaction: JSON.parse(localStorage.getItem('discountTransaction')) ?? [],
                            note: JSON.parse(localStorage.getItem('note')) ?? '',
                            paymentMethod: paymentMethod,
                            splitPayment: splitPayment,
                            invoice: '{{ $invoiceNumber }}',
                            delivery: document.getElementById('delivery').value,
                            subTotal: JSON.parse(localStorage.getItem('subTotal')) ?? 0,
                            totalTax: JSON.parse(localStorage.getItem('totalTax')) ?? 0,
                            discount: JSON.parse(localStorage.getItem('discount')) ?? 0,
                            grandTotal: JSON.parse(localStorage.getItem('grandTotal')) ?? 0,
                        },
                        beforeSend: function () {
                            Swal.fire({
                                title: 'Processing Payment...',
                                text: 'Please wait a moment',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                        },
                        success: (res) => {
                            Swal.close();

                            if (res.status) {
                                if (paymentMethod === 'Debit') {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: 'Debit payment has been created successfully.',
                                        icon: 'success',
                                    }).then((i) => {
                                        document.getElementById('buttonAfterProcess').innerHTML = `
                                            <a class="btn btn-secondary w-100 mb-2" onclick="printNota()">
                                                <i class="ti ti-printer me-2"></i>Print Invoice
                                            </a>
                                            <a class="btn btn-orange w-100 mb-2" onclick="debitPaymentNumber()">
                                                <i class="ti ti-printer me-2"></i> Debit Payment Number
                                            </a>
                                        `;
                                        $('#paymentDebitModal').modal('show');
                                    });
                                } else if (paymentMethod === 'QRIS') {
                                    const midtrans = res.data.raw;
                                    localStorage.setItem('midtrans', JSON.stringify(midtrans));

                                    document.getElementById('buttonAfterProcess').innerHTML = `
                                        <a class="btn btn-secondary w-100 mb-2" onclick="printNota()">
                                            <i class="ti ti-printer me-2"></i>Print Invoice
                                        </a>
                                        <a class="btn btn-orange w-100 mb-2" onclick="viewQrisModal()">
                                            <i class="ti ti-printer me-2"></i> QRIS Status
                                        </a>
                                    `;

                                    viewQrisModal();
                                } else {
                                    document.getElementById('buttonAfterProcess').innerHTML = `
                                        <a class="btn btn-secondary w-100 mb-2" onclick="printNota()">
                                            <i class="ti ti-printer me-2"></i>Print Invoice
                                        </a>
                                    `;
                                    Swal.fire({
                                        title: 'Success!',
                                        text: 'Transaction has been created successfully.',
                                        icon: 'success',
                                    });
                                }

                                document.getElementById('changePayment').innerHTML = `
                                    <a class="btn btn-danger d-flex align-items-center justify-content-center w-100 mb-2" onclick="resetTransaction()"><i class="ti ti-reload me-2"></i>Reset</a>
                                    <a class="btn btn-cyan d-flex align-items-center justify-content-center w-100 mb-2" onclick="changePayment()"><i  class="ti ti-cash-banknote me-2"></i>Change Payment</a>
                                `;
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Failed to create transaction.',
                                    icon: 'error',
                                });
                            }
                        },
                        error: (xhr, status, error) => {
                            Swal.close();
                            Swal.fire({
                                title: 'Unexpected Error!',
                                text: error || 'Server did not respond properly.',
                                icon: 'error',
                            });
                        }
                    });
                }
            });
        }

        function changePayment() {
            $('#changePaymentModal').modal('show');
        }

        function processChangePayment() {
            const paymentMethod = document.getElementById('changePayment').value;
            if (paymentMethod === '') {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Please select payment method!',
                    icon: 'warning',
                });

                return true;
            }

            switch (paymentMethod) {
                case 'Cash':
                case 'Transfer':
                    $.ajax({
                        url: '{{ route('pos.payment.method.change') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            paymentMethod: paymentMethod,
                            invoice: '{{ $invoiceNumber }}',
                        },
                        success: (res) => {
                            if (res.status) {
                                $('#changePaymentModal').modal('hide');
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Change Payment Transaction Success',
                                    icon: 'success',
                                });
                            }
                        }
                    });
                    break;
                case 'QRIS':
                    $.ajax({
                        url: '{{ route('pos.payment.method.change') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            paymentMethod: paymentMethod,
                            invoice: '{{ $invoiceNumber }}',
                        },
                        success: (res) => {
                            const midtrans = res.data.raw;
                            localStorage.setItem('midtrans', JSON.stringify(midtrans));

                            document.getElementById('buttonAfterProcess').innerHTML = `
                                        <a class="btn btn-secondary w-100 mb-2" onclick="printNota()">
                                            <i class="ti ti-printer me-2"></i>Print Invoice
                                        </a>
                                        <a class="btn btn-orange w-100 mb-2" onclick="viewQrisModal()">
                                            <i class="ti ti-printer me-2"></i> QRIS Status
                                        </a>
                                    `;

                            viewQrisModal();
                        }
                    });
                    break;
                case 'Debit':
                    $('#changePaymentDebitModal').modal('show');
                    break;
            }
        }

        function changePaymentSaveApprovalCode() {
            $.ajax({
                url: '{{ route('pos.payment.method.change') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    paymentMethod: 'Debit',
                    invoice: '{{ $invoiceNumber }}',
                    approvalCodeChangePayment: document.getElementById('approvalCodeChangePayment').value
                },
                success: (res) => {
                    if (res.status) {
                        $('#changePaymentModal').modal('hide');
                        Swal.fire({
                            title: 'Success!',
                            text: 'Change Payment Transaction Success',
                            icon: 'success',
                        });
                    }
                }
            });
        }

        function viewQrisModal() {
            const midtrans = JSON.parse(localStorage.getItem('midtrans')) ?? [];

            const qrString = midtrans.qr_string ?? null;
            const nominal = JSON.parse(localStorage.getItem('grandTotal')) ?? 0;

            if (qrString) {
                const modal = new bootstrap.Modal(document.getElementById('modalQris'));
                modal.show();

                document.getElementById('qrisAmount').innerText = 'Rp ' + rupiah(nominal);
                const canvas = document.getElementById('qrisCanvas');
                new QRious({
                    element: canvas,
                    value: qrString,
                    size: 250
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: 'QRIS data is not available. Please check API response.',
                    icon: 'error',
                });
            }
        }

        function saveTransactionData() {
            $.ajax({
                url: '{{ route('transaction.data.store') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    invoiceNumber: '{{ $invoiceNumber }}',
                    cart: JSON.parse(localStorage.getItem('cart')) ?? [],
                    discountTransaction: JSON.parse(localStorage.getItem('discountTransaction')) ?? [],
                    paymentMethod: JSON.parse(localStorage.getItem('paymentMethod')) ?? [],
                    splitPayment: JSON.parse(localStorage.getItem('splitPayment')) ?? [],
                },
                success: (res) => {

                }
            });
        }

        function debitPaymentNumber() {
            $('#paymentDebitModal').modal('show');
        }

        function saveApprovalCode() {
            const approvalCode = document.getElementById('approvalCode').value;

            $.ajax({
                url: '{{ route('transaction.create.payment') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    reffId: approvalCode,
                    invoiceNumber: '{{ $invoiceNumber }}',
                    data: approvalCode,
                    paymentMethodId: 3
                },
                success: (res) => {
                    if (res.status) {
                        document.getElementById('approvalCode').value = '';
                        $('#paymentDebitModal').modal('hide');
                        Swal.fire({
                            title: 'Success!',
                            text: 'Payment Transaction Successfully!',
                            icon: 'success',
                        });
                    }
                }
            });
        }

        async function printNota() {
            try {
                if (!qz.websocket.isActive()) {
                    await qz.websocket.connect({host: 'localhost', usingSecure: false});
                }

                // Pakai nama printer hasil find() atau default
                const matches = await qz.printers.find("HaoYin"); // atau "CX588"/"POS"/"58"
                const printerName = matches[0] || await qz.printers.getDefault();

                // PENTING: altPrinting:true untuk macOS (raw pass-through)
                const cfg = qz.configs.create(printerName, {
                    altPrinting: true,     // <-- ini kuncinya di Mac
                    // encoding: 'CP437',  // opsional; CX588 default-nya CP437/GBK
                });

                const ESC = '\x1B', GS = '\x1D';
                const lines = [
                    ESC + "@", ESC + "a" + "\x01", "KEDAI SELVIN\n", "Solo\n\n",
                    ESC + "a" + "\x00",
                    "Americano  x1      18.000\n",
                    "Croissant  x1      12.000\n",
                    "---------------------------\n",
                    "Total               30.000\n",
                    "Metode: DEBIT\n",
                    "Approval: 749832\n",
                    "Last4  : 1234\n",
                    "\n\n\n" // feed beberapa baris (tanpa auto-cutter, kertas perlu didorong)
                    // GS+"V"+"\x00" // cutter jika ada auto-cutter (banyak 58mm portable tidak)
                ];

                await qz.print(cfg, lines);
                alert("Print dikirim (RAW)");
            } catch (e) {
                console.error(e);
                alert("Print gagal: " + (e.message || e));
            }
        }

        async function tesPrint() {
            if (!qz.websocket.isActive()) await qz.websocket.connect();
            const list = await qz.printers.find();
            console.log('Printers:', list);
        }
    </script>

    <script>
        function updateWaktuIndonesia() {
            const sekarang = new Date();
            const opsi = {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                hour12: false,
                timeZone: 'Asia/Jakarta'
            };

            document.getElementById('waktuSekarang').textContent = new Intl.DateTimeFormat('id-ID', opsi).format(sekarang);
        }

        updateWaktuIndonesia();
        setInterval(updateWaktuIndonesia, 1000 * 30);

        document.addEventListener('DOMContentLoaded', function () {
            document.body.classList.add('mini-sidebar');
        });
    </script>
@endsection

















