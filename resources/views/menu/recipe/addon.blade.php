@extends('layout.index')
@section('title', 'Recipe Menu')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Recipe Addon</h4>
            </div>
        </div>
        <div class="page-btn">
            <a href="{{ route('menu.create.recipe.addon') }}" class="btn btn-info"><i class="ti ti-circle-plus me-1"></i>Create Recipe Addon</a>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Addon Name</th>
                                    <th>Addon Option</th>
                                    <th class="text-center">Count Recipe Material</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($addon as $index => $item)
                                <tr>
                                    <td>{{ $addon->firstItem() + $index }}</td>
                                    <td>{{ $item->addon->addon->name }}</td>
                                    <td>{{ $item->addon->name }}</td>
                                    <td class="text-center fw-bold">{{ $item->total }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a class="btn btn-secondary btn-sm">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a class="btn btn-info btn-sm">
                                                <i class="fa fa-pencil"></i>
                                            </a>
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