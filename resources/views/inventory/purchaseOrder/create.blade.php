@extends('layout.index')
@section('title', 'Create Purchase Order')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Create Purchase Order</h4>
            </div>
        </div>
        <div class="page-btn">
            <a class="btn btn-primary" onclick="createPurchaseOrder()">
                <i class="ti ti-circle-plus me-1"></i>
                Create Purchase Order
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Material</label>
                            <select class="form-control" id="material">
                                <option value="">-- Choose Material --</option>
                                @foreach($material as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-white">-</label>
                            <div>
                                <a class="btn btn-info" onclick="addMaterial()">Add Material</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">List Material PO</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>SKU</th>
                                    <th>Name</th>
                                    <th>QTY</th>
                                    <th>Unit</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="listMaterialPO">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        localStorage.clear();

        function addMaterial() {
            $.ajax({
                url: '{{ route('inventory.purchase.order.find.material') }}',
                method: 'GET',
                data: {
                    id: document.getElementById('material').value
                },
                success: (res) => {
                    const data = res.data;
                    const material = JSON.parse(localStorage.getItem('material')) ?? [];

                    const checkMaterial = material.find((item) => parseInt(item.id) === parseInt(data.id));
                    if (checkMaterial) {
                        Swal.fire({
                            title: 'Warning!',
                            text: 'Material is already in the PO list',
                            icon: 'warning',
                        });

                        return true;
                    }

                    material.push({
                        id: data.id,
                        name: data.name,
                        sku: data.sku,
                        qty: 1,
                        unit: data.unit.symbol,
                    });

                    localStorage.setItem('material', JSON.stringify(material));
                    viewListMaterialPO();
                }
            });
        }

        function viewListMaterialPO() {
            const material = JSON.parse(localStorage.getItem('material')) ?? [];
            let html = '';

            material.forEach((item, index) => {
                html += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.sku}</td>
                        <td>${item.name}</td>
                        <td><input type="number" class="form-control" value="${item.qty}" onchange="changeQTY(${index}, this.value)"></td>
                        <td>${item.unit}</td>
                        <td><a class="btn btn-danger btn-sm" onclick="deleteMaterial(${index})"><i class="fa fa-trash"></i></a></td>
                    </tr>
                `;
            });

            document.getElementById('listMaterialPO').innerHTML = html;
        }

        function changeQTY(index, qty) {
            const material = JSON.parse(localStorage.getItem('material')) ?? [];

            material[index].qty = qty;
            localStorage.setItem('material', JSON.stringify(material));
        }

        function deleteMaterial(index) {
            const material = JSON.parse(localStorage.getItem('material')) ?? [];
            material.splice(index, 1);
            localStorage.setItem('material', JSON.stringify(material));
            viewListMaterialPO();
        }

        function createPurchaseOrder() {
            Swal.fire({
                title: 'Are you sure?',
                text: "Create Purchase Order?",
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

                    $.ajax({
                        url: '{{ route('inventory.purchase.order.store') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            material: JSON.parse(localStorage.getItem('material')) ?? [],
                        },
                        success: (res) => {
                            if (res.status) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Purchase Order created successfully!',
                                    icon: 'success',
                                }).then((i) => {
                                    window.location.href = '{{ route('inventory.purchase.order') }}';
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: res.message,
                                    icon: 'error',
                                });
                            }
                        }
                    });

                }
            });
        }
    </script>
@endsection