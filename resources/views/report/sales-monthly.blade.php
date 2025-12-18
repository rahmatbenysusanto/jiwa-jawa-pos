@extends('layout.index')
@section('title', 'Sales Report')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Sales Report</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-2">
                            <input type="date" class="form-control" value="{{ date('Y-m-01') }}">
                        </div>
                        <div class="col-2">
                            <input type="date" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-2">
                            <a class="btn btn-primary">Search</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date Order</th>
                                    <th class="text-center">Total Transaction</th>
                                    <th class="text-center">Total Item</th>
                                    <th>Grand Total</th>
                                    <th>HPP Transaction</th>
                                    <th>Net Income</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($transaction as $index => $item)
                                <tr>
                                    <td>{{ $transaction->firstItem() + $index }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::create($item->year, $item->month)->translatedFormat('F Y') }}
                                    </td>
                                    <td class="text-center fw-bold">{{ number_format($item->total_order) }}</td>
                                    <td class="text-center fw-bold">{{ number_format($item->total_item) }}</td>
                                    <td class="fw-bold">Rp {{ number_format($item->grand_total) }}</td>
                                    <td class="fw-bold">Rp {{ number_format($item->total_hpp) }}</td>
                                    <td class="fw-bold">Rp {{ number_format($item->grand_total - $item->total_hpp) }}</td>
                                    <td>
                                        <a href="{{ route('report.sales.detail') }}" class="btn btn-info btn-sm">Detail</a>
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