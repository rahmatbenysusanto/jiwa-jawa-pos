@extends('layout.index')
@section('title', 'Edit Material')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Edit Material</h4>
            </div>
        </div>
        <div class="page-btn">
            <a class="btn btn-primary" onclick="createMaterial()">
                <i class="ti ti-circle-plus me-1"></i>
                Update Material
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <form action="{{ route('inventory.material.update') }}" method="POST" enctype="multipart/form-data" id="createMaterialProcess">
                @csrf
                <input type="hidden" value="{{ $material->id }}" name="id">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Material Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Category</label>
                                    <select class="form-control" name="category" id="category" required>
                                        <option value="">-- Choose Category --</option>
                                        @foreach($category as $item)
                                            <option value="{{ $item->id }}" {{ $material->category_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $material->name }}" placeholder="Name material ..." required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Price</label>
                                    <input type="number" class="form-control" id="price" name="price" value="{{ (int)$material->price }}" placeholder="Rp 0 ..." required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">SKU</label>
                                    <input type="text" class="form-control" id="sku" name="sku" value="{{ $material->sku }}" placeholder="SKU ..." required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Min Stock</label>
                                    <input type="number" class="form-control" id="min_stock" name="min_stock" value="{{ (int)$material->min_stock }}" placeholder="Min Stock ..." required>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" rows="3" id="desc" name="desc">{{ $material->description }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Unit Conversion</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="mb-3">
                                    <label class="form-label">Unit</label>
                                    <select class="form-control" id="unit" name="unit">
                                        <option value="">-- Choose Unit --</option>
                                        @foreach($unit as $item)
                                            <option value="{{ $item->id }}" {{ $material->unit_id == $item->id ? 'selected' : '' }}>{{ $item->name }} | {{ $item->symbol }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label class="form-label">Base Unit</label>
                                    <select class="form-control" id="base_unit" name="base_unit">
                                        <option value="">-- Choose Base Unit --</option>
                                        @foreach($unit as $item)
                                            <option value="{{ $item->id }}" {{ $material->base_unit_id == $item->id ? 'selected' : '' }}>{{ $item->name }} | {{ $item->symbol }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label class="form-label">Conversion Value</label>
                                    <input type="number" class="form-control" id="conversion" value="{{ (int)$material->conversion_value }}" name="conversion" required placeholder="1000">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function createMaterial() {
            Swal.fire({
                title: 'Are you sure?',
                text: "Update Material?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "Yes, update it!",
                cancelButtonText: "Cancel",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-danger ml-1"
                },
                buttonsStyling: false
            }).then(function (result) {
                if (result.isConfirmed) {
                    document.getElementById('createMaterialProcess').submit();
                }
            });
        }
    </script>
@endsection