@extends('layout.index')
@section('title', 'Top Selling Report')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Top Selling Menu</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ url()->current() }}" method="GET">
                        <div class="row">
                            <div class="col-2">
                                <input type="date" class="form-control" name="start" value="{{ request()->get('start', date('Y-m-01')) }}">
                            </div>
                            <div class="col-2">
                                <input type="date" class="form-control" name="end" value="{{ request()->get('end', date('Y-m-d')) }}">
                            </div>
                            <div class="col-2">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>SKU</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th class="text-center">Total Sales</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($topSelling as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->menu->sku }}</td>
                                <td>{{ $item->menu->name }}</td>
                                <td>{{ $item->menu->category->name }}</td>
                                <td class="text-center fw-bold">{{ number_format($item->sold_quantity) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection