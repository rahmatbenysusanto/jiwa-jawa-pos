@extends('layout.index')
@section('title', 'Material')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Manage Stock</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <form action="{{ url()->current() }}" method="GET">
                        <div class="row">
                            <div class="col-2">
                                <label class="form-label">SKU</label>
                                <input type="text" class="form-control" name="sku" placeholder="SKU ...">
                            </div>
                        </div>
                    </form>
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
                                    <th class="text-center">Live Stock</th>
                                    <th class="text-center">Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($inventory as $index => $item)
                                <tr>
                                    <td>{{ $inventory->firstItem() + $index }}</td>
                                    <td>{{ $item->material->sku }}</td>
                                    <td>{{ $item->material->name }}</td>
                                    <td>{{ $item->material->category->name }}</td>
                                    <td class="text-center fw-bold">{{ number_format($item->stock, 2) }} {{ $item->material->unit->symbol }}</td>
                                    <td class="text-center">
                                        @if($item->stock < $item->material->min_stock)
                                            <span class="badge bg-danger">Stock Minimum</span>
                                        @else
                                            <span class="badge bg-success">Stock Available</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('inventory.manage.stock.detail', ['id' => $item->id]) }}" class="btn btn-info btn-sm">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection