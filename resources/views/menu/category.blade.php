@extends('layout.index')
@section('title', 'Category Menu')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Category</h4>
                <h6>Manage your categories</h6>
            </div>
        </div>
        <div class="page-btn">
            @if(collect(Session::get('menu', []))->contains('Add Menu Category'))
                <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-category"><i class="ti ti-circle-plus me-1"></i>Add Category</a>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($category as $index => $item)
                        <tr>
                            <td>{{ $category->firstItem() + $index }}</td>
                            <td>{{ $item->name }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if(collect(Session::get('menu', []))->contains('Edit Menu Category'))
                                    <a class="me-2" onclick="editCategory({{ $item->id }})">
                                        <i data-feather="edit" class="feather-edit"></i>
                                    </a>
                                    @endif

                                    @if(collect(Session::get('menu', []))->contains('Delete Menu Category'))
                                    <a class="p-2" onclick="deleteCategory({{ $item->id }})">
                                        <i data-feather="trash-2" class="feather-trash-2"></i>
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mt-3">
                @if ($category->hasPages())
                    <ul class="pagination">
                        @if ($category->onFirstPage())
                            <li class="disabled"><span>&laquo; Previous</span></li>
                        @else
                            <li><a href="{{ $category->previousPageUrl() }}&per_page={{ request('per_page', 10) }}" rel="prev">&laquo; Previous</a></li>
                        @endif

                        @foreach ($category->links()->elements as $element)
                            @if (is_string($element))
                                <li class="disabled"><span>{{ $element }}</span></li>
                            @endif

                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $category->currentPage())
                                        <li class="active"><span>{{ $page }}</span></li>
                                    @else
                                        <li><a href="{{ $url }}&per_page={{ request('per_page', 10) }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach

                        @if ($category->hasMorePages())
                            <li><a href="{{ $category->nextPageUrl() }}&per_page={{ request('per_page', 10) }}" rel="next">Next &raquo;</a></li>
                        @else
                            <li class="disabled"><span>Next &raquo;</span></li>
                        @endif
                    </ul>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="add-category">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="page-title">
                        <h4>Add Category</h4>
                    </div>
                    <button type="button" class="close bg-danger text-white fs-16" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('menu.category.add') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Category<span class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" name="category" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn me-2 btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-category">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="page-title">
                        <h4>Edit Category</h4>
                    </div>
                    <button type="button" class="close bg-danger text-white fs-16" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('menu.category.edit') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Category<span class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" name="category" id="categoryEdit" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn me-2 btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Edit Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function editCategory(id) {
            $.ajax({
                url: '{{ route('menu.category.find') }}',
                method: 'GET',
                data:{
                    id: id
                },
                success: (res) => {
                    document.getElementById('id').value = id;
                    document.getElementById('categoryEdit').value = res.data.name;
                    $('#edit-category').modal('show');
                }
            });
        }

        function deleteCategory(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Delete this category?",
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
                       url: '{{ route('menu.category.delete') }}',
                       method: 'GET',
                       data:{
                           id: id
                       },
                       success: (res) => {
                           Swal.fire({
                               icon: "success",
                               title: "Deleted!",
                               text: "Category has been deleted.",
                               confirmButtonText: "Great!",
                               customClass: {
                                   confirmButton: "btn btn-success"
                               },
                               buttonsStyling: false
                           });
                       }
                    });
                }
            });
        }
    </script>
@endsection