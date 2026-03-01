@extends('layout.index')
@section('title', 'Recipe Addon Detail')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Recipe Addon Detail - {{ $addon->addon->name }} ({{ $addon->name }})</h4>
            </div>
        </div>
        <div class="page-btn">
            <a href="{{ route('menu.recipe.addon') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Addon Info</h4>
                </div>
                <div class="card-body">
                    <table class="table align-middle">
                        <tr>
                            <td width="150" class="fw-bold">Addon Group</td>
                            <td>: {{ $addon->addon->name }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Addon Value</td>
                            <td>: {{ $addon->name }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Recipe Materials</h4>
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
                            @forelse($materials as $index => $mat)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $mat->material_name }}</td>
                                    <td>{{ $mat->qty }} {{ $mat->unit }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No materials found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
