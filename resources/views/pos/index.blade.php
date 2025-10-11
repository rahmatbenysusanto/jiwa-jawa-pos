@extends('layout.index')
@section('title', 'POS')

@section('content')
    <div class="row align-items-start pos-wrapper">

        <div class="col-md-12 col-lg-7 col-xl-8">
            <div class="pos-categories tabs_wrapper">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
                    <div>
                        <h5 class="mb-1">Welcome,  Wesley Adrian</h5>
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
                            <a class="btn btn-teal d-flex align-items-center justify-content-center w-100 mb-2"><i  class="ti ti-percentage me-2"></i>Discount</a>
                            <a class="btn btn-orange d-flex align-items-center justify-content-center w-100 mb-2" onclick="addNote()"><i  class="ti ti-file-description me-2"></i>Note</a>
                        </div>
                        <div class="col-sm-4">
                            <a class="btn btn-purple d-flex align-items-center justify-content-center w-100 mb-2"><i  class="ti ti-receipt-tax me-2"></i>Split Payment</a>
                            <a class="btn btn-info d-flex align-items-center justify-content-center w-100 mb-2"><i  class="ti ti-map-pin-check me-2"></i>Delivery</a>
                        </div>
                        <div class="col-sm-4">
                            <a class="btn btn-indigo d-flex align-items-center justify-content-center w-100 mb-2"><i class="ti ti-reload me-2"></i>Reset</a>
                            <a class="btn btn-cyan d-flex align-items-center justify-content-center w-100 mb-2"><i  class="ti ti-cash-banknote me-2"></i>Payment</a>
                        </div>
                    </div>
                </div>
                <div class="block-section payment-method">
                    <h5 class="mb-2">Select Payment</h5>
                    <div class="row align-items-center justify-content-center methods g-2 mb-4">
                        <div class="col-sm-6 col-md-4 col-xl d-flex">
                            <a href="javascript:void(0);" class="payment-item flex-fill" data-bs-toggle="modal" data-bs-target="#payment-cash">
                                <img src="assets/img/icons/cash-icon.svg" alt="img">
                                <p class="fw-medium">Cash</p>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-4 col-xl d-flex">
                            <a href="javascript:void(0);" class="payment-item flex-fill" data-bs-toggle="modal" data-bs-target="#payment-card">
                                <img src="assets/img/icons/card.svg" alt="img">
                                <p class="fw-medium">Card</p>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-4 col-xl d-flex">
                            <a href="javascript:void(0);" class="payment-item flex-fill" data-bs-toggle="modal" data-bs-target="#payment-points">
                                <img src="assets/img/icons/points.svg" alt="img">
                                <p class="fw-medium">Points</p>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-4 col-xl d-flex">
                            <a href="javascript:void(0);" class="payment-item flex-fill" data-bs-toggle="modal" data-bs-target="#payment-deposit">
                                <img src="assets/img/icons/deposit.svg" alt="img">
                                <p class="fw-medium">Deposit</p>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-4 col-xl d-flex">
                            <a href="javascript:void(0);" class="payment-item flex-fill" data-bs-toggle="modal" data-bs-target="#payment-cheque">
                                <img src="assets/img/icons/cheque.svg" alt="img">
                                <p class="fw-medium">Cheque</p>
                            </a>
                        </div>
                    </div>
                    <div class="btn-block m-0">
                        <a class="btn btn-teal w-100" onclick="paymentProcess()">
                            Pay : Rp 0
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <div id="productDetailModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
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

                    <div class="d-flex justify-content-between align-items-center mb-2">
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
                </div>
                <div class="modal-footer gap-2">
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addProduct()">Add Product</button>
                </div>
            </div>
        </div>
    </div>

    <div id="addonModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Addon Product</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Addon List</label>
                        <select class="form-control" id="addon-list" onchange="changeAddonList(this.value)">

                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Addon Variant</label>
                        <select class="form-control" id="addon-variant">

                        </select>
                    </div>
                </div>
                <div class="modal-footer gap-2">
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addProductAddon()">Add</button>
                </div>
            </div>
        </div>
    </div>

    <div id="editProductCartModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
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

                    <div class="d-flex justify-content-between align-items-center mb-2">
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
                    <div class="mb-3">
                        <label class="form-label">Addon List</label>
                        <select class="form-control" id="addon-edit-list" onchange="changeAddonEditList(this.value)">

                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Addon Variant</label>
                        <select class="form-control" id="addon-edit-variant">

                        </select>
                    </div>
                </div>
                <div class="modal-footer gap-2">
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addProductAddonEdit()">Add</button>
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
@endsection

@section('js')
    <script>
        localStorage.clear();
        loadAllMenu();
        document.getElementById('cartValue').style.display = 'none';

        function rupiah(angka) {
            return new Intl.NumberFormat('id-ID').format(angka);
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
                                    <div class="card mb-0" style="padding:10px;">
                                        <a class="product-image">
                                            <img src="{{ asset('assets/img/products/pos-product-02.jpg')}}" alt="Products">
                                        </a>
                                        <div class="product-content">
                                            <h6 class="fs-14 fw-bold mb-1"><a>${product.name}</a></h6>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h6 class="text-teal fs-14 fw-bold">Rp ${rupiah(product.price)}</h6>
                                                <p class="text-pink">25 Pcs</p>
                                            </div>
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
                                    <div class="card mb-0" style="padding:10px;">
                                        <a class="product-image">
                                            <img src="{{ asset('assets/img/products/pos-product-02.jpg')}}" alt="Products">
                                        </a>
                                        <div class="product-content">
                                            <h6 class="fs-14 fw-bold mb-1"><a>${product.name}</a></h6>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h6 class="text-teal fs-14 fw-bold">Rp ${rupiah(product.price)}</h6>
                                                <p class="text-pink">25 Pcs</p>
                                            </div>
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
                data:{
                    id: productId,
                },
                success: (res) => {
                    const product = res.data;

                    localStorage.setItem('product', JSON.stringify({
                        id: product.id,
                        name: product.name,
                        price: parseInt(product.price),
                        sku: product.sku,
                        category: product.category.name,
                        combo: product.is_combo
                    }));

                    // Variant Product
                    let dataVariant = [];
                    let html = '';
                    (product.menu_variant).forEach((variant, indexVariant) => {
                        let valueVariant = [];
                        let option = '';
                        (variant.menu_variant_options).forEach((item) => {
                            option += `
                                <option value=${item.id} ${item.is_default === 1 ? 'selected' : ''}>${item.name} | ${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(item.price_delta)}</option>
                            `

                            valueVariant.push({
                                id:item.id,
                                name: item.name,
                                price: parseFloat(item.price_delta),
                                select: item.is_default
                            });
                        });

                        dataVariant.push({
                            id: variant.id,
                            name: variant.name,
                            option: valueVariant,
                        });

                        html += `
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">${variant.name}</label>
                                    <select class="form-control" onchange="changeVariant(${indexVariant}, this.value)">
                                        ${option}
                                    </select>
                                </div>
                            </div>
                        `;
                    });

                    localStorage.setItem('variant', JSON.stringify(dataVariant));

                    document.getElementById('listVariantProduct').innerHTML = html;
                    document.getElementById('product-detail-id').value = product.id;
                    document.getElementById('product-detail-name').value = product.name;
                    document.getElementById('product-detail-sku').value = product.sku;
                    document.getElementById('product-detail-base-price').value =(new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(product.price));
                    document.getElementById('product-detail-category').value = product.category.name;
                    viewListAddon();
                    $('#productDetailModal').modal('show');
                }
            });
        }

        function changeVariant(index, value) {
            const variant = JSON.parse(localStorage.getItem('variant')) ?? [];
            const find = variant[index];

            (find.option).forEach((option) => {
                if (parseInt(option.id) === parseInt(value)) {
                    option.select = 1;
                } else {
                    option.select = 0;
                }
            });

            localStorage.setItem('variant', JSON.stringify(variant));
        }

        function openAddonModal() {
            $.ajax({
                url: '{{ route('pos.addon') }}',
                method: 'GET',
                success: (res) => {
                    const data = res.data;
                    let html = '<option value="">-- Choose Addon --</option>';

                    data.forEach((item) => {
                        html += `<option value="${item.id}">${item.name}</option>`;
                    });

                    document.getElementById('addon-list').innerHTML = html;
                    document.getElementById('addon-variant').innerHTML = '<option value="">-- Choose Variant --</option>';
                    $('#addonModal').modal('show');
                }
            });
        }

        function changeAddonList(id) {
            $.ajax({
                url: '{{ route('pos.addon.find') }}',
                method: 'GET',
                data: {
                    id: id
                },
                success: (res) => {
                    const data = res.data;
                    let html = '<option value="">-- Choose Variant --</option>';

                    data.forEach((item) => {
                        html += `<option value="${item.id}">${item.name} | Rp ${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(item.price)}</option>`;
                    });

                    document.getElementById('addon-variant').innerHTML = html;
                }
            });
        }

        function addProductAddon() {
            const addonVariantId = document.getElementById('addon-variant').value;
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
                        <td>${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(item.price)}</td>
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
                        <td>${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(item.total)}</td>
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

            const totalPrice = parseInt(product.price) + priceDelta + priceAddon;

            cart.push({
                menuId: product.id,
                name: product.name,
                qty: 1,
                basePrice: parseInt(product.price),
                priceDelta: priceDelta,
                priceAddon: priceAddon,
                totalPrice: totalPrice,
                grandTotal: totalPrice,
                data: {
                    product: product,
                    variant: variant,
                    addon: addon,
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
                    html += `
                         <tr>
                            <td>
                                <div class="d-flex align-items-center mb-1">
                                    <h6 class="fs-16 fw-medium"><a onclick="editProductCart(${index})">${item.name}</a></h6>
                                    <a class="ms-2 edit-icon" onclick="editProductCart(${index})"><i class="ti ti-edit"></i></a>
                                </div>
                                Price : ${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(item.totalPrice)}
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
                            <td class="fw-bold">${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(item.grandTotal)}</td>
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
                find.qty += 1;
                find.grandTotal += find.totalPrice;
            } else {
                if (parseInt(find.qty) !== 1) {
                    find.qty -= 1;
                    find.grandTotal -= find.totalPrice;
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
            const cart = JSON.parse(localStorage.getItem('cart')) ?? [];
            const find = cart[index];
            const product = find.data.product;
            const variant = find.data.variant;
            const addon = find.data.addon;

            // Data Product
            document.getElementById('product-edit-id').value = product.id;
            document.getElementById('product-edit-name').value = product.name;
            document.getElementById('product-edit-category').value = product.category;
            document.getElementById('product-edit-sku').value = product.sku;
            document.getElementById('product-edit-base-price').value = product.price;

            // Data Variant
            let variantHtml = '';
            variant.forEach((item, indexVariant) => {
                let variantOptionHtml = '';

                (item.option).forEach((option) => {
                    variantOptionHtml += `<option value="${option.id}" ${option.select === 1 ? 'selected' : ''}>${option.name} | ${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(option.price)}</option>`;
                });

                variantHtml += `
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label">${item.name}</label>
                            <select class="form-control" onchange="changeVariantEdit(${indexVariant}, this.value)">
                                ${variantOptionHtml}
                            </select>
                        </div>
                    </div>
                `;
            });
            document.getElementById('listVariantProductEdit').innerHTML = variantHtml;
            localStorage.setItem('variant', JSON.stringify(variant));

            // Data Addon
            localStorage.setItem('addon', JSON.stringify(addon));
            viewAddonEdit();

            $('#editProductCartModal').modal('show');
        }

        function viewAddonEdit() {
            const addon = JSON.parse(localStorage.getItem('addon')) ?? [];
            let html = '';

            addon.forEach((item, index) => {
                html += `
                    <tr>
                        <td>${item.name}</td>
                        <td>${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(item.price)}</td>
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
                        <td>${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(item.total)}</td>
                        <td><a class="btn btn-danger btn-sm" onclick="deleteAddon(${index})"><i class="fa fa-trash"></a></td>
                    </tr>
                `;
            });

            document.getElementById('viewListAddonEdit').innerHTML = html;
        }

        function openAddonEditModal() {
            $.ajax({
                url: '{{ route('pos.addon') }}',
                method: 'GET',
                success: (res) => {
                    const data = res.data;
                    let html = '<option value="">-- Choose Addon --</option>';

                    data.forEach((item) => {
                        html += `<option value="${item.id}">${item.name}</option>`;
                    });

                    document.getElementById('addon-edit-list').innerHTML = html;
                    document.getElementById('addon-edit-variant').innerHTML = '<option value="">-- Choose Variant --</option>';
                    $('#addonEditModal').modal('show');
                }
            });
        }

        function changeAddonEditList(id) {
            $.ajax({
                url: '{{ route('pos.addon.find') }}',
                method: 'GET',
                data: {
                    id: id
                },
                success: (res) => {
                    const data = res.data;
                    let html = '<option value="">-- Choose Variant --</option>';

                    data.forEach((item) => {
                        html += `<option value="${item.id}">${item.name} | Rp ${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(item.price)}</option>`;
                    });

                    document.getElementById('addon-edit-variant').innerHTML = html;
                }
            });
        }

        function addProductAddonEdit() {
            const addonVariantId = document.getElementById('addon-edit-variant').value;
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

        function changeVariantEdit(index, value) {
            const variant = JSON.parse(localStorage.getItem('variant')) ?? [];
            const find = variant[index];

            (find.option).forEach((option) => {
                if (parseInt(option.id) === parseInt(value)) {
                    option.select = 1;
                } else {
                    option.select = 0;
                }
            });

            localStorage.setItem('variant', JSON.stringify(variant));
        }

        function editProduct() {
            const cart = JSON.parse(localStorage.getItem('cart')) ?? [];
            const variant = JSON.parse(localStorage.getItem('variant')) ?? [];
            const addon = JSON.parse(localStorage.getItem('addon')) ?? [];
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

            const totalPrice = parseInt(product.basePrice) + priceDelta + priceAddon;

            product.priceDelta = priceDelta;
            product.priceAddon = priceAddon;
            product.totalPrice = totalPrice;
            product.grandTotal = totalPrice * product.qty;
            product.data = {
                variant: variant,
                addon: addon,
                product: product.data.product
            }

            localStorage.setItem('cart', JSON.stringify(cart));
            $('#editProductCartModal').modal('hide');
            viewChartList();
        }

        function calculatePrice() {
            const cart = JSON.parse(localStorage.getItem('cart')) ?? [];
            let subTotal = 0;
            let totalTax = 0;
            let discount = 0;
            let grandTotal = 0;

            cart.forEach((item) => {
                subTotal += item.totalPrice * item.qty;
            });

            totalTax = (subTotal - discount) * 0.11;

            grandTotal = subTotal + totalTax;

            document.getElementById('subTotal').innerText = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(subTotal);
            document.getElementById('totalTax').innerText = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(totalTax);
            document.getElementById('grandTotal').innerText = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(grandTotal);
            document.getElementById('buttonPay').innerText = 'Pay : '+new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(grandTotal);
        }

        function calculateJumlahCart() {
            const cart = JSON.parse(localStorage.getItem('cart')) ?? [];
            let items = 0;

            cart.forEach((item) => {
                items += item.qty;
            });

            document.getElementById('jumlahCart').innerText = items;
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

                }
            });
        }
    </script>

    <script>
        function addNote() {
            document.getElementById('note').value = JSON.parse(localStorage.getItem('note')) ?? '';

            $('#noteModal').modal('show');
        }

        function saveNote() {
            const note = document.getElementById('note').value;
            localStorage.setItem('note', JSON.stringify(note));
            $('#noteModal').modal('hide');
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
    </script>
@endsection

















