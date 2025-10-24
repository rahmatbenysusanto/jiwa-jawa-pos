@extends('layout.index')
@section('title', 'Create Recipe Addon')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Create Recipe Addon</h4>
            </div>
        </div>
        <div class="page-btn">
            <a class="btn btn-primary" onclick="createRecipe()"><i class="ti ti-circle-plus me-1"></i>Create Recipe</a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Data Addon</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div>
                                <label class="form-label">List Addon</label>
                                <select class="form-control" onchange="changeAddon(this.value)">
                                    <option value="">-- Choose Addon --</option>
                                    @foreach($addon as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-5">
                            <div>
                                <label class="form-label">Variant Addon</label>
                                <select class="form-control" id="variantAddon">

                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div>
                                <label class="form-label text-white">-</label>
                                <div>
                                    <a class="btn btn-info w-100" onclick="addToList()">Add</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Recipe</h4>
                </div>
                <div class="card-body">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Variant Addon</th>
                                <th>Recipe Material</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="listVariantAddon">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add-material">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="page-title">
                        <h4>Add Material</h4>
                    </div>
                    <button type="button" class="close bg-danger text-white fs-16" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="indexAddon">
                    <div class="mb-3">
                        <label class="form-label">Material</label>
                        <select class="form-control" id="listMaterial">
                            <option value="">-- Choose Material --</option>
                            @foreach($material as $item)
                                <option value="{{ $item->id }}">{{ $item->name }} | {{ $item->baseUnit->symbol }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">QTY</label>
                        <input type="number" class="form-control" id="qtyMaterial">
                    </div>
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-primary" onclick="addMaterialProcess()">Add Material</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        localStorage.clear();
        loadMaterial();

        function loadMaterial() {
            const data = @json($material);
            const material = [];

            console.log(data);

            data.forEach((item) => {
                material.push({
                    id: item.id,
                    name: item.name,
                    unit: item.base_unit.symbol,
                });
            });

            localStorage.setItem('material', JSON.stringify(material));
        }

        function changeAddon(id) {
            $.ajax({
                url: '{{ route('menu.find.variant.addon') }}',
                method: 'GET',
                data: {
                    id: id
                },
                success: (res) => {
                    const data = res.data;
                    let html = '<option value="">-- Choose Variant Addon --</option>'

                    data.forEach((item) => {
                        html += `<option value="${item.id}">${item.name}</option>`;
                    });

                    document.getElementById('variantAddon').innerHTML = html;
                }
            });
        }

        function addToList() {
            const variantAddonId = document.getElementById('variantAddon').value;

            $.ajax({
                url: '{{ route('menu.variant.addon.find') }}',
                method: 'GET',
                data: {
                    id: variantAddonId,
                },
                success: (res) => {
                    const data = res.data;
                    const variantAddon = JSON.parse(localStorage.getItem('variantAddon')) ?? [];
                    const check = variantAddon.find((item) => item.id === data.id);
                    console.log(check)
                    if (check !== undefined) {
                        Swal.fire({
                            title: 'Warning!',
                            text: 'Variant Addon already on the list',
                            icon: 'warning',
                        });

                        return true;
                    }

                    variantAddon.push({
                        id: data.id,
                        name: data.name,
                        material: []
                    });

                    localStorage.setItem('variantAddon', JSON.stringify(variantAddon));
                    viewVariantAddon();
                }
            });
        }

        function viewVariantAddon() {
            const variantAddon = JSON.parse(localStorage.getItem('variantAddon')) ?? [];
            let html = '';

            variantAddon.forEach((item, index) => {
                let material = '';
                (item.material).forEach((mtr, indexMtr) => {
                    material += `
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <div><b>${mtr.name}</b> - ${mtr.qty} ${mtr.unit}</div>
                            <a class="btn btn-danger btn-sm" onclick="deleteMaterial(${index}, ${indexMtr})">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>`;
                });

                html += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.name}</td>
                        <td>${material}</td>
                        <td>
                            <a class="btn btn-info btn-sm" onclick="addMaterial(${index})">Add Material</a>
                            <a class="btn btn-danger btn-sm" onclick="deleteVariantAddon(${index})"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                `;
            });

            document.getElementById('listVariantAddon').innerHTML = html;
        }

        function addMaterial(index) {
            document.getElementById('indexAddon').value= index;
            $('#add-material').modal('show');
        }

        function addMaterialProcess() {
            const selectMaterial = document.getElementById('listMaterial').value;
            const material = JSON.parse(localStorage.getItem('material')) ?? [];
            const materialAddon = material.find((item) => parseInt(item.id) === parseInt(selectMaterial));
            const index = document.getElementById('indexAddon').value;
            const qty = document.getElementById('qtyMaterial').value;
            const variantAddon = JSON.parse(localStorage.getItem('variantAddon')) ?? [];
            const findAddon = variantAddon[index].material;

            findAddon.push({
                id: materialAddon.id,
                name: materialAddon.name,
                qty: qty,
                unit: materialAddon.unit,
            });

            localStorage.setItem('variantAddon', JSON.stringify(variantAddon));
            viewVariantAddon();

            document.getElementById('listMaterial').value = '';
            document.getElementById('qtyMaterial').value = '';
            $('#add-material').modal('hide');
        }

        function deleteVariantAddon(index) {
            const variantAddon = JSON.parse(localStorage.getItem('variantAddon')) ?? [];

            variantAddon.splice(index, 1);
            localStorage.setItem('variantAddon', JSON.stringify(variantAddon));
            viewVariantAddon();
        }

        function deleteMaterial(index, indexMTR) {
            const variantAddon = JSON.parse(localStorage.getItem('variantAddon')) ?? [];
            const addon = variantAddon[index].material;

            addon.splice(indexMTR, 1);

            localStorage.setItem('variantAddon', JSON.stringify(variantAddon));
            viewVariantAddon();
        }

        function createRecipe() {
            Swal.fire({
                title: "Are you sure?",
                text: "Create recipe addon",
                icon: "warning",
                showCancelButton: true,
                customClass: {
                    confirmButton: "btn btn-primary w-xs me-2 mt-2",
                    cancelButton: "btn btn-danger w-xs mt-2"
                },
                confirmButtonText: "Yes, Create it!",
                buttonsStyling: false,
                showCloseButton: true
            }).then((i) => {
                if (i.value) {

                    $.ajax({
                        url: '{{ route('menu.recipe.store') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            variantAddon: JSON.parse(localStorage.getItem('variantAddon')),
                        },
                        success: (res) => {
                            if (res.status) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Create recipe addon successfully!',
                                    icon: 'success',
                                }).then((i) => {
                                    window.location.href = '{{ route('menu.recipe') }}';
                                });
                            }
                        }
                    });

                }
            });
        }
    </script>
@endsection





























