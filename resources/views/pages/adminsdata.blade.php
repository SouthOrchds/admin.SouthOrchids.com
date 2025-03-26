@extends('layouts.app')

@section('title', 'Admins List Page')

@section('content')
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td{
        border: 1px solid black;
        padding: 8px;
        text-align: center;
    }
</style>
<div>    
    <div class="p-3 max-sm:p-2">
        <div class="py-3 max-sm:py-2">
            <h1 class="text-3xl font-medium max-sm:text-2xl">Admins <span id="totalCount" class="text-2xl max-sm:text-xl">( Total: )</span></h1>
        </div>
        
        <div class="flex justify-between py-3 max-sm:py-4">
            <form action="">
                <div class="">
                    <div>
                        <input type="text" name="search" id="searchInput" placeholder="Search" class="p-1 border border-black w-96 max-sm:w-full">
                        <p class="px-1 text-sm text-gray-600 max-sm:text-xs">Enter email or phone number</p>
                    </div>
                </div>
            </form>
            
            <div>
                <a class="px-4 py-1 font-medium text-white bg-blue-500 border rounded max-sm:px-2 max-sm:py-1 max-sm:text-sm" id="addNewUser" href="{{ route('Register') }}">Add New</a>
            </div>
        </div>
        
        <div class="max-sm:py-3 max-sm:text-sm max-sm:overflow-x-scroll">
            <table>
                <thead class="">
                    <th>Id</th>
                    <th>Created At</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone_No</th>
                    <th>Permission</th>
                    <th>Status</th>
                    <th>Action</th>
                </thead>
                <tbody id="tableBody">

                    
                    @if ($admins->count() > 0)
                    @foreach ($admins as $admin )
                    
                    @php
                        $permissionCount = \App\Models\Admin_permission::where('admin_id', $admin->id)->count();
                    @endphp
                       <tr class="{{ $admin->status == 'active' ? 'bg-white' : 'bg-red-300'}}">
                           <td>{{ $admin->id }}</td>
                           <td>{{ \Carbon\Carbon::parse($admin->created_at)->format('d-m-Y') }}</td>
                           <td>{{ $admin->name }}</td>
                           <td>{{ $admin->email }}</td>
                           <td>{{ $admin->phone_no }}</td>
                           <td>{{ $permissionCount }}</td>
                           <td>{{ $admin->status }}</td>
                           <td>
                              <button type="button" class="px-2 py-1 border bg-green-700 rounded text-sm btn btn-primary" data-bs-toggle="modal" data-bs-target="#adminPermission" data-admin-id="{{ $admin->id }}" onclick="setAdminId(this)">
                                <i class="fa-solid fa-user-lock"></i>
                              </button>
                              <button class="px-2 py-1 border bg-yellow-500 rounded text-sm btn btn-primary" data-bs-toggle="modal" data-bs-target="#editAdmin">
                                <i class="fa-regular fa-pen-to-square"></i>
                              </button>
                           </td>
                       </tr>
                    @endforeach
                    
                    @else
                    <tr>
                        <td colspan="8" class="text-center">No admins found.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
  
  <!--Edit Admin Modal -->
  <div class="modal fade" id="editAdmin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editAdminLabel">Edit</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="">
            
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </div>
  </div>
    
  <!--Admin Permission Modal -->
  <div class="modal fade" id="adminPermission" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editAdminLabel">Permission</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        @if (Auth::user()->id == 1)
          <form action="">
            <div class="p-3">
                <div>
                    <p class="font-medium text-lg">Dashboard</p>
                    <div class="flex flex-wrap gap-x-10 gap-y-4 p-3">
                        <div>
                            <input type="checkbox" name="permission[]" id="dashboard_index" value="dashboard">
                            <label for="dashboard_index">Index</label>
                        </div>
                    </div>
                </div>
                <div>
                    <p class="font-medium text-lg">Admin</p>
                    <div class="flex flex-wrap gap-x-10 gap-y-4 p-3">
                        <div>
                            <input type="checkbox" name="permission[]" id="admin_index" value="admin.users">
                            <label for="admin_index">Index</label>
                        </div>
                        <div>
                            <input type="checkbox" name="permission[]" id="admin_register" value="Register">
                            <label for="admin_register">Register</label>
                        </div>
                        <div>
                            <input type="checkbox" name="permission[]" id="admin_permission" value="admin.permission">
                            <label for="admin_permission">Set Permission</label>
                        </div>
                    </div>
                </div>
                <div>
                    <p class="font-medium text-lg">Customer</p>
                    <div class="flex flex-wrap gap-x-10 gap-y-4 p-3">
                        <div>
                            <input type="checkbox" name="permission[]" id="customer_index" value="usersdata">
                            <label for="customer_index">Index</label>
                        </div>
                        <div>
                            <input type="checkbox" name="permission[]" id="cart" value="cart">
                            <label for="cart">Cart List</label>
                        </div>
                        <div>
                            <input type="checkbox" name="permission[]" id="order_details" value="user.ordersDetails">
                            <label for="order_details">Order Details</label>
                        </div>
                        <div>
                            <input type="checkbox" name="permission[]" id="order_items" value="user.orderItems">
                            <label for="order_items">Order Items</label>
                        </div>
                        <div>
                            <input type="checkbox" name="permission[]" id="shipped_orders" value="user.shippedOrders">
                            <label for="shipped_orders">Sipped Orders</label>
                        </div>
                    </div>
                </div>
                <div>
                    <p class="font-medium text-lg">Product</p>
                    <div class="flex flex-wrap gap-x-10 gap-y-4 p-3">
                        <div>
                            <input type="checkbox" name="permission[]" id="products" value="products">
                            <label for="products">Index</label>
                        </div>
                        <div>
                            <input type="checkbox" name="permission[]" id="add_product" value="addproduct">
                            <label for="add_product">Add Items</label>
                        </div>
                    </div>
                </div>
                <div>
                    <p class="font-medium text-lg">Transaction</p>
                    <div class="flex flex-wrap gap-x-10 gap-y-4 p-3">
                        <div>
                            <input type="checkbox" name="permission[]" id="transactions" value="transactions">
                            <label for="transactions">Index</label>
                        </div>
                    </div>
                </div>
            </div>
          </form>
        @else
          <div class="flex justify-center p-5">
            <img src="{{ asset('images/onnum ila vadivel.png') }}" alt="" class="h-44 w-44">
          </div>
              
        @endif
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="permission()">Submit</button>
        </div>
    </div>
