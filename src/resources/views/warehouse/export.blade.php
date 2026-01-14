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
              <h6>Products table</h6>
              <div class="row">
                <div class="col-md-6">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search" id="search-product" name="search-product">
                    <button class="btn btn-primary m-0" type="button" onclick="loadProducts()">Search</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0" id="products-table">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Quantity</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Unit</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Last Export</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody id="products-tbody">
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
        <h5 class="modal-title">Export Product</h5>
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
                        <label for="product-name" class="form-control-label">{{ __('Product Name') }}</label>
                        <div class="@error('user.name')border border-danger rounded-3 @enderror">
                            <input class="form-control" value="" type="text" placeholder="Name" id="product-name" name="product-name" readonly>
                                @error('name')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="user-email" class="form-control-label">{{ __('Quantity') }}</label>
                        <div class="@error('email')border border-danger rounded-3 @enderror">
                            <input class="form-control" value="" type="number" placeholder="Quantity" id="quantity" name="quantity">
                                @error('quantity')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                        </div>
                    </div>
                </div>
            </div>
        </form>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
        <button class="btn btn-primary" type="button" onclick="exportProduct();">Lưu</button>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="createProductModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Create Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        
        <form action="/products/create" method="POST" role="form text-left">
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
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="product-name" class="form-control-label">{{ __('Product Name') }}</label>
                        <div class="@error('user.name')border border-danger rounded-3 @enderror">
                            <input class="form-control" value="" type="text" placeholder="Name" id="create-product-name" name="name">
                                @error('name')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="product-name" class="form-control-label">{{ __('Unit') }}</label>
                        <div class="@error('unit')border border-danger rounded-3 @enderror">
                            <input class="form-control" value="" type="text" placeholder="Unit" id="create-product-unit" name="unit">
                                @error('unit')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="create-product-quantity" class="form-control-label">{{ __('Quantity') }}</label>
                        <div class="@error('quantity')border border-danger rounded-3 @enderror">
                            <input class="form-control" value="" type="number" placeholder="Quantity" id="create-product-quantity" name="quantity">
                                @error('quantity')
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
        <button class="btn btn-primary" type="button" onclick="saveProduct();">Save</button>
      </div>

    </div>
  </div>
</div>
@endsection

@section('scripts')
    <script>
        let productList = [];
        let page = 1;
        let totalProductList = 1;
        const modalEl = document.getElementById('exampleModal');
        const modalImport = new bootstrap.Modal(modalEl);
        const modalCreateProductEl = document.getElementById('createProductModal');
        const modalCreateProduct = new bootstrap.Modal(modalCreateProductEl);

        function loadProducts() {
            const search = document.getElementById('search-product').value;
            fetch('/products/list?page=' + page + '&search=' + search)
            .then(response => response.json())
            .then(data => {
                productList = data.data;
                totalProductList = data.meta.total;
                renderProducts(data.data);
                renderPagination();
            })
            .catch(error => {
                console.error(error);
            });
        }

        function renderProducts(products) {
            const tbody = document.getElementById('products-tbody');
            tbody.innerHTML = '';
            products.forEach(product => {
                const row = document.createElement('tr');
                row.innerHTML = `<td class="align-middle text-center">${product.name}</td>
                <td class="align-middle text-center">${product.quantity}</td>
                <td class="align-middle text-center">${product.unit}</td>
                <td class="align-middle text-center">${product?.last_export ? product.last_export.format('DD/MM/YYYY') : '-'}</td>
                <td><button type="button" class="btn btn-primary" onclick="openModal(${product.id})">Export</button></td>`;
                tbody.appendChild(row);
            });
        }

        function openModal(productId) {
            const product = productList.find(product => product.id === productId);
            document.getElementById('product-id').value = product.id;
            document.getElementById('product-name').value = product.name;
            document.getElementById('quantity').value = 1;
            modalImport.show();
        }

        function exportProduct() {
            const productId = document.getElementById('product-id').value;
            const quantity = document.getElementById('quantity').value;
            const userName = document.getElementById('user-name').value;
            console.log(productId, quantity, userName);
            fetch('/products/export', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity,
                    user_name: userName
                })
            }).then(response => response.json())
            .then(data => {
                modalImport.hide();
                loadProducts();
            })
            .catch(error => {
                alert(error.message);
            });
        }
        
        function renderPagination() {
            const totalPages = Math.ceil(totalProductList / 10);

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
            loadProducts();
        }
        loadProducts();

        function createProduct() {
            document.getElementById('create-product-name').value = '';
            document.getElementById('create-product-unit').value = '';
            document.getElementById('create-product-quantity').value = '';
            modalCreateProduct.show();
        }

        function saveProduct() {
            const productName = document.getElementById('create-product-name').value;
            const unit = document.getElementById('create-product-unit').value;
            const quantity = document.getElementById('create-product-quantity').value;
            console.log(productName, unit, quantity);
            fetch('/products/create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    name: productName,
                    unit: unit,
                    quantity: quantity
                })
            }).then(response => response.json())
            .then(data => {
                modalCreateProduct.hide();
                loadProducts();
            })
            .catch(error => {
                alert(error.message);
            });
        }
    </script>
@endsection