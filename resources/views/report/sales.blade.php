@extends('layout.index')
@section('title', 'Sales Report')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Sales Report</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-2">
                            <input type="date" class="form-control" value="{{ date('Y-m-01') }}">
                        </div>
                        <div class="col-2">
                            <input type="date" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-2">
                            <a class="btn btn-primary">Search</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection