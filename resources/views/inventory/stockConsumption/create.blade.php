@extends('layout.index')
@section('title', 'Create Stock Consumption')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Stock Consumption</h4>
            </div>
        </div>
        <div class="page-btn">
            <a class="btn btn-primary">
                <i class="ti ti-circle-plus me-1"></i>
                Create Stock Consumption
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-end align-items-center">
                        <a class="btn btn-info" onclick="addMaterial()">Add Material</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>SKU</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>QTY</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="listMaterial">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <label class="form-label">Note</label>
                    <textarea class="form-control" rows="3"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addMaterialModal">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="page-title">
                        <h4>Material</h4>
                    </div>
                    <button type="button" class="close bg-danger text-white fs-16" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>SKU</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="materialModal"></tbody>
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

        function loadMaterial() {
            const dataMaterial = @json($material);
            const material = [];

            dataMaterial.forEach(material => {
                material.push({
                    id: material.id,
                    sku: material.sku,
                    name: material.name,
                    category: material.category.name,
                });
            });
        }

        function addMaterial() {


            $('#addMaterialModal').modal('show');
        }
    </script>
@endsection