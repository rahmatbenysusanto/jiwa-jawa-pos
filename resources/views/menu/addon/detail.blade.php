@extends('layout.index')
@section('title', 'Detail Addon')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Detail Add on</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Addon Name</label>
                            <input type="text" class="form-control" name="name" value="{{ $addon->name }}" placeholder="Addon Name ..." oninput="changeAddonName(this.value)">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-white">-</label>
                            <div class="d-flex justify-content-end">
                                <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createVariantModal">Add Variant Addon</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($addonVariant as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>Rp {{ number_format($item->price) }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a class="btn btn-success btn-sm">Recipe</a>
                                            <a class="btn btn-info btn-sm" onclick="editVariant('{{ $item->id }}', '{{ $item->name }}', '{{ $item->price }}')">Edit</a>
                                            <a class="btn btn-danger btn-sm" onclick="deleteVariant('{{ $item->id }}')">Delete</a>
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

    <div id="createVariantModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Add Variant Addon</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('menu.addon.detail.add.variant') }}" method="POST">
                        @csrf
                        <input type="hidden" name="addon_id" value="{{ $addon->id }}">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Variant Name">
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" name="price" id="price" placeholder="Rp 0">
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="editVariantModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Edit Variant Addon</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('menu.addon.detail.edit') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="variant-id">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" id="variant-name" placeholder="Variant Name">
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" name="price" id="variant-price" placeholder="Rp 0">
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function editVariant(id, name, price) {
            document.getElementById('variant-name').value = name;
            document.getElementById('variant-price').value = price;
            document.getElementById('variant-id').value = id;

            $('#editVariantModal').modal('show');
        }

        function deleteVariant(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Delete Variant Addon?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-danger ml-1"
                },
                buttonsStyling: false
            }).then(function (result) {
                if (result.isConfirmed) {

                    $.ajax({
                        url: '{{ route('menu.addon.detail.delete') }}',
                        method: 'GET',
                        data: {
                            id: id,
                        },
                        success: (res) => {
                            if (res.status) {
                                Swal.fire({
                                   title: 'Success!',
                                   text: 'Variant Deleted Successfully!',
                                   icon: 'success',
                                });
                            }
                        }
                    });

                }
            });
        }

        function changeAddonName(value) {
            $.ajax({
                url: '{{ route('menu.addon.edit.name') }}',
                method: 'GET',
                data: {
                    name: value,
                    id: '{{ $addon->id }}'
                },
                success: (res) => {

                }
            });
        }
    </script>
@endsection

































