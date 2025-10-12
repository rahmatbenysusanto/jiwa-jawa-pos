@extends('layout.index')
@section('title', 'List Transaction')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Transaction List</h4>
                <h6>Manage your transaction</h6>
            </div>
        </div>
        <div class="page-btn">
            <a href="{{ route('pos.index') }}" class="btn btn-primary">
                <i class="ti ti-circle-plus me-1"></i>
                Create Transaction
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
                                <label class="form-label">Invoice</label>
                                <input type="text" class="form-control" name="invoice" value="{{ request()->get('invoice', null) }}" placeholder="Invoice number ...">
                            </div>
                            <div class="col-2">
                                <label class="form-label">Order Number</label>
                                <input type="number" class="form-control" name="orderNumber" value="{{ request()->get('orderNumber', null) }}" placeholder="Order number ...">
                            </div>
                            <div class="col-2">
                                <label class="form-label">Payment Method</label>
                                <select class="form-control" name="paymentMethod">
                                    <option value="">-- Choose Payment Method --</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <label class="form-label">Payment Status</label>
                                <select class="form-control" name="paymentStatus">
                                    <option value="">-- Choose Payment Status --</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <label class="form-label">Transaction Date</label>
                                <input type="date" class="form-control" name="date" value="{{ request()->get('date', null) }}">
                            </div>
                            <div class="col-2">
                                <label class="form-label text-white">-</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                    <a href="{{ url()->current() }}" class="btn btn-danger">Clear</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Invoice</th>
                                    <th class="text-center">Order No</th>
                                    <th class="text-center">QTY Item</th>
                                    <th>Total Price</th>
                                    <th class="text-center">Payment Method</th>
                                    <th class="text-center">Payment Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($transaction as $index => $item)
                                <tr>
                                    <td>{{ $transaction->firstItem() + $index }}</td>
                                    <td>{{ $item->invoice_number }}</td>
                                    <td class="text-center">{{ $item->order_number }}</td>
                                    <td class="text-center">{{ number_format($item->qty) }}</td>
                                    <td>Rp {{ number_format($item->total) }}</td>
                                    <td class="text-center">{{ $item->paymentMethod->name }}</td>
                                    <td class="text-center">
                                        @if($item->payment_status == 'pending')
                                            <span class="badge bg-danger">Unpaid</span>
                                        @elseif($item->status_payment == 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($item->transaction_date)->translatedFormat('d F Y H:i') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a class="btn btn-info btn-sm">
                                                <i class="fa fa-eye"></i>
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