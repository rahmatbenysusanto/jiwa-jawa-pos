@extends('layout.index')
@section('title', 'Detail Kas Konsolidasi')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Detail Kas Konsolidasi</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Detail Pecahan Uang</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Pecahan</th>
                                    <th class="text-center">Jumlah</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($pecahan as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>Rp {{ number_format($item->pecahan) }}</td>
                                    <td class="text-center">{{ $item->jumlah }}</td>
                                    <td>Rp {{ number_format($item->pecahan * $item->jumlah) }}</td>
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