@extends('layout.index')
@section('title', 'Edit Menu')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Edit Menu</h4>
            </div>
        </div>

        <div class="page-btn">
            <a class="btn btn-primary" onclick="updateMenu()"><i class="ti ti-circle-plus me-1"></i>Update Menu</a>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Menu Information</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Category</label>
                        <select class="form-control" id="category" name="category">
                            <option value="">-- Choose Category --</option>
                            @foreach($category as $item)
                                <option value="{{ $item->id }}" {{ $menu->category_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 list position-relative">
                        <label class="form-label">SKU<span class="text-danger ms-1">*</span></label>
                        <input type="text" class="form-control list" id="sku" value="{{ $menu->sku }}">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Menu Name</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ $menu->name }}" placeholder="Menu Name ...">
                    </div>
                    <div class="mb-3">
                        <label for="hpp" class="form-label">HPP (Harga Pokok Produksi)</label>
                        <input type="number" class="form-control" name="hpp" id="hpp" value="{{ (int)$menu->hpp }}" placeholder="Rp ...">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Base Price</label>
                        <input type="number" class="form-control" name="price" id="price" value="{{ (int)$menu->price }}" placeholder="Rp ...">
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" name="image" id="image">
                    </div>
                    <div class="mb-3">
                        <div class="summer-description-box">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="3" id="summernote">{{ $menu->description }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Variant</h4>
                        <a class="btn btn-info btn-sm" onclick="addVariant()">Add Variant</a>
                    </div>
                </div>
            </div>

            <div id="listVariant"></div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.js"></script>
    <script>
        localStorage.clear();
        loadDataVariant();

        function loadDataVariant() {
            const data = @json($variant);
            let variant = [];

            data.forEach(item => {
                let dataOption = [];
                item.menu_variant_options.forEach(option => {
                    dataOption.push({
                        id: option.id,
                        name: option.name,
                        price: parseInt(option.price_delta),
                        hpp: parseInt(option.hpp),
                        default: option.is_default
                    });
                });

                variant.push({
                    id: item.id,
                    name: item.name,
                    required: item.required === 1,
                    options: dataOption
                });
            });

            localStorage.setItem('variant', JSON.stringify(variant));
            viewVariants();
        }

        function addVariant() {
            const variants = JSON.parse(localStorage.getItem('variant')) ?? [];

            variants.push({
                name: '',
                required: true,
                options: [
                    {
                        name: '',
                        price: 0,
                        hpp: 0,
                        default: true
                    }
                ]
            });

            localStorage.setItem('variant', JSON.stringify(variants));
            viewVariants();
        }

        function viewVariants() {
            const variants = JSON.parse(localStorage.getItem('variant')) ?? [];

            let html = '';
            variants.forEach((variant, indexVariant) => {
                let htmlOption = '';
                variant.options.forEach((option, indexOption) => {
                    htmlOption += `
                        <div class="row mb-3">
                            <div class="col-4">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" value="${option.name}" placeholder="Large ..." oninput="changeOption(${indexVariant}, ${indexOption}, 'name', this.value)">
                            </div>
                            <div class="col-3">
                                <label class="form-label">HPP</label>
                                <input type="number" class="form-control" value="${option.price}" placeholder="Rp ..." oninput="changeOption(${indexVariant}, ${indexOption}, 'hpp', this.value)">
                            </div>
                            <div class="col-3">
                                <label class="form-label">Price Delta</label>
                                <input type="number" class="form-control" value="${option.price}" placeholder="Rp ..." oninput="changeOption(${indexVariant}, ${indexOption}, 'price', this.value)">
                            </div>
                            <div class="col-1">
                                <label class="form-label">Default</label>
                                <div class="form-check form-check-md form-switch mt-1">
                                    <input class="form-check-input" type="checkbox" role="switch" id="switch-md" ${option.default === true ? 'checked' : ''} onchange="changeOption(${indexVariant}, ${indexOption}, 'default', ${option.default})">
                                </div>
                            </div>
                            <div class="col-1">
                                <label class="form-label text-white">-</label>
                                <div>
                                    <a class="btn btn-danger" onclick="deleteVariantOption(${indexVariant}, ${indexOption})">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    `;
                });

                html += `
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-8">
                                    <input type="text" class="form-control" value="${variant.name}" placeholder="Variant Name" onchange="changeVariantName(${indexVariant}, this.value)">
                                </div>
                                <div class="col-2 d-flex align-items-center">
                                    <div class="form-check form-check-md form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="switch-md" ${variant.required === true ? 'checked' : ''} onchange="changeVariantRequired(${indexVariant}, ${variant.required})">
                                        <label class="form-check-label fw-bold" for="switch-md">Required</label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="d-flex"></div>
                                    <a class="btn btn-danger" onclick="deleteVariant(${indexVariant})">Delete</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Variant Option</h5>
                                <a class="btn btn-secondary btn-sm" onclick="addVariantOption(${indexVariant})">Add Variant Option</a>
                            </div>
                        </div>
                        <div class="card-body">
                            ${htmlOption}
                        </div>
                    </div>
                `;
            });

            document.getElementById('listVariant').innerHTML = html;
        }

        function addVariantOption(indexVariant) {
            const variants = JSON.parse(localStorage.getItem('variant')) ?? [];

            variants[indexVariant].options.push({
                name: '',
                price: 0,
                hpp: 0,
                default: false
            });

            localStorage.setItem('variant', JSON.stringify(variants));
            viewVariants();
        }

        function deleteVariantOption(indexVariant, indexOption) {
            const variants = JSON.parse(localStorage.getItem('variant')) ?? [];
            const options = variants[indexVariant].options;

            options.splice(indexOption, 1);

            localStorage.setItem('variant', JSON.stringify(variants));
            viewVariants();
        }

        function deleteVariant(indexVariant) {
            const variants = JSON.parse(localStorage.getItem('variant')) ?? [];
            variants.splice(indexVariant, 1);
            localStorage.setItem('variant', JSON.stringify(variants));
            viewVariants();
        }

        function changeVariantName(indexVariant, value) {
            const variants = JSON.parse(localStorage.getItem('variant')) ?? [];
            variants[indexVariant].name = value;
            localStorage.setItem('variant', JSON.stringify(variants));
        }

        function changeOption(indexVariant, indexOption, type, value) {
            const variants = JSON.parse(localStorage.getItem('variant')) ?? [];
            const option = variants[indexVariant].options[indexOption];

            if (type === 'name') {
                option.name = value;
            } else if (type === 'price') {
                option.price = value;
            } else if (type === 'hpp') {
                option.hpp = value;
            } else {
                if (!value) {
                    option.default = true;

                    variants[indexVariant].options.forEach((opt, i) => {
                        if (i !== indexOption) {
                            opt.default = false;
                        }
                    });
                } else {
                    option.default = false;
                }
            }

            localStorage.setItem('variant', JSON.stringify(variants));

            if (type === 'default') {
                viewVariants();
            }
        }

        function changeVariantRequired(indexVariant, value) {
            const variants = JSON.parse(localStorage.getItem('variant')) ?? [];
            variants[indexVariant].required = !value;
            localStorage.setItem('variant', JSON.stringify(variants));
        }

        function updateMenu() {
            // Validation
            const category = document.getElementById('category').value;
            if (category === null || category === '') {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Category not found.',
                    icon: 'warning',
                });
                return true;
            }

            const name = document.getElementById('name').value;
            if (name === null || name === '') {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Name menu not found.',
                    icon: 'warning',
                });
                return true;
            }

            const price = document.getElementById('price').value;
            if (price === null || price === '') {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Base Price not found.',
                    icon: 'warning',
                });
                return true;
            }

            const variants = JSON.parse(localStorage.getItem('variant')) ?? [];
            variants.forEach((variant) => {
                if (variant.name === null || variant.name === '') {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Name Variant not found.',
                        icon: 'warning',
                    });
                    return true;
                }

                variant.options.forEach((opt) => {
                    if (opt.name === null || opt.name === '') {
                        Swal.fire({
                            title: 'Warning!',
                            text: 'Name Variant Option not found.',
                            icon: 'warning',
                        });
                        return true;
                    }

                    if (opt.price === null || opt.price === '') {
                        Swal.fire({
                            title: 'Warning!',
                            text: 'Price Variant Option not found.',
                            icon: 'warning',
                        });
                        return true;
                    }
                });
            });

            Swal.fire({
                title: 'Are you sure?',
                text: "Update Menu?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "Yes, update it!",
                cancelButtonText: "Cancel",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-danger ml-1"
                },
                buttonsStyling: false
            }).then(function (result) {
                if (result.isConfirmed) {

                    const category = document.getElementById('category').value;
                    const name     = document.getElementById('name').value;
                    const price    = document.getElementById('price').value;
                    const sku      = document.getElementById('sku').value;
                    const desc     = document.getElementById('desc').value;
                    const variants = JSON.parse(localStorage.getItem('variant')) ?? [];

                    const fd = new FormData();
                    fd.append('_token', '{{ csrf_token() }}');
                    fd.append('id', '{{ request()->get('id') }}');
                    fd.append('category', category);
                    fd.append('name', name);
                    fd.append('price', price);
                    fd.append('sku', sku);
                    fd.append('desc', desc);
                    const img = document.getElementById('image').files[0];
                    if (img) fd.append('image', img);
                    fd.append('variants', variants);


                    $.ajax({
                        url: '{{ route('menu.update') }}',
                        method: 'POST',
                        data: fd,
                        processData: false,
                        contentType: false,
                        success: (res) => {
                            if (res.status) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Menu updated successfully.',
                                    icon: 'success',
                                }).then((i) => {
                                    window.location.href = '{{ route('menu.list') }}';
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Menu updated failed.',
                                    icon: 'error',
                                });
                            }
                        }
                    });
                }
            });
        }
    </script>
@endsection