</div>
</div>

</div>

<script>
    
    
    const dashboardIndex = document.querySelector('#dashboard_index:checked');
    const adminIndex = document.querySelector('#admin_index:checked');
    const adminRegister = document.querySelector('#admin_register:checked');
    const adminPermission = document.querySelector('#admin_permission:checked');
    const customerIndex = document.querySelector('#customer_index:checked');
    const cart = document.querySelector('#cart:checked');
    const orderDetails = document.querySelector('#order_details:checked');
    const orderItems = document.querySelector('#order_items:checked');
    const shippedOrders = document.querySelector('#shipped_orders:checked');
    const products = document.querySelector('#products:checked');
    const addProduct = document.querySelector('#add_product:checked');
    const transactions = document.querySelector('#transactions:checked');
    
    let selectedAdminId = null;
    
    window.setAdminId = function(button) {
        
        selectedAdminId = button.getAttribute('data-admin-id');
        
        fetch(`/permission/${selectedAdminId}`)
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                updateCheckBox(data.permissions);
            }
        })
    }
    
    function permission() {
        let selectedPermissions = [];
        
        document.querySelectorAll('input[name="permission[]"]:checked').forEach(checkbox => {
            selectedPermissions.push(checkbox.value);
        })
        
        fetch(`/permission/${selectedAdminId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                permission : selectedPermissions
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Permission updated successfully');
                updateCheckBox(data.permissions);
                location.reload();
            }
            else {
                alert('Failed to update permission');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
    
    function updateCheckBox(permissions) {
        // initially checkbox statuse false(unselected)
        document.querySelectorAll('input[name="permission[]"]').forEach((checkbox) => {
            checkbox.checked = false;
        })
        // Loop through the fetched permissions and check the matching checkboxes
        permissions.forEach(permission => {
            let checkbox = document.querySelector(`input[name="permission[]"][value="${permission.permissions}"]`);
            if (checkbox) {
                checkbox.checked = true;
            }
        });
        
    }
    
    document.addEventListener('DOMContentLoaded', () => {
        
        const searchInput = document.getElementById('searchInput');
        const tableBody = document.getElementById('tableBody');
        
        function searchAdmin() {
            search = searchInput.value;
            
            fetch(`/admin-search?search=${search}`)
            .then(response => response.json())
        .then(admins => {
            console.log(admins);
            tableBody.innerHTML = '';
            if(admins.length > 0){
                admins.forEach(admin => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                    <td>${ admin.id }</td>
                    <td>${ admin.created_at }</td>
                    <td>${ admin.name }</td>
                    <td>${ admin.email }</td>
                    <td>${ admin.phone_no }</td>
                    <td>${ admin.permissionCount }</td>
                    <td>${ admin.status }</td>
                    <td>
                        <button type="button" class="px-2 py-1 border bg-green-700 rounded text-sm btn btn-primary" data-bs-toggle="modal" data-bs-target="#adminPermission" data-admin-id="{{ $admin->id }}" onclick="setAdminId(this)">
                            <i class="fa-solid fa-user-lock"></i>
                        </button>
                        <button class="px-2 py-1 border bg-yellow-500 rounded text-sm btn btn-primary" data-bs-toggle="modal" data-bs-target="#editAdmin">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </button>
                    </td>
                    `;
                    tableBody.appendChild(row);
                })
            }
            else {
                tableBody.innerHTML = "<tr><td colspan='8' class='text-center'>No admin found.</td></tr>"
            }
        })
    }

    searchInput.addEventListener('input', searchAdmin);

})
    
</script>
@endsection