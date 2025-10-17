@extends('layout.index')
@section('title', 'Detail Material')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Detail Material</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
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
                                    <option value="">{{ $material->category->name }}</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" value="{{ $material->name }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Price</label>
                                <input type="number" class="form-control" value="Rp {{ number_format($material->price) }}" readonly>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">SKU</label>
                                <input type="text" class="form-control" value="{{ $material->sku }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Min Stock</label>
                                <input type="number" class="form-control" value="{{ $material->min_stock }}" readonly>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" readonly>{{ $material->description }}</textarea>
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
                                    <option value="">{{ $material->unit->symbol }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label class="form-label">Base Unit</label>
                                <select class="form-control" id="base_unit" name="base_unit">
                                    <option value="">{{ $material->baseUnit->symbol }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label class="form-label">Conversion Value</label>
                                <input type="number" class="form-control" value="{{ (int)$material->conversion_value }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Image</h4>
                </div>
                <div class="card-body">
                    @if($material->image != null)
                        <img src="{{ asset('uploads/material/'.$material->image) }}" alt="..." width="500">
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection