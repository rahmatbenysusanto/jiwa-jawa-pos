@extends('layout.index')
@section('title', 'Create Kas Konsolidasi')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Create Kas Konsolidasi</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-end">
                    <a class="btn btn-primary btn-sm">Create Kas Konsolidasi</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <label class="form-label">Modal Awal</label>
                        <input type="number" class="form-control" id="modal_awal">
                    </div>
                    <div class="col-6">
                        <label class="form-label">Modal Akhir</label>
                        <input type="number" class="form-control" id="modal_akhir">
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal">
                    </div>
                    <div class="col-3">
                        <label class="form-label text-white">-</label>
                        <div>
                            <a class="btn btn-secondary" onclick="getDataTransaction()">Get Data Transaction</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-4 mb-3">
                        <label class="form-label">Cash</label>
                        <input type="text" class="form-control" id="cash" value="Rp 0" readonly>
                    </div>
                    <div class="col-4 mb-3">
                        <label class="form-label">QRIS</label>
                        <input type="text" class="form-control" id="qris" value="Rp 0" readonly>
                    </div>
                    <div class="col-4 mb-3">
                        <label class="form-label">Debit</label>
                        <input type="text" class="form-control" id="debit" value="Rp 0" readonly>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Laba Kotor</label>
                        <input type="text" class="form-control" id="laba_kotor" value="Rp 0" readonly>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Laba Bersih</label>
                        <input type="text" class="form-control" id="laba_bersih" value="Rp 0" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function getDataTransaction() {
            const tanggal = document.getElementById('tanggal').value;

            $.ajax({
                url: '{{ route('report.kas.konsolidasi.data.transaction') }}',
                method: 'GET',
                data: {
                    tanggal: tanggal
                },
                success: (res) => {
                    const data = res.data;

                    document.getElementById('laba_kotor').value =
                        new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        }).format(data.total);

                    document.getElementById('laba_bersih').value =
                        new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        }).format(data.total - data.hpp);

                    document.getElementById('cash').value =
                        new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        }).format(data.total_cash);


                    document.getElementById('qris').value =
                        new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        }).format(data.total_qris);


                    document.getElementById('debit').value =
                        new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        }).format(data.total_debit);

                }
            });
        }
    </script>
@endsection