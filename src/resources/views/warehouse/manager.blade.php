@extends('warehouse.main')

@section('content')

<div>
    <div class="container-fluid">
        <div class="page-header border-radius-xl mt-4" style="min-height:80px; background-image: url('../assets/img/curved-images/curved0.jpg'); background-position-y: 50%;">
            <span class="mask bg-gradient-primary opacity-6"></span>
        </div>
        <div class="card card-body blur shadow-blur mx-4 mt-n4">
            <div class="row gx-4">
                <div class="col-lg-4 col-md-6 my-sm-auto">
                    <div class="nav-wrapper position-relative end-0">
                        Warehouse
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Warehouse Manager</h6>
              <div class="row">
                <div class="col-md-6">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search" id="search-warehouse" name="search-warehouse">
                    <button class="btn btn-primary m-0" type="button" onclick="loadWarehouses()">Search</button>
                  </div>
                </div>
                <div class="col-md-6 text-end">
                  <button class="btn btn-primary" type="button" onclick="createWarehouse()">Create</button>
                </div>
              </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0" id="warehouses-table">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Description</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Timestamp</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody id="warehouses-tbody">
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="6" class="text-center" id="pagination">
                        
                      </td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Import Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        
        <form action="/user-profile" method="POST" role="form text-left">
            @csrf
            @if($errors->any())
                <div class="mt-3  alert alert-primary alert-dismissible fade show" role="alert">
                    <span class="alert-text text-white">
                    {{$errors->first()}}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <i class="fa fa-close" aria-hidden="true"></i>
                    </button>
                </div>
            @endif
            @if(session('success'))
                <div class="m-3  alert alert-success alert-dismissible fade show" id="alert-success" role="alert">
                    <span class="alert-text text-white">
                    {{ session('success') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <i class="fa fa-close" aria-hidden="true"></i>
                    </button>
                </div>
            @endif
            <input type="hidden" id="product-id" name="product-id">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="user-name" class="form-control-label">{{ __('Full Name') }}</label>
                        <div class="@error('user.name')border border-danger rounded-3 @enderror">
                            <input class="form-control" value="" type="text" placeholder="Name" id="user-name" name="name">
                                @error('name')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="description" class="form-control-label">{{ __('Description') }}</label>
                        <div class="@error('user.name')border border-danger rounded-3 @enderror">
                            <textarea class="form-control" placeholder="Description" id="description" name="description"></textarea>
                                @error('description')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                        </div>
                    </div>
                </div>
            </div>
        </form>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary" type="button" onclick="createWarehouse();">Save</button>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="createWarehouseModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Warehouse Manager</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        
        <form action="/warehouses/create" method="POST" role="form text-left">
            @csrf
            <input type="hidden" id="warehouse-id" name="warehouse-id">
            @if($errors->any())
                <div class="mt-3  alert alert-primary alert-dismissible fade show" role="alert">
                    <span class="alert-text text-white">
                    {{$errors->first()}}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <i class="fa fa-close" aria-hidden="true"></i>
                    </button>
                </div>
            @endif
            @if(session('success'))
                <div class="m-3  alert alert-success alert-dismissible fade show" id="alert-success" role="alert">
                    <span class="alert-text text-white">
                    {{ session('success') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <i class="fa fa-close" aria-hidden="true"></i>
                    </button>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="create-warehouse-name" class="form-control-label">{{ __('Warehouse Name') }}</label>
                        <div class="@error('user.name')border border-danger rounded-3 @enderror">
                            <input class="form-control" value="" type="text" placeholder="Name" id="create-warehouse-name" name="name">
                                @error('name')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="create-warehouse-description" class="form-control-label">{{ __('Description') }}</label>
                        <div class="@error('description')border border-danger rounded-3 @enderror">
                            <textarea class="form-control" placeholder="Description" id="create-warehouse-description" name="description"></textarea>
                                @error('description')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                        </div>
                    </div>
                </div>
            </div>
        </form>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary" type="button" onclick="saveWarehouse();">Save</button>
      </div>

    </div>
  </div>
</div>
@endsection

@section('scripts')
    <script>
        let warehouseList = [];
        let page = 1;
        let totalWarehouseList = 1;
        const modalEl = document.getElementById('exampleModal');
        const modalImport = new bootstrap.Modal(modalEl);
        const modalCreateWarehouseEl = document.getElementById('createWarehouseModal');
        const modalCreateWarehouse = new bootstrap.Modal(modalCreateWarehouseEl);

        function loadWarehouses() {
            const search = document.getElementById('search-warehouse').value;
            fetch('/warehouse/list?page=' + page + '&search=' + search)
            .then(response => response.json())
            .then(data => {
                warehouseList = data.data;
                totalWarehouseList = data.meta.total;
                renderWarehouses(data.data);
                renderPagination();
            })
            .catch(error => {
                console.error(error);
            });
        }

        function renderWarehouses(warehouses) {
            const tbody = document.getElementById('warehouses-tbody');
            tbody.innerHTML = '';
            warehouses.forEach(warehouse => {
                const row = document.createElement('tr');
                row.innerHTML = `<td class="align-middle text-center">${warehouse.name}</td>
                <td class="align-middle text-center">${warehouse.description}</td>
                <td class="align-middle text-center">${warehouse.created_at}</td>
                <td><button type="button" class="btn btn-primary btn-sm m-0 p-2" onclick="openModal(${warehouse.id})">Edit</button></td>`;
                tbody.appendChild(row);
            });
        }

        function openModal(warehouseId) {
            const warehouse = warehouseList.find(warehouse => warehouse.id === warehouseId);
            document.getElementById('warehouse-id').value = warehouse.id;
            document.getElementById('create-warehouse-name').value = warehouse.name;
            document.getElementById('create-warehouse-description').value = warehouse.description;
            modalCreateWarehouse.show();
        }

        function editWarehouse() {
            const warehouseId = document.getElementById('warehouse-id').value;
            const name = document.getElementById('warehouse-name').value;
            const description = document.getElementById('warehouse-description').value;
            console.log(warehouseId, name, description);
            fetch('/warehouses/edit', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    id: warehouseId,
                    name: name,
                    description: description
                })
            }).then(response => response.json())
            .then(data => {
                modalImport.hide();
                loadWarehouses();
            })
            .catch(error => {
                alert(error.message);
            });
        }
        
        function renderPagination() {
            const totalPages = Math.ceil(totalWarehouseList / 10);

            document.getElementById('pagination').innerHTML = `
                <button class="btn btn-primary btn-sm m-0 p-2" ${page === 1 ? 'disabled' : ''} onclick="changePage(${page - 1})">Prev</button>
                ${Array.from({ length: totalPages }, (_, i) => `
                    <button class="btn btn-primary btn-sm m-0 p-2" ${page === i + 1 ? 'disabled' : ''} onclick="changePage(${i + 1})">
                        ${i + 1}
                    </button>
                `).join('')}
                <button class="btn btn-primary btn-sm m-0 p-2" ${page === totalPages ? 'disabled' : ''} onclick="changePage(${page + 1})">Next</button>
            `;
        }

        function changePage(pageChange) {
            page = pageChange;
            loadWarehouses();
        }
        loadWarehouses();

        function createWarehouse() {
            document.getElementById('create-warehouse-name').value = '';
            document.getElementById('create-warehouse-description').value = '';
            document.getElementById('warehouse-id').value = '';
            modalCreateWarehouse.show();
        }

        function saveWarehouse() {
            const warehouseName = document.getElementById('create-warehouse-name').value;
            const warehouseId = document.getElementById('warehouse-id').value;
            const description = document.getElementById('create-warehouse-description').value;
            console.log(warehouseId, warehouseName, description);
            fetch('/warehouse/create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    id: warehouseId,
                    name: warehouseName,
                    description: description
                })
            }).then(response => response.json())
            .then(data => {
                modalCreateWarehouse.hide();
                loadWarehouses();
            })
            .catch(error => {
                alert(error.message);
            });
        }
    </script>
@endsection