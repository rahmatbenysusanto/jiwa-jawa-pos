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
            <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-category">
                <i class="ti ti-circle-plus me-1"></i>
                Create Purchase Order
            </a>
        </div>
    </div>
@endsection