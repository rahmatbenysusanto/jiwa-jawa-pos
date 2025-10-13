@extends('layout.index')
@section('title', 'Detail Menu')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Detail Menu</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Menu Information</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">SKU</label>
                                <input type="text" class="form-control" value="{{ $menu->sku }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" value="{{ $menu->name }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <input type="text" class="form-control" value="{{ $menu->status }}" readonly>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <input type="text" class="form-control" value="{{ $menu->category->name }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Base Price</label>
                                <input type="text" class="form-control" value="Rp {{ number_format($menu->price) }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Combo Menu</label>
                                <input type="text" class="form-control" value="{{ $menu->is_combo }}" readonly>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="3" readonly>{{ $menu->description }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Image</h4>
                </div>
                <div class="card-body">
                    @if($menu->image == null)

                    @else
                        <img src="{{ asset('uploads/menu/'.$menu->image) }}" alt="..." width="200" height="200">
                    @endif
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Variant</h4>
                </div>
                <div class="card-body">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Variant</th>
                                <th>Option</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($variant as $index => $item)
                            @foreach($item->menuVariantOptions as $option)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $option->name }}</td>
                                    <td>Rp {{ number_format($option->price_delta) }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection