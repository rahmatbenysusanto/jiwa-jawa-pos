@extends('layout.index')
@section('title', 'Recipe Menu')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Recipe</h4>
                <h6>Manage your recipe Menu</h6>
            </div>
        </div>
        <div class="page-btn">
            <a href="{{ route('menu.create.recipe.addon') }}" class="btn btn-info"><i class="ti ti-circle-plus me-1"></i>Create Recipe Addon</a>
            <a href="{{ route('menu.create.recipe.menu') }}" class="btn btn-primary"><i class="ti ti-circle-plus me-1"></i>Create Recipe Menu</a>
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
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Total Variant</th>
                                    <th>Ingredient Count</th>
                                    <th>Last Update</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection