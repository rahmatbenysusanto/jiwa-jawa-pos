@extends('layout.index')
@section('title', 'Material')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Material</h4>
            </div>
        </div>
        <div class="page-btn">
            <a class="btn btn-primary" href="{{ route('inventory.material.create') }}">
                <i class="ti ti-circle-plus me-1"></i>
                Create Material
            </a>
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
                                <input type="text" class="form-control" name="sku" value="{{ request()->get('sku', null) }}" placeholder="Sku ...">
                            </div>
                            <div class="col-2">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" value="{{ request()->get('name', null) }}" placeholder="Name ...">
                            </div>
                            <div class="col-2">
                                <label class="form-label">Category</label>
                                <select class="form-control" name="category">
                                    <option value="">-- Choose Category --</option>
                                    @foreach($category as $item)
                                        <option value="{{ $item->id }}" {{ request()->get('category') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status">
                                    <option value="">-- Choose Status --</option>
                                    <option value="active" {{ request()->get('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ request()->get('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <label class="form-label text-white">-</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-info">Search</button>
                                    <a href="{{ url()->current() }}" class="btn btn-danger">Clear</a>
                                </div>
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
                                    <th>Min Stock</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($material as $index => $item)
                                <tr>
                                    <td>{{ $material->firstItem() + $index }}</td>
                                    <td>{{ $item->sku }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->category->name }}</td>
                                    <td>{{ number_format($item->min_stock) }} {{ $item->unit->symbol }}</td>
                                    <td>Rp {{ number_format($item->price) }}</td>
                                    <td>
                                        @if($item->status == 'active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('inventory.material.detail', ['id' => $item->id]) }}" class="btn btn-info btn-sm">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('inventory.material.edit', ['id' => $item->id]) }}" class="btn btn-secondary btn-sm">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        @if ($material->hasPages())
                            <ul class="pagination">
                                @if ($material->onFirstPage())
                                    <li class="disabled"><span>&laquo; Previous</span></li>
                                @else
                                    <li><a href="{{ $material->previousPageUrl() }}&per_page={{ request('per_page', 10) }}" rel="prev">&laquo; Previous</a></li>
                                @endif

                                @foreach ($material->links()->elements as $element)
                                    @if (is_string($element))
                                        <li class="disabled"><span>{{ $element }}</span></li>
                                    @endif

                                    @if (is_array($element))
                                        @foreach ($element as $page => $url)
                                            @if ($page == $material->currentPage())
                                                <li class="active"><span>{{ $page }}</span></li>
                                            @else
                                                <li><a href="{{ $url }}&per_page={{ request('per_page', 10) }}">{{ $page }}</a></li>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach

                                @if ($material->hasMorePages())
                                    <li><a href="{{ $material->nextPageUrl() }}&per_page={{ request('per_page', 10) }}" rel="next">Next &raquo;</a></li>
                                @else
                                    <li class="disabled"><span>Next &raquo;</span></li>
                                @endif
                            </ul>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection