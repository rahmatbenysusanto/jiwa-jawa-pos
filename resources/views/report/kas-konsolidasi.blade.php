@extends('layout.index')
@section('title', 'Kas Konsolidasi')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Kas Konsolidasi</h4>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('report.kas.konsolidasi.create') }}" class="btn btn-primary">Add Kas Konsolidasi</a>
    </div>

    <div class="row">
        <div class="card">
            <div class="card-header">
                <form action="{{ url()->current() }}" method="GET">
                    <div class="row">
                        <div class="col-2">
                            <label class="form-label">Tanggal</label>
                            <input type="date" class="form-control" value="{{ request()->get('tanggal') }}" name="tanggal">
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
                                <th>Tanggal</th>
                                <th>Modal Awal</th>
                                <th>Modal Akhir</th>
                                <th>Selisih</th>
                                <th>Cash</th>
                                <th>QRIS</th>
                                <th>Debit</th>
                                <th>Laba Kotor</th>
                                <th>Laba Bersih</th>
                                <th class="text-center">Status</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($kasKonsolidasi as $index => $item)
                            <tr>
                                <td>{{ $kasKonsolidasi->firstItem() + $index }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                                <td>Rp {{ number_format($item->modal_awal) }}</td>
                                <td>Rp {{ number_format($item->modal_akhir) }}</td>
                                <td>Rp {{ number_format($item->selisih) }}</td>
                                <td>Rp {{ number_format($item->cash) }}</td>
                                <td>Rp {{ number_format($item->qris) }}</td>
                                <td>Rp {{ number_format($item->debit) }}</td>
                                <td>Rp {{ number_format($item->laba_kotor) }}</td>
                                <td>Rp {{ number_format($item->laba_bersih) }}</td>
                                <td class="text-center">
                                    @switch($item->status)
                                        @case('normal')
                                            <span class="badge bg-success">Normal</span>
                                            @break
                                        @case('minus')
                                            <span class="badge bg-danger">Minus</span>
                                            @break
                                        @case('berlebih')
                                            <span class="badge bg-warning">Berlebih</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>{{ $item->user->name }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('report.kas.konsolidasi.detail', ['id' => $item->id]) }}" class="btn btn-secondary btn-sm">Detail</a>
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
@endsection