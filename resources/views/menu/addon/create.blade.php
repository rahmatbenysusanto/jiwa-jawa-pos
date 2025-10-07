@extends('layout.index')
@section('title', 'Create Addon')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Create Add on</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Addon Information</h4>
                        <a class="btn btn-primary" onclick="createAddonProcess()">Create Addon</a>
                    </div>
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label">Addon Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Addon Name ...">
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Variant</h4>
                            <a class="btn btn-info btn-sm" onclick="addVariant()">Add Variant</a>
                        </div>
                        <div class="row" id="listVariant">

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        localStorage.clear();

        function addVariant() {
            const variant = JSON.parse(localStorage.getItem('variant')) ?? [];

            variant.push({
                name: '',
                price: 0
            });

            localStorage.setItem('variant', JSON.stringify(variant));
            viewVariant();
        }

        function viewVariant() {
            const variant = JSON.parse(localStorage.getItem('variant')) ?? [];
            let html = '';

            variant.forEach((item, index) => {
                html += `
                    <div class="col-5 mb-3">
                        <label class="form-label">Variant Name</label>
                        <input type="text" class="form-control" value="${item.name}" placeholder="Variant name ..." oninput="changeOption(${index}, 'name', this.value)">
                    </div>
                    <div class="col-5 mb-3">
                        <label class="form-label">Variant Price</label>
                        <input type="number" class="form-control" value="${item.price}" placeholder="Rp 0" oninput="changeOption(${index}, 'price', this.value)">
                    </div>
                    <div class="col-2 mb-3">
                        <label class="form-label text-white">-</label>
                        <div>
                            <a class="btn btn-danger" onclick="deleteVariant(${index})">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    </div>
                `;
            });

            document.getElementById('listVariant').innerHTML = html;
        }

        function deleteVariant(id) {
            const variant = JSON.parse(localStorage.getItem('variant')) ?? [];
            variant.splice(id, 1);
            localStorage.setItem('variant', JSON.stringify(variant));
            viewVariant();
        }

        function changeOption(index, type, value) {
            const variant = JSON.parse(localStorage.getItem('variant')) ?? [];

            if (type === 'name') {
                variant[index].name = value;
            } else {
                variant[index].price = value;
            }

            localStorage.setItem('variant', JSON.stringify(variant));
        }

        function createAddonProcess() {
            Swal.fire({
                title: 'Are you sure?',
                text: "Create New Addon?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "Yes, create it!",
                cancelButtonText: "Cancel",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-danger ml-1"
                },
                buttonsStyling: false
            }).then(function (result) {
                if (result.isConfirmed) {

                    $.ajax({
                        url: '{{ route('menu.addon.store') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            name: document.getElementById('name').value,
                            variant: JSON.parse(localStorage.getItem('variant')) ?? [],
                        },
                        success: (result) => {
                            if (result.status) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Create Addon Success!',
                                    icon: 'success',
                                }).then((i) => {
                                    window.location.href = '{{ route('menu.addon') }}';
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Create Addon Failed!',
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