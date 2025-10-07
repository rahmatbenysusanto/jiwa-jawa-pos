@extends('layout.index')
@section('title', 'Addon')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Add on</h4>
                <h6>Manage your Add on Menu</h6>
            </div>
        </div>
        <div class="page-btn">
            <a href="{{ route('menu.addon.create') }}" class="btn btn-primary"><i class="ti ti-circle-plus me-1"></i>Create Addon</a>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <form action="{{ url()->current() }}" method="GET">
                        <div class="row">
                            <div class="col-6">
                                <label for="name" class="form-label">Addon Name</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ request()->get('name', null) }}" placeholder="Name addon ...">
                            </div>
                            <div class="col-6">
                                <label class="form-label text-white">-</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                    <a class="btn btn-danger">Clear</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Addon Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($addon as $index => $item)
                                <tr>
                                    <td>{{ $addon->firstItem() + $index }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('menu.addon.detail', ['id' => $item->id]) }}" class="btn btn-info btn-sm">Detail</a>
                                            <a class="btn btn-danger btn-sm">Delete</a>
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