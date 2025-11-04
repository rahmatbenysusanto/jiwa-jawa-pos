@extends('layout.index')
@section('title', 'Discount Report')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Transaction Discount</h4>
            </div>
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
                                    <th>Invoice Number</th>
                                    <th>Menu</th>
                                    <th>Discount Name</th>
                                    <th class="text-center">Discount Type</th>
                                    <th>Discount Total</th>
                                    <th>Transaction Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($discount as $index => $item)
                                <tr>
                                    <td>{{ $discount->firstItem() + $index }}</td>
                                    <td>{{ $item->transaction->invoice_number }}</td>
                                    <td>{{ $item->transaction_detail_id != null ? $item->transactionDetail->menu->name : '' }}</td>
                                    <td>{{ $item->discount->name }}</td>
                                    <td class="text-center">
                                        @if($item->discount->scope == 'product')
                                            <span class="badge bg-success">Product</span>
                                        @else
                                            <span class="badge bg-info">Transaction</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->discount->type == 'nominal')
                                            <b>Rp {{ number_format($item->price) }}</b>
                                        @else
                                            {{ number_format($item->price) }}% | <b>Rp {{ $item->transaction_detail_id == null ? number_format($item->transaction->discount) : number_format($item->transactionDetail->discount) }}</b>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y H:i') }}</td>
                                    <td>
                                        <a class="btn btn-info btn-sm">
                                            <i class="fa fa-eye"></i>
                                        </a>
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