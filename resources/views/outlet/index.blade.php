@extends('layout.index')
@section('title', 'Outlet')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Outlet</h4>
                <h6>Manage your outlet</h6>
            </div>
        </div>
        <div class="page-btn">
            <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createOutletModal">
                <i class="ti ti-circle-plus me-1"></i>
                Add Outlet
            </a>
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
                                    <th>Name</th>
                                    <th>No HP</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Slider Image</th>
                                    <th>Wifi</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($outlets as $index => $item)
                                <tr>
                                    <td>{{ $outlets->firstItem() + $index }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->no_hp }}</td>
                                    <td>{{ $item->address }}</td>
                                    <td>
                                        @if($item->status == 'active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">InActive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('outlet.slider', ['id' => $item->id]) }}" class="btn btn-info btn-sm">Slider</a>
                                    </td>
                                    <td>
                                        <a class="btn btn-secondary btn-sm" onclick="openModalWifi('{{ $item->id }}', '{{ $item->wifi }}')">
                                            <i class="fa fa-wifi"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a class="btn btn-info btn-sm" onclick="detailOutlet('{{ $item->id }}')">Detail</a>
                                            <a class="btn btn-secondary btn-sm" onclick="editOutlet('{{ $item->id }}')">Edit</a>
                                            <a class="btn btn-danger btn-sm" onclick="deleteOutlet('{{ $item->id }}')">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        @if ($outlets->hasPages())
                            <ul class="pagination">
                                @if ($outlets->onFirstPage())
                                    <li class="disabled"><span>&laquo; Previous</span></li>
                                @else
                                    <li><a href="{{ $outlets->previousPageUrl() }}&per_page={{ request('per_page', 10) }}" rel="prev">&laquo; Previous</a></li>
                                @endif

                                @foreach ($outlets->links()->elements as $element)
                                    @if (is_string($element))
                                        <li class="disabled"><span>{{ $element }}</span></li>
                                    @endif

                                    @if (is_array($element))
                                        @foreach ($element as $page => $url)
                                            @if ($page == $outlets->currentPage())
                                                <li class="active"><span>{{ $page }}</span></li>
                                            @else
                                                <li><a href="{{ $url }}&per_page={{ request('per_page', 10) }}">{{ $page }}</a></li>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach

                                @if ($outlets->hasMorePages())
                                    <li><a href="{{ $outlets->nextPageUrl() }}&per_page={{ request('per_page', 10) }}" rel="next">Next &raquo;</a></li>
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

    <div id="createOutletModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Create Outlet</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('outlet.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name outlet ..." required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No HP</label>
                            <input type="number" class="form-control" name="no_hp" id="no_hp" placeholder="08xx ...">
                        </div>
                        <div class="mb-1">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" name="address" rows="2" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-white">-</label>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="detailOutletModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Detail Outlet</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table>
                        <tr>
                            <td class="fw-bold">Name</td>
                            <td class="fw-bold ps-2">:</td>
                            <td class="ps-1" id="outletName"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="editWifiModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Edit Wifi Modal</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('outlet.wifi') }}" method="POST">
                        @csrf
                        <input type="hidden" id="idWifi" name="id">
                        <div>
                            <label class="form-label">Wifi</label>
                            <input type="text" class="form-control" name="wifi" id="wifi" required>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Edit Wifi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function openModalWifi(id, value) {
            document.getElementById('idWifi').value = id;
            document.getElementById('wifi').value = value;
            $('#editWifiModal').modal('show');
        }

        function detailOutlet(id) {
            $.ajax({
                url: '{{ route('outlet.show') }}',
                method: 'GET',
                data: {
                    id: id
                },
                success: (res) => {
                    const outlet = res.data;

                    document.getElementById('outletName').innerText = outlet.name;

                    $('#detailOutletModal').modal('show');
                }
            });
        }

        function editOutlet(id) {

        }

        function deleteOutlet(id) {

        }
    </script>
@endsection