@extends('layout.index')
@section('title', 'Discount Detail')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Detail Discount</h4>
            </div>
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
                                    <input type="text" class="form-control" value="{{ $discount->name }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="scope">Scope</label>
                                    <select class="form-control" readonly>
                                        <option value="">-- Choose Scope --</option>
                                        <option {{ $discount->scope == 'transaction' ? 'selected' : '' }}>Transaction</option>
                                        <option {{ $discount->scope == 'product' ? 'selected' : '' }}>Product</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="value">Discount</label>
                                    <input type="text" class="form-control" value="{{ $discount->type == 'nominal' ? 'Rp '.number_format($discount->value) : number_format($discount->value).'%' }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="start_date">Start Date</label>
                                    <input type="date" class="form-control" value="{{ $discount->start_date }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="min_tra_amount">Min Transaction Amount</label>
                                    <input type="number" class="form-control" value="{{ $discount->min_transaction_amount }}" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="code">Code</label>
                                    <input type="text" class="form-control" value="{{ $discount->code }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="type">Type</label>
                                    <select class="form-control" readonly>
                                        <option value="">-- Choose Type --</option>
                                        <option {{ $discount->type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                        <option {{ $discount->type == 'nominal' ? 'selected' : '' }}>Nominal</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="value_max">Discount Max</label>
                                    <input type="number" class="form-control" value="{{ $discount->max_value }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="end_date">End Date</label>
                                    <input type="date" class="form-control" value="{{ $discount->end_date }}" readonly>
                                </div>
                            </div>

                            <div class="col-6" id="formProduct" style="display: {{ $discount->scope == 'product' ? 'block' : 'none' }}">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4>Menu Discount</h4>
                                </div>
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>SKU</th>
                                            <th>Menu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($discountMenu as $menu)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $menu->menu->sku }}</td>
                                            <td>{{ $menu->menu->name }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection