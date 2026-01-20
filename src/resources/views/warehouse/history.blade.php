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
                        Warehouse History
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
              <h6>History table</h6>
              <div class="row">
                <div class="col-md-6">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search" id="search-product" name="search-product">
                    <button class="btn btn-primary m-0" type="button" onclick="loadHistory()">Search</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0" id="products-table">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Warehouse Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Quantity</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Unit</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Type</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Time</th>
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
@endsection

@section('scripts')
    <script>
        let productList = [];
        let page = 1;
        let totalProductList = 1;

        function loadHistory() {
            const search = document.getElementById('search-product').value;
            fetch('/products/history/list?page=' + page + '&search=' + search)
            .then(response => response.json())
            .then(data => {
                productList = data.data;
                totalProductList = data.meta.total;
                renderHistory(data.data);
                renderPagination();
            })
            .catch(error => {
                console.error(error);
            });
        }

        function renderHistory(history) {
            const tbody = document.getElementById('products-tbody');
            tbody.innerHTML = '';
            history.forEach(history => {
                const row = document.createElement('tr');
                row.innerHTML = `
                <td class="align-middle text-center">${history.user_name}</td>
                <td class="align-middle text-center">${history.product_name}</td>
                <td class="align-middle text-center">${history.warehouse_name}</td>
                <td class="align-middle text-center">${history.quantity}</td>
                <td class="align-middle text-center">${history.product_unit}</td>
                <td class="align-middle text-center">${history.type}</td>
                <td class="align-middle text-center">${history.created_at}</td>`;
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
            loadHistory();
        }
        loadHistory();

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