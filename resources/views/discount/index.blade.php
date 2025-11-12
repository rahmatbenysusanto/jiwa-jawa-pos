@extends('layout.index')
@section('title', 'Discount')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Discount</h4>
                <h6>Manage your discount</h6>
            </div>
        </div>
        <div class="page-btn">
            @if(collect(Session::get('menu', []))->contains('Add Discount'))
            <a href="{{ route('discount.create') }}" class="btn btn-primary">
                <i class="ti ti-circle-plus me-1"></i>
                Add Discount
            </a>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <form action="{{ url()->current() }}" method="GET">
                        <div class="row">
                            <div class="col-2">
                                <label class="form-label">Code</label>
                                <input type="text" class="form-control" value="{{ request()->get('code', null) }}" name="code" placeholder="Discount Code ...">
                            </div>
                            <div class="col-2">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" value="{{ request()->get('name', null) }}" name="name" placeholder="Discount Name ...">
                            </div>
                            <div class="col-2">
                                <label class="form-label">Scope</label>
                                <select class="form-control" name="scope">
                                    <option value="">-- Choose Scope --</option>
                                    <option value="transaction" {{ request()->get('scope') == 'transaction' ? 'selected' : '' }}>Transaction</option>
                                    <option value="product" {{ request()->get('scope') == 'product' ? 'selected' : '' }}>Product</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <label class="form-label">Type</label>
                                <select class="form-control" name="type">
                                    <option value="">-- Choose Type --</option>
                                    <option value="percentage" {{ request()->get('type') == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                    <option value="nominal" {{ request()->get('type') == 'nominal' ? 'selected' : '' }}>Nominal</option>
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
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th class="text-center">Scope</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">Value</th>
                                    <th class="text-center">Usage</th>
                                    <th class="text-center">Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($discount as $index => $item)
                                <tr>
                                    <td>{{ $discount->firstItem() + $index }}</td>
                                    <td>{{ $item->code }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td class="text-center">
                                        @if($item->scope == 'transaction')
                                            <span class="badge bg-secondary">Transaction</span>
                                        @else
                                            <span class="badge bg-dark">Product</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($item->type == 'percentage')
                                            <span class="badge bg-success">Percentage</span>
                                        @else
                                            <span class="badge bg-info">Nominal</span>
                                        @endif
                                    </td>
                                    <td class="fw-bold text-center">
                                        @if($item->type == 'percentage')
                                            {{ $item->value }} %
                                        @else
                                            Rp {{ number_format($item->value) }}
                                        @endif
                                    </td>
                                    <td class="text-center">{{ number_format($item->used_count) }}</td>
                                    <td class="text-center">
                                        @if($item->status == 'active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('discount.detail', ['id' => $item->id]) }}" class="btn btn-info btn-sm">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            @if(collect(Session::get('menu', []))->contains('Edit Discount'))
                                            <a href="{{ route('discount.edit', ['id' => $item->id]) }}" class="btn btn-primary btn-sm">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            @endif

                                            @if(collect(Session::get('menu', []))->contains('Delete Discount'))
                                            <a class="btn btn-danger btn-sm" onclick="deleteDiscount('{{ $item->id }}')">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        @if ($discount->hasPages())
                            <ul class="pagination">
                                @if ($discount->onFirstPage())
                                    <li class="disabled"><span>&laquo; Previous</span></li>
                                @else
                                    <li><a href="{{ $discount->previousPageUrl() }}&per_page={{ request('per_page', 10) }}" rel="prev">&laquo; Previous</a></li>
                                @endif

                                @foreach ($discount->links()->elements as $element)
                                    @if (is_string($element))
                                        <li class="disabled"><span>{{ $element }}</span></li>
                                    @endif

                                    @if (is_array($element))
                                        @foreach ($element as $page => $url)
                                            @if ($page == $discount->currentPage())
                                                <li class="active"><span>{{ $page }}</span></li>
                                            @else
                                                <li><a href="{{ $url }}&per_page={{ request('per_page', 10) }}">{{ $page }}</a></li>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach

                                @if ($discount->hasMorePages())
                                    <li><a href="{{ $discount->nextPageUrl() }}&per_page={{ request('per_page', 10) }}" rel="next">Next &raquo;</a></li>
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

@section('js')
    <script>
        function deleteDiscount(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Delete this discount?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-danger ml-1"
                },
                buttonsStyling: false
            }).then(function (result) {
                if (result.isConfirmed) {

                    $.ajax({
                        url: '{{ route('discount.delete') }}',
                        method: 'GET',
                        data:{
                            id: id
                        },
                        success: (res) => {
                            Swal.fire({
                                icon: "success",
                                title: "Deleted!",
                                text: "Discount has been deleted.",
                                confirmButtonText: "Great!",
                                customClass: {
                                    confirmButton: "btn btn-success"
                                },
                                buttonsStyling: false
                            }).then((i) => {
                                window.location.reload();
                            });
                        }
                    });
                }
            });
        }
    </script>
@endsection