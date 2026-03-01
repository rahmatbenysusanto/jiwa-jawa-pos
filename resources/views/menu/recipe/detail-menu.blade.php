@extends('layout.index')
@section('title', 'Recipe Menu Detail')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Recipe Menu Detail - {{ $menu->name }}</h4>
            </div>
        </div>
        <div class="page-btn">
            <a href="{{ route('menu.recipe.menu') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Menu Info</h4>
                </div>
                <div class="card-body">
                    <table class="table align-middle">
                        <tr>
                            <td width="150" class="fw-bold">SKU</td>
                            <td>: {{ $menu->sku }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Name</td>
                            <td>: {{ $menu->name }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Category</td>
                            <td>: {{ $menu->category->name }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Recipe Basic Menu</h4>
                </div>
                <div class="card-body">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Material Name</th>
                                <th>QTY</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($basicMaterials as $index => $mat)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $mat->material_name }}</td>
                                    <td>{{ $mat->qty }} {{ $mat->unit }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No basic materials found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Recipe Variant Menu</h4>
                </div>
                <div class="card-body">
                    @php
                        $groupedVariants = collect($variantMaterials)->groupBy('variant_name');
                    @endphp
                    @forelse($groupedVariants as $variantName => $materials)
                        <h5 class="mt-3 mb-2">{{ $variantName }}</h5>
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Option Name</th>
                                    <th>Material Name</th>
                                    <th>QTY</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($materials as $mat)
                                    <tr>
                                        <td>{{ $mat->option_name }}</td>
                                        <td>{{ $mat->material_name }}</td>
                                        <td>{{ $mat->qty }} {{ $mat->unit }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @empty
                        <div class="text-center py-3">No variant materials found</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
