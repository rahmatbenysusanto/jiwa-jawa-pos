@extends('layout.index')
@section('title', 'Recipe Menu')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Recipe Menu</h4>
            </div>
        </div>
        <div class="page-btn">
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
                                    <th>SKU</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th class="text-center">Count Recipe Material</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($recipeMenu as $index => $item)
                                <tr>
                                    <td>{{ $recipeMenu->firstItem() + $index }}</td>
                                    <td>{{ $item->menu->sku }}</td>
                                    <td>{{ $item->menu->name }}</td>
                                    <td>{{ $item->menu->category->name }}</td>
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