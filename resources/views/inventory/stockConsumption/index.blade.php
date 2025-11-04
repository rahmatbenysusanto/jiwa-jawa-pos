@extends('layout.index')
@section('title', 'Stock Adjusment')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Stock Consumption</h4>
            </div>
        </div>
        <div class="page-btn">
            <a href="{{ route('inventory.stock.consumption.create') }}" class="btn btn-primary">
                <i class="ti ti-circle-plus me-1"></i>
                Create Stock Consumption
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
                                    <th>Type</th>
                                    <th>Menu</th>
                                    <th>Variant</th>
                                    <th>Addon</th>
                                    <th class="text-center">QTY</th>
                                    <th>Material</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($materialUsage as $index => $item)
                                <tr>
                                    <td>{{ $materialUsage->firstItem() + $index }}</td>
                                    <td>
                                        @if($item->type == 'transaction')
                                            <span class="badge bg-info">Transaction</span>
                                        @else
                                            <span class="badge bg-secondary">Manual</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->menu?->name }}</td>
                                    <td>{{ $item->variantDetail?->name }}</td>
                                    <td>{{ $item->addonDetail?->addon?->name }} {{ $item->addonDetail?->name }}</td>
                                    <td class="text-center fw-bold">{{ number_format($item->qty) }} {{ $item->material->baseUnit->symbol }}</td>
                                    <td>{{ $item->material->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y H:i') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        @if ($materialUsage->hasPages())
                            <ul class="pagination">
                                @if ($materialUsage->onFirstPage())
                                    <li class="disabled"><span>&laquo; Previous</span></li>
                                @else
                                    <li><a href="{{ $materialUsage->previousPageUrl() }}&per_page={{ request('per_page', 10) }}" rel="prev">&laquo; Previous</a></li>
                                @endif

                                @foreach ($materialUsage->links()->elements as $element)
                                    @if (is_string($element))
                                        <li class="disabled"><span>{{ $element }}</span></li>
                                    @endif

                                    @if (is_array($element))
                                        @foreach ($element as $page => $url)
                                            @if ($page == $materialUsage->currentPage())
                                                <li class="active"><span>{{ $page }}</span></li>
                                            @else
                                                <li><a href="{{ $url }}&per_page={{ request('per_page', 10) }}">{{ $page }}</a></li>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach

                                @if ($materialUsage->hasMorePages())
                                    <li><a href="{{ $materialUsage->nextPageUrl() }}&per_page={{ request('per_page', 10) }}" rel="next">Next &raquo;</a></li>
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