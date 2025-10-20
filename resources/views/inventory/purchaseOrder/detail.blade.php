@extends('layout.index')
@section('title', 'Detail Purchase Order')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Detail Purchase Order</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>SKU</th>
                                <th>Name</th>
                                <th>QTY</th>
                                <th>Unit</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($purchaseOrderDetail as $detail)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $detail->material->sku }}</td>
                                    <td>{{ $detail->material->name }}</td>
                                    <td>{{ $detail->qty }}</td>
                                    <td>{{ $detail->material->unit->symbol }}</td>
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