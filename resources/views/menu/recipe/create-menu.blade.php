@extends('layout.index')
@section('title', 'Create Recipe Menu')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Create Recipe Menu</h4>
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
                    <h4 class="card-title mb-0">Menu</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">List Menu</label>
                                <select class="form-control" id="menu">
                                    <option value="">-- Choose Menu --</option>
                                    @foreach($menu as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label text-white">-</label>
                                <div>
                                    <a class="btn btn-info" onclick="selectMenu()">Select Menu</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">

                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Recipe Basic Menu</h4>
                        <a class="btn btn-info" onclick="addMaterial()">Add Material</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Material</th>
                                        <th>QTY</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="recipeBasicMenu">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Recipe Variant Menu</h4>
                </div>
                <div class="card-body">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Variant</th>
                                <th>Option</th>
                                <th>Material</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="materialVariant">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addMaterialModal">
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
                    <input type="hidden" id="type">
                    <input type="hidden" id="indexVariant">
                    <div class="mb-3">
                        <label class="form-label">Material</label>
                        <select class="form-control" id="listMaterial">

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
            const dataMaterial = @json($material);
            const material = [];

            dataMaterial.forEach((item) => {
                material.push({
                    id: item.id,
                    name: item.name,
                    unit: item.base_unit.symbol,
                });
            });

            localStorage.setItem('material', JSON.stringify(material));
        }

        function selectMenu() {
            const menuId = document.getElementById('menu').value;

            $.ajax({
                url: '{{ route('menu.find.menu') }}',
                method: 'GET',
                data: {
                    menuId: menuId
                },
                success: (res) => {
                    const menu = res.data.menu;
                    const dataVariant = res.data.variant;
                    const variant = [];

                    console.log(res.data.variant);
                    dataVariant.forEach((item) => {
                        (item.menu_variant_options).forEach((option) => {
                            variant.push({
                                variantId: item.id,
                                variantName: item.name,
                                optionId: option.id,
                                optionName: option.name,
                                material: []
                            });
                        });
                    });

                    localStorage.setItem('menu', JSON.stringify(menu));
                    localStorage.setItem('variant', JSON.stringify(variant));

                    viewVariant();
                }
            });
        }

        function viewVariant() {
            const variant = JSON.parse(localStorage.getItem('variant')) ?? [];
            let html = '';

            variant.forEach((item, index) => {
                let material = '';
                (item.material).forEach((mtr, indexMTR) => {
                    material += `
                        <div class="d-flex justify-content-between align-items-center">
                            <div>${mtr.name} | ${mtr.qty} ${mtr.unit}</div>
                            <a class="btn btn-danger btn-sm" onclick="deleteMaterialVariant(${index}, ${indexMTR})"><i class="fa fa-trash"></i></a>
                        </div>
                    `;
                });

                html += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.variantName}</td>
                        <td>${item.optionName}</td>
                        <td>${material}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a class="btn btn-info btn-sm" onclick="addMaterialVariant(${index})">Add Material</a>
                                <a class="btn btn-danger btn-sm" onclick="deleteVariant(${index})">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                `;
            });

            document.getElementById('materialVariant').innerHTML = html;
        }

        function deleteMaterialVariant(index, indexMTR) {
            const variant = JSON.parse(localStorage.getItem('variant')) ?? [];
            const find = variant[index].material;

            find.splice(indexMTR, 1);

            localStorage.setItem('variant', JSON.stringify(variant));
            viewVariant();
        }

        function deleteVariant(index) {
            const variant = JSON.parse(localStorage.getItem('variant')) ?? [];
            variant.splice(index, 1);
            localStorage.setItem('variant', JSON.stringify(variant));
            viewVariant();
        }

        function viewMaterialBasic() {
            const materialBasicMenu = JSON.parse(localStorage.getItem('materialBasicMenu')) ?? [];
            let html = '';

            materialBasicMenu.forEach((item, index) => {
                html += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.name}</td>
                        <td>${item.qty} ${item.unit}</td>
                        <td>
                            <a class="btn btn-danger btn-sm" onclick="deleteMaterialBasic(${index})"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                `;
            });

            document.getElementById('recipeBasicMenu').innerHTML = html;
        }

        function deleteMaterialBasic(index) {
            const materialBasicMenu = JSON.parse(localStorage.getItem('materialBasicMenu')) ?? [];
            materialBasicMenu.splice(index, 1);
            localStorage.setItem('materialBasicMenu', JSON.stringify(materialBasicMenu));
            viewMaterialBasic();
        }

        function addMaterialVariant(index) {
            const material = JSON.parse(localStorage.getItem('material')) ?? [];
            let html = '<option value="">-- Choose Material --</option>';
            material.forEach((item, index) => {
                html += `<option value="${item.id}">${item.name}</option>`;
            });
            document.getElementById('listMaterial').innerHTML = html;

            document.getElementById('type').value = 'variant';
            document.getElementById('indexVariant').value = index;

            $('#addMaterialModal').modal('show');
        }

        function addMaterial() {
            // List Material
            const material = JSON.parse(localStorage.getItem('material')) ?? [];
            let html = '<option value="">-- Choose Material --</option>';
            material.forEach((item, index) => {
                html += `<option value="${item.id}">${item.name}</option>`;
            });
            document.getElementById('listMaterial').innerHTML = html;

            document.getElementById('type').value = 'basic';

            $('#addMaterialModal').modal('show');
        }

        function addMaterialProcess() {
            const material = JSON.parse(localStorage.getItem('material')) ?? [];
            const materialBasicMenu = JSON.parse(localStorage.getItem('materialBasicMenu')) ?? [];
            const type = document.getElementById('type').value;
            const materialId = document.getElementById('listMaterial').value;
            const findMaterial = material.find((item) => item.id === parseInt(materialId));
            const qty = document.getElementById('qtyMaterial').value;

            if (type === 'basic') {
                materialBasicMenu.push({
                    id: materialId,
                    name: findMaterial.name,
                    qty: qty,
                    unit: findMaterial.unit,
                });

                localStorage.setItem('materialBasicMenu', JSON.stringify(materialBasicMenu));

                document.getElementById('listMaterial').value = '';
                document.getElementById('qtyMaterial').value = '';
                $('#addMaterialModal').modal('hide');

                viewMaterialBasic();
            } else {
                const variant = JSON.parse(localStorage.getItem('variant')) ?? [];
                const index = document.getElementById('indexVariant').value;
                const find = variant[index].material;

                find.push({
                    id: materialId,
                    name: findMaterial.name,
                    qty: qty,
                    unit: findMaterial.unit,
                });

                localStorage.setItem('variant', JSON.stringify(variant));

                document.getElementById('listMaterial').value = '';
                document.getElementById('qtyMaterial').value = '';
                document.getElementById('indexVariant').value = '';
                $('#addMaterialModal').modal('hide');

                viewVariant();
            }
        }

        function createRecipe() {
            Swal.fire({
                title: "Are you sure?",
                text: "Create recipe Menu",
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
                        url: '{{ route('menu.recipe.menu.store') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            menu: JSON.parse(localStorage.getItem('menu')) ?? [],
                            materialBasicMenu: JSON.parse(localStorage.getItem('materialBasicMenu')) ?? [],
                            variant: JSON.parse(localStorage.getItem('variant')) ?? [],
                        },
                        success: (res) => {
                            if (res.status) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Recipe created successfully',
                                    icon: 'success',
                                }).then((i) => {
                                    window.location.href = '{{ route('menu.recipe') }}';
                                });
                            }
                        }
                    });

                }
            })
        }
    </script>
@endsection











