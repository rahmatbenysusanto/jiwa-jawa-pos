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

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>Modal Awal</th>
                                <th>Modal Akhir</th>
                                <th>Cash</th>
                                <th>QRIS</th>
                                <th>Debit</th>
                                <th>Laba Kotor</th>
                                <th>Laba Bersih</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($kasKonsolidasi as $index => $item)
                            <tr>
                                <td>{{ $kasKonsolidasi->firstItem() + $index }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->transaction_date)->translatedFormat('d F Y') }}</td>
                                <td>Rp {{ number_format($item->modal_awal) }}</td>
                                <td>Rp {{ number_format($item->modal_akhir) }}</td>
                                <td>Rp {{ number_format($item->cash) }}</td>
                                <td>Rp {{ number_format($item->qris) }}</td>
                                <td>Rp {{ number_format($item->debit) }}</td>
                                <td>Rp {{ number_format($item->laba_kotor) }}</td>
                                <td>Rp {{ number_format($item->laba_bersih) }}</td>
                                <td></td>
                                <td>
                                    <div class="d-flex gap-2">

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