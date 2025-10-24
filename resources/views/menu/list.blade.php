@extends('layout.index')
@section('title', 'List Menu')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Menu</h4>
                <h6>Manage your menu</h6>
            </div>
        </div>
        <div class="page-btn">
            <a href="{{ route('menu.create') }}" class="btn btn-primary"><i class="ti ti-circle-plus me-1"></i>Add Menu</a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <form>
                        <div class="row">
                            <div class="col-2">
                                <label for="sku" class="form-label">SKU</label>
                                <input type="text" class="form-control" name="sku" id="sku" placeholder="SKU ..." value="{{ request()->get('sku', null) }}">
                            </div>
                            <div class="col-2">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Coffee ..." value="{{ request()->get('name', null) }}">
                            </div>
                            <div class="col-2">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-control" id="category" name="category">
                                    <option value="">Choose Category</option>
                                    @foreach($category as $item)
                                        <option value="{{ $item->id }}" {{ request()->get('category') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="combo" class="form-label">Combo</label>
                                <select class="form-control" id="combo" name="combo">
                                    <option value="">Choose Combo</option>
                                    <option value="yes" {{ request()->get('combo') == 'Combo' ? 'selected' : '' }}>Combo</option>
                                    <option value="no" {{ request()->get('combo') == 'Not Combo' ? 'selected' : '' }}>Not Combo</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="">Choose Status</option>
                                    <option value="active" {{ request()->get('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ request()->get('status') == 'InActive' ? 'selected' : '' }}>InActive</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <label class="form-label text-white">-</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                    <a href="{{ url()->current() }}" class="btn btn-danger">Clear</a>
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
                                <th class="text-center">#</th>
                                <th>SKU</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Base Price</th>
                                <th class="text-center">Combo</th>
                                <th class="text-center">Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($menu as $index => $item)
                                <tr>
                                    <td class="text-center">{{ $menu->firstItem() + $index }}</td>
                                    <td>{{ $item->sku }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->category->name }}</td>
                                    <td>Rp {{ number_format($item->price) }}</td>
                                    <td class="text-center">
                                        @if($item->is_combo == 'no')
                                            <span class="badge bg-soft-success">Not Combo</span>
                                        @else
                                            <span class="badge bg-soft-info">Combo</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($item->status == 'active')
                                            <span class="badge bg-soft-success">Active</span>
                                        @else
                                            <span class="badge bg-soft-danger">InActive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="hstack gap-2 fs-15">
                                            <a href="{{ route('menu.detail', ['id' => $item->id]) }}" class="btn btn-icon btn-sm btn-secondary">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="" class="btn btn-success btn-sm">
                                                <i class="fa fa-book"></i>
                                            </a>
                                            <a href="{{ route('menu.edit', ['id' => $item->id]) }}" class="btn btn-icon btn-sm btn-info">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                            <a class="btn btn-icon btn-sm btn-danger" onclick="deleteMenu('{{ $item->id }}')">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        @if ($menu->hasPages())
                            <ul class="pagination">
                                @if ($menu->onFirstPage())
                                    <li class="disabled"><span>&laquo; Previous</span></li>
                                @else
                                    <li><a href="{{ $menu->previousPageUrl() }}&per_page={{ request('per_page', 10) }}" rel="prev">&laquo; Previous</a></li>
                                @endif

                                @foreach ($menu->links()->elements as $element)
                                    @if (is_string($element))
                                        <li class="disabled"><span>{{ $element }}</span></li>
                                    @endif

                                    @if (is_array($element))
                                        @foreach ($element as $page => $url)
                                            @if ($page == $menu->currentPage())
                                                <li class="active"><span>{{ $page }}</span></li>
                                            @else
                                                <li><a href="{{ $url }}&per_page={{ request('per_page', 10) }}">{{ $page }}</a></li>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach

                                @if ($menu->hasMorePages())
                                    <li><a href="{{ $menu->nextPageUrl() }}&per_page={{ request('per_page', 10) }}" rel="next">Next &raquo;</a></li>
                                @else
                                    <li class="disabled"><span>Next &raquo;</span></li>
                                @endif
                            </ul>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function deleteMenu(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Delete this menu?",
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
                        url: '{{ route('menu.delete') }}',
                        method: 'GET',
                        data:{
                            id: id
                        },
                        success: (res) => {
                            Swal.fire({
                                icon: "success",
                                title: "Deleted!",
                                text: "Menu has been deleted.",
                                confirmButtonText: "Great!",
                                customClass: {
                                    confirmButton: "btn btn-success"
                                },
                                buttonsStyling: false
                            }).then((i) => {
                                window.location.reload();
                            });
                        }
                    });
                }
            });
        }
    </script>
@endsection