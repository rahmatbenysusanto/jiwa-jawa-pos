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
                    <a class="btn btn-primary btn-sm" onclick="createKasKonsolidasi()">Create Kas Konsolidasi</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <label class="form-label">Modal Awal</label>
                        <input type="number" class="form-control" id="modal_awal">
                    </div>
                    {{--                    <div class="col-6"> --}}
                    {{--                        <label class="form-label">Modal Akhir</label> --}}
                    {{--                        <input type="number" class="form-control" id="modal_akhir"> --}}
                    {{--                    </div> --}}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 mb-3">
                                <label class="form-label">Pecahan Rp 100.000</label>
                                <input type="number" class="form-control" name="pecahan_uang[]" id="pecahan_1"
                                    placeholder="0">
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label">Pecahan Rp 50.000</label>
                                <input type="number" class="form-control" name="pecahan_uang[]" id="pecahan_2"
                                    placeholder="0">
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label">Pecahan Rp 20.000</label>
                                <input type="number" class="form-control" name="pecahan_uang[]" id="pecahan_3"
                                    placeholder="0">
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label">Pecahan Rp 10.000</label>
                                <input type="number" class="form-control" name="pecahan_uang[]" id="pecahan_4"
                                    placeholder="0">
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label">Pecahan Rp 5.000</label>
                                <input type="number" class="form-control" name="pecahan_uang[]" id="pecahan_5"
                                    placeholder="0">
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label">Pecahan Rp 2.000</label>
                                <input type="number" class="form-control" name="pecahan_uang[]" id="pecahan_6"
                                    placeholder="0">
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label">Pecahan Rp 1.000</label>
                                <input type="number" class="form-control" name="pecahan_uang[]" id="pecahan_7"
                                    placeholder="0">
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label">Koin Rp 1.000</label>
                                <input type="number" class="form-control" name="pecahan_uang[]" id="pecahan_8"
                                    placeholder="0">
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label">Koin Rp 500</label>
                                <input type="number" class="form-control" name="pecahan_uang[]" id="pecahan_9"
                                    placeholder="0">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Tanggal Transaksi</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <label class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" value="{{ date('Y-m-d') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function createKasKonsolidasi() {
            const tanggal = document.getElementById('tanggal').value;
            const modalAwal = document.getElementById('modal_awal').value;

            if (!tanggal) {
                Swal.fire('Error', 'Silahkan pilih tanggal', 'error');
                return;
            }

            if (!modalAwal) {
                Swal.fire('Error', 'Silahkan isi modal awal', 'error');
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: "Create Kas Konsolidasi?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "Yes, create it!",
                cancelButtonText: "Cancel",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-danger ml-1"
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.isConfirmed) {

                    // Perhitungan Modal Akhir
                    const pecahanUang = {
                        1: 100000,
                        2: 50000,
                        3: 20000,
                        4: 10000,
                        5: 5000,
                        6: 2000,
                        7: 1000,
                        8: 1000,
                        9: 500
                    };

                    let modalAkhir = 0;
                    let dataPecahan = [];

                    Object.keys(pecahanUang).forEach((key) => {
                        const jumlah = parseInt(
                            document.getElementById(`pecahan_${key}`).value || 0
                        );

                        const subtotal = jumlah * parseInt(pecahanUang[key]);

                        modalAkhir += subtotal;

                        dataPecahan.push({
                            pecahan: pecahanUang[key],
                            jumlah: jumlah,
                            subtotal: subtotal
                        });
                    });


                    $.ajax({
                        url: '{{ route('report.kas.konsolidasi.store') }}',
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            tanggal: tanggal,
                            modalAwal: modalAwal,
                            modalAkhir: modalAkhir,
                            dataPecahan: dataPecahan
                        },
                        success: (res) => {
                            if (res.status) {
                                Swal.fire({
                                    title: 'Success',
                                    text: 'Create Kas Konsolidasi Success',
                                    icon: 'success'
                                }).then((i) => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Create Kas Konsolidasi Failed',
                                    icon: 'error'
                                });
                            }
                        }
                    });

                }
            });
        }
    </script>
@endsection
