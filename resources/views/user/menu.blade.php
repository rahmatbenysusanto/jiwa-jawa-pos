@extends('layout.index')
@section('title', 'User Menu')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">User Menu</h4>
                <h6>Manage your role user menu</h6>
            </div>
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
                                    <th>Menu</th>
                                    <th>Access Menu</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($userMenu as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <div class="form-check form-check-md form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" {{ $item->userHasMenu != null ? 'checked' : '' }} onclick="changeMenu('{{ $item->id }}')">
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

@section('js')
    <script>
        function changeMenu(id) {
            $.ajax({
                url: '{{ route('user.menu.change') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    userId: '{{ request()->get('id') }}'
                },
                success: (res) => {

                }
            });
        }
    </script>
@endsection