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
            <a href="{{ route('discount.create') }}" class="btn btn-primary">
                <i class="ti ti-circle-plus me-1"></i>
                Add Discount
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">

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
                                            <a class="btn btn-info btn-sm">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a class="btn btn-primary btn-sm">
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
                </div>
            </div>
        </div>
    </div>
@endsection