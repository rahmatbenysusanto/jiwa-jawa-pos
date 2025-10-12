@extends('layout.index')
@section('title', 'Create Discount')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Create Discount</h4>
            </div>
        </div>
        <div class="page-btn">
            <a class="btn btn-primary" onclick="createDiscount()">
                <i class="ti ti-circle-plus me-1"></i>
                Create Discount
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('discount.store') }}" method="POST" id="formDiscount">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Discount Name ..." required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="scope">Scope</label>
                                    <select class="form-control" name="scope" id="scope" onchange="changeScope(this.value)" required>
                                        <option value="">-- Choose Scope --</option>
                                        <option>Transaction</option>
                                        <option>Product</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="value">Discount</label>
                                    <input type="number" class="form-control" id="value" name="value" placeholder="0" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="start_date">Start Date</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="min_tra_amount">Min Transaction Amount</label>
                                    <input type="number" class="form-control" id="min_tra_amount" name="min_transaction_amount" placeholder="Rp 0">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="code">Code</label>
                                    <input type="text" class="form-control" id="code" name="code" placeholder="Discount Code ...">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="type">Type</label>
                                    <select class="form-control" name="type" id="type" required>
                                        <option value="">-- Choose Type --</option>
                                        <option>Percentage</option>
                                        <option>Nominal</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="value_max">Discount Max</label>
                                    <input type="number" class="form-control" id="value_max" name="value_max" placeholder="Rp 0">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="end_date">End Date</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date">
                                </div>
                            </div>

                            <div class="col-6" id="formProduct" style="display: none">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4>Menu Discount</h4>
                                    <a class="btn btn-indigo btn-sm" onclick="addMenu()">Add Menu</a>
                                </div>
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>SKU</th>
                                            <th>Menu</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="listMenuDiscount">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="menuModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">List Menu</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>SKU</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="listMenuModal">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        localStorage.clear();

        function changeScope(value) {
            if (value === 'Product') {
                document.getElementById('formProduct').style.display = 'block';
            } else {
                document.getElementById('formProduct').style.display = 'none';
            }
        }

        function addMenu() {
            $.ajax({
                url: '{{ route('menu.find.all') }}',
                method: 'GET',
                success: (res) => {
                    const data = res.data;
                    let html = '';

                    data.forEach((item, index) => {
                        html += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${item.sku}</td>
                                <td>${item.name}</td>
                                <td>${item.category.name}</td>
                                <td><a class="btn btn-info btn-sm" onclick="selectMenu(${item.id})">Select Menu</a></td>
                            </tr>
                        `;
                    });

                    document.getElementById('listMenuModal').innerHTML = html;
                    $('#menuModal').modal('show');
                }
            });
        }

        function selectMenu(id) {
            $.ajax({
                url: '{{ route('pos.product.find') }}',
                method: 'GET',
                data: {
                    id: id,
                },
                success: (res) => {
                    const data = res.data;

                    const menu = JSON.parse(localStorage.getItem('menu')) ?? [];
                    const check = menu.find(item => item.sku === data.sku);
                    if (check) {
                        Swal.fire({
                            title: 'Warning!',
                            text: 'Menu is already in the list',
                            icon: 'warning',
                        });

                        return true;
                    } else {
                        menu.push({
                            id: data.id,
                            sku: data.sku,
                            name: data.name,
                        });
                    }

                    localStorage.setItem('menu', JSON.stringify(menu));
                    viewMenuList();
                    $('#menuModal').modal('hide');
                }
            });
        }

        function viewMenuList() {
            const menu = JSON.parse(localStorage.getItem('menu')) ?? [];
            let html = '';

            menu.forEach((item, index) => {
                html += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>
                            ${item.sku}
                            <input type="hidden" name="menu[]" value="${item.id}">
                        </td>
                        <td>${item.name}</td>
                        <td><a class="btn btn-danger btn-sm" onclick="deleteMenu(${index})"><i class="fa fa-trash"></i></a></td>
                    </tr>
                `;
            });

            document.getElementById('listMenuDiscount').innerHTML = html;
        }

        function deleteMenu(index) {
            const menu = JSON.parse(localStorage.getItem('menu')) ?? [];
            menu.splice(index, 1);
            localStorage.setItem('menu', JSON.stringify(menu));
            viewMenuList();
        }

        function createDiscount() {
            Swal.fire({
                title: 'Are you sure?',
                text: "Create New Discount?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "Yes, create it!",
                cancelButtonText: "Cancel",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-danger ml-1"
                },
                buttonsStyling: false
            }).then(function (result) {
                if (result.isConfirmed) {
                    document.getElementById('formDiscount').submit();
                }
            });
        }
    </script>
@endsection






























