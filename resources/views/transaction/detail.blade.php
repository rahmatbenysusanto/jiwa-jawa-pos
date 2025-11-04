@extends('layout.index')
@section('title', 'Detail Transaction')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Detail Transaction</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <table>
                                <tr>
                                    <td class="fw-bold">Invoice Number</td>
                                    <td class="fw-bold ps-2">:</td>
                                    <td class="ps-1">{{ $transaction->invoice_number }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Order Number</td>
                                    <td class="fw-bold ps-2">:</td>
                                    <td class="ps-1">{{ $transaction->order_number }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Transaction Date</td>
                                    <td class="fw-bold ps-2">:</td>
                                    <td class="ps-1">{{ \Carbon\Carbon::parse($transaction->transaction_date)->translatedFormat('d F Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">QTY Item</td>
                                    <td class="fw-bold ps-2">:</td>
                                    <td class="ps-1">{{ $transaction->qty }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-4">
                            <table>
                                <tr>
                                    <td class="fw-bold">Sub Total</td>
                                    <td class="fw-bold ps-2">:</td>
                                    <td class="ps-1">Rp {{ number_format($transaction->subtotal) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Discount</td>
                                    <td class="fw-bold ps-2">:</td>
                                    <td class="ps-1">Rp {{ number_format($transaction->discount) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Tax</td>
                                    <td class="fw-bold ps-2">:</td>
                                    <td class="ps-1">Rp {{ number_format($transaction->tax) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Grand Total</td>
                                    <td class="fw-bold ps-2">:</td>
                                    <td class="ps-1">Rp {{ number_format($transaction->total) }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-4">
                            <table>
                                <tr>
                                    <td class="fw-bold">Payment Method</td>
                                    <td class="fw-bold ps-2">:</td>
                                    <td class="ps-1">{{ $transaction->paymentMethod->name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Status Payment</td>
                                    <td class="fw-bold ps-2">:</td>
                                    <td class="ps-1">
                                        @if($transaction->payment_status == 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @elseif($transaction->payment_status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @else
                                            <span class="badge bg-danger">Refund</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Note</td>
                                    <td class="fw-bold ps-2">:</td>
                                    <td class="ps-1">{{ $transaction->note }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Created By</td>
                                    <td class="fw-bold ps-2">:</td>
                                    <td class="ps-1">{{ $transaction->users->name }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th class="text-center">QTY</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach(json_decode($transactionData->cart) ?? [] as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="fw-bold">{{ $data->name }}</div>
                                    <div>Base Price : Rp {{ number_format($data->basePrice) }}</div>
                                    <div>Variant :</div>
                                    @foreach($data->data->variant ?? [] as $variant)
                                        <div>{{ $variant->name }} :
                                            @foreach($variant->option as $option)
                                                {{ $option->select == 1 ? $option->name.' - Rp '.number_format($option->price) : '' }}
                                            @endforeach
                                        </div>
                                    @endforeach
                                    @if(isset($data->data->addon))
                                        <div>Addon : </div>
                                        @foreach($data->data->addon ?? [] as $addon)
                                            <div>{{ $addon->name }} : 1 : Rp {{ number_format($addon->total) }}</div>
                                        @endforeach
                                    @endif
                                    <div>Discount : </div>
                                    @foreach($data->data->discountProduct ?? [] as $discount)
                                        <div class="text-danger">{{ $discount->select ?? 0 == 1 ? $discount->name.' - Rp '.number_format($data->priceDiscount) : '' }}</div>
                                    @endforeach
                                </td>
                                <td class="text-center fw-bold">{{ $data->qty }}</td>
                                <td>
                                    Rp {{ number_format($data->grandTotal) }}
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