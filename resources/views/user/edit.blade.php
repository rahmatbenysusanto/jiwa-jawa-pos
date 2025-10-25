@extends('layout.index')
@section('title', 'Edit User')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Edit User</h4>
            </div>
        </div>
        <div class="page-btn">
            <a class="btn btn-primary" onclick="updateUser()">
                <i class="ti ti-circle-plus me-1"></i>
                Edit User
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
                            <input type="text" class="form-control" value="{{ $user->name }}" name="name" id="name" placeholder="Name ..." required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" value="{{ $user->username }}" name="username" id="username" placeholder="Username ..." required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" value="{{ $user->email }}" name="email" id="email" placeholder="Email ..." required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="nohp" class="form-label">No HP</label>
                            <input type="number" class="form-control" value="{{ $user->no_hp }}" name="nohp" id="nohp" placeholder="089xxxx" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="text" class="form-control" value="********" name="password" id="password" placeholder="Name ..." required>
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
                                    <option value="{{ $outlet->id }}" {{ $user->outlet_id == $outlet->id ? 'selected' : '' }}>{{ $outlet->name }}</option>
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

@section('js')
    <script>
        function updateUser() {
            Swal.fire({
                title: "Are you sure?",
                text: `Update User?`,
                icon: "warning",
                showCancelButton: true,
                customClass: {
                    confirmButton: "btn btn-primary w-xs me-2 mt-2",
                    cancelButton: "btn btn-danger w-xs mt-2"
                },
                confirmButtonText: "Yes, Update it!",
                buttonsStyling: false,
                showCloseButton: true
            }).then((i) => {
                if (i.value) {

                    $.ajax({
                        url: '{{ route('user.update') }}',
                        method: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            name: document.getElementById('name').value,
                            username: document.getElementById('username').value,
                            email: document.getElementById('email').value,
                            noHp: document.getElementById('noHp').value,
                            password: document.getElementById('password').value,
                            outlet: document.getElementById('outlet').value,
                            id: '{{ request()->get('id') }}'
                        },
                        success: (res) => {
                            if (res.status) {
                                Swal.fire({
                                    title: "Success!",
                                    text: "User Updated Successfully!",
                                    icon: "success",
                                }).then((i) => {
                                    window.location.href = '{{ route('user.index') }}'
                                });
                            } else {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Something went wrong!",
                                    icon: "error",
                                });
                            }
                        }
                    });

                }
            });
        }
    </script>
@endsection





