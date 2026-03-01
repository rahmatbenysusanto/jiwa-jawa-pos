@extends('layout.index')
@section('title', 'Kas Konsolidasi Bulanan')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Kas Konsolidasi Bulanan</h4>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end mb-3 gap-2">
        <button class="btn btn-success"><i class="far fa-file-excel me-1"></i> Export Excel</button>
        <button class="btn btn-info text-white"><i class="fab fa-whatsapp me-1"></i> Share WA</button>
    </div>

    <div class="row">
        <div class="card">
            <div class="card-header">
                <form action="{{ url()->current() }}" method="GET">
                    <div class="row">
                        <div class="col-2">
                            <label class="form-label">Tahun</label>
                            <select name="year" class="form-control">
                                <option value="">-- Pilih Tahun --</option>
                                @for ($i = date('Y'); $i >= 2023; $i--)
                                    <option value="{{ $i }}"
                                        {{ request()->get('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-2">
                            <label class="form-label">Bulan</label>
                            <select name="month" class="form-control">
                                <option value="">-- Pilih Bulan --</option>
                                @foreach (range(1, 12) as $m)
                                    <option value="{{ $m }}"
                                        {{ request()->get('month') == $m ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                    </option>
                                @endforeach
                            </select>
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
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Bulan / Tahun</th>
                                <th>Total Modal Awal</th>
                                <th>Total Modal Akhir</th>
                                <th>Total Selisih</th>
                                <th>Total Cash</th>
                                <th>Total QRIS</th>
                                <th>Total Debit</th>
                                <th>Total Laba Kotor</th>
                                <th>Total Laba Bersih</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kasKonsolidasi as $index => $item)
                                <tr>
                                    <td>{{ $kasKonsolidasi->firstItem() + $index }}</td>
                                    <td>{{ date('F', mktime(0, 0, 0, $item->month, 1)) }} {{ $item->year }}</td>
                                    <td>Rp {{ number_format($item->total_modal_awal) }}</td>
                                    <td>Rp {{ number_format($item->total_modal_akhir) }}</td>
                                    <td>
                                        @if ($item->total_selisih < 0)
                                            <span class="text-danger">Rp {{ number_format($item->total_selisih) }}</span>
                                        @elseif($item->total_selisih > 0)
                                            <span class="text-warning">Rp {{ number_format($item->total_selisih) }}</span>
                                        @else
                                            Rp {{ number_format($item->total_selisih) }}
                                        @endif
                                    </td>
                                    <td>Rp {{ number_format($item->total_cash) }}</td>
                                    <td>Rp {{ number_format($item->total_qris) }}</td>
                                    <td>Rp {{ number_format($item->total_debit) }}</td>
                                    <td>Rp {{ number_format($item->total_laba_kotor) }}</td>
                                    <td>Rp {{ number_format($item->total_laba_bersih) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    @if ($kasKonsolidasi->hasPages())
                        <ul class="pagination">
                            @if ($kasKonsolidasi->onFirstPage())
                                <li class="disabled"><span>&laquo; Previous</span></li>
                            @else
                                <li><a href="{{ $kasKonsolidasi->previousPageUrl() }}&per_page={{ request('per_page', 10) }}"
                                        rel="prev">&laquo; Previous</a></li>
                            @endif

                            @foreach ($kasKonsolidasi->links()->elements as $element)
                                @if (is_string($element))
                                    <li class="disabled"><span>{{ $element }}</span></li>
                                @endif

                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $kasKonsolidasi->currentPage())
                                            <li class="active"><span>{{ $page }}</span></li>
                                        @else
                                            <li><a
                                                    href="{{ $url }}&per_page={{ request('per_page', 10) }}">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach

                            @if ($kasKonsolidasi->hasMorePages())
                                <li><a href="{{ $kasKonsolidasi->nextPageUrl() }}&per_page={{ request('per_page', 10) }}"
                                        rel="next">Next &raquo;</a></li>
                            @else
                                <li class="disabled"><span>Next &raquo;</span></li>
                            @endif
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
