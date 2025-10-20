@extends('layout.index')
@section('title', 'Purchase Order')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Purchase Order</h4>
            </div>
        </div>
        <div class="page-btn">
            <a class="btn btn-primary" href="{{ route('inventory.purchase.order.create') }}">
                <i class="ti ti-circle-plus me-1"></i>
                Create Purchase Order
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
                                    <th>PO Number</th>
                                    <th>Warehouse Name</th>
                                    <th class="text-center">QTY</th>
                                    <th>PO Date</th>
                                    <th class="text-center">Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($purchaseOrder as $index => $item)
                                <tr>
                                    <td>{{ $purchaseOrder->firstItem() + $index }}</td>
                                    <td>{{ $item->number }}</td>
                                    <td>{{ $item->warehouse_name }}</td>
                                    <td class="text-center fw-bold">{{ $item->qty }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->po_date)->translatedFormat('d F Y H:i') }}</td>
                                    <td class="text-center">
                                        @switch($item->status)
                                            @case('new')
                                                <span class="badge bg-secondary">New</span>
                                                @break

                                            @case('awaiting confirmation')
                                                <span class="badge bg-warning text-dark">Awaiting Confirmation</span>
                                                @break

                                            @case('approved')
                                                <span class="badge bg-primary">Approved</span>
                                                @break

                                            @case('processed')
                                                <span class="badge bg-info">Processed</span>
                                                @break

                                            @case('on delivery')
                                                <span class="badge bg-info">On Delivery</span>
                                                @break

                                            @case('arrived')
                                                <span class="badge bg-success">Arrived</span>
                                                @break

                                            @case('quality check')
                                                <span class="badge bg-warning text-dark">Quality Check</span>
                                                @break

                                            @case('completed')
                                                <span class="badge bg-success">Completed</span>
                                                @break

                                            @case('cancel')
                                                <span class="badge bg-danger">Cancel</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('inventory.purchase.order.detail', ['id' => $item->id]) }}" class="btn btn-secondary btn-sm">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            @if($item->status == 'new')
                                                <a class="btn btn-info btn-sm">
                                                    <i class="fa fa-right-from-bracket"></i>
                                                </a>
                                                <a class="btn btn-danger btn-sm" onclick="cancelPO('{{ $item->id }}')">
                                                    <i class="fa fa-xmark"></i>
                                                </a>
                                            @endif
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

@section('js')
    <script>
        function cancelPO(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Cancel Purchase Order?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "Yes, cancel po!",
                cancelButtonText: "Cancel",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-danger ml-1"
                },
                buttonsStyling: false
            }).then(function (result) {
                if (result.isConfirmed) {

                    $.ajax({
                        url: '{{ route('inventory.purchase.order.cancel') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id
                        },
                        success: (res) => {
                            if (res.status) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Cancel Purchase Order Success!',
                                    icon: 'success',
                                }).then((i) => {
                                    window.location.reload();
                                });
                            }
                        }
                    });

                }
            });
        }
    </script>
@endsection























