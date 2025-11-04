@extends('layout.index')
@section('title', 'Store Performance Report')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Store Performance Report</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-3">
                            <label class="form-label">Outlet</label>
                            <select class="form-control">
                                <option value="">-- Choose Outlet --</option>
                                @foreach($outlet as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <label class="form-label">Start Date</label>
                            <input type="date" class="form-control" value="{{ request()->get('start') }}">
                        </div>
                        <div class="col-3">
                            <label class="form-label">End Date</label>
                            <input type="date" class="form-control" value="{{ request()->get('end') }}">
                        </div>
                        <div class="col-3">
                            <label class="form-label text-white">-</label>
                            <div class="d-flex gap-2">
                                <a class="btn btn-info">Search</a>
                                <a href="{{ url()->current() }}" class="btn btn-danger">Clear</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
@endsection