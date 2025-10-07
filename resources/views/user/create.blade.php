@extends('layout.index')
@section('title', 'Create User')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Create Outlet</h4>
            </div>
        </div>
        <div class="page-btn">
            <a class="btn btn-primary">
                <i class="ti ti-circle-plus me-1"></i>
                Create Outlet
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">User Information</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name ..." required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" id="username" placeholder="Username ..." required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="Email ..." required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="nohp" class="form-label">No HP</label>
                            <input type="number" class="form-control" name="nohp" id="nohp" placeholder="089xxxx" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="text" class="form-control" name="password" id="password" placeholder="Name ..." required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Outlet</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <label for="outlet" class="form-label">Outlet</label>
                            <select class="form-control" id="outlet">
                                <option value="">-- Choose Outlet --</option>
                                @foreach($outlets as $outlet)
                                    <option value="{{ $outlet->id }}">{{ $outlet->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Menu</h4>
                </div>
                <div class="card-body">
                    <div class="row">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection





