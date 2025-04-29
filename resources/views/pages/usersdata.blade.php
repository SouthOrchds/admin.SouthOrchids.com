@extends('layouts.app')

@section('title', 'Customers List Page')

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

<div class="p-3 max-sm:p-2">
    <div class="py-3 max-sm:py-2">
        <h1 class="text-3xl font-medium max-sm:text-2xl">Customers <span id="totalCount" class="text-2xl max-sm:text-xl">( Total: {{ $users->count() }} )</span></h1>
    </div>
    
    <div class="flex justify-between py-3 max-sm:py-4">
        <form action="{{ route('user.search') }}">
            <div class="">
                <div>
                    <input type="text" name="search" id="searchInput" placeholder="Search" class="p-1 border border-black w-96 max-sm:w-full">
                    <p class="px-1 text-sm text-gray-600 max-sm:text-xs">Enter email or phone number</p>
                </div>
            </div>
        </form>
        
        <div>
            <button class="px-4 py-1 font-medium text-white bg-blue-500 border rounded max-sm:px-2 max-sm:py-1 max-sm:text-sm  btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNewUser">Add New</button>
        </div>
    </div>
    
    <div class="max-sm:py-3 max-sm:text-sm max-sm:overflow-x-scroll">
        <table>
            <thead>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone_No</th>
                <th>Address</th>
                <th>City</th>
                <th>Pincode</th>
                <th>Action</th>
            </thead>
            <tbody id="tableBody">
                @if (!Empty($users) && $users->count() > 0)
                    @foreach ($users as $user)
                    <tr>
                        <td>#{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone_no }}</td>
                        <td>{{ $user->address }}</td>
                        <td>{{ $user->city }}</td>
                        <td>{{ $user->pincode }}</td>
                        <td>
                            <button class="py-1 px-2 border rounded btn btn-warning" 
                              data-bs-toggle="modal" 
                              data-bs-target="#editUser" 
                              data-user-id="{{ $user->id }}" 
                              data-user-name="{{ $user->name }}" 
                              data-user-email="{{ $user->email }}" 
                              data-user-phone_no="{{ $user->phone_no }}" 
                              data-user-address="{{ $user->address }}" 
                              data-user-city="{{ $user->city }}" 
                              data-user-pincode="{{ $user->pincode }}" 
                              onclick="editUser(this)">
                                <i class="fa-regular fa-pen-to-square max-sm:text-sm"></i>
                            </button>
                            <button class=" border rounded py-0.5 text-white btn btn-danger">
                                <i class="text-lg  icon ion-ios-trash max-sm:text-sm"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8" class="text-center">No users found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<!--Add New User Modal -->
<div class="modal fade" id="addNewUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addNewUserLabel">Add New User</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body flex justify-center">
          <form action="{{ route('user.register') }}" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="flex items-center justify-between py-2 w-96 max-sm:w-full">
                    <p class="py-1 max-sm:text-sm">Name :</p>
                    <input type="text" name="name" id="searchName" placeholder="Search" class="p-1 border border-black w-60 max-sm:px-1 max-sm:py-0 max-sm:w-40 max-sm:gap-2">
                </div>
                <div class="flex items-center justify-between py-2 w-96 max-sm:w-full">
                    <p class="py-1 max-sm:text-sm">Email :</p>
                    <input type="email" name="email" id="searchEmail" placeholder="Search" class="p-1 border border-black w-60 max-sm:px-1 max-sm:py-0 max-sm:w-40 max-sm:gap-2">
                </div>
                <div class="flex items-center justify-between py-2 w-96 max-sm:w-full">
                    <p class="py-1 max-sm:text-sm">Password :</p>
                    <input type="password" name="password" id="searchPassword" placeholder="Search" class="p-1 border border-black w-60 max-sm:px-1 max-sm:py-0 max-sm:w-40 max-sm:gap-2">
                </div>
                <div class="flex items-center justify-between py-2 w-96 max-sm:w-full">
                    <p class="py-1 max-sm:text-sm">Phone number :</p>
                    <input type="number" name="phone_no" id="searchPhone" placeholder="Search" class="p-1 border border-black w-60 max-sm:px-1 max-sm:py-0 max-sm:w-40 max-sm:gap-2">
                </div>
                <div class="flex items-center justify-between py-2 w-96 max-sm:w-full">
                    <p class="py-1 max-sm:text-sm">Address :</p>
                    <input type="text" name="address" id="searchAddress" placeholder="Search" class="p-1 border border-black w-60 max-sm:px-1 max-sm:py-0 max-sm:w-40 max-sm:gap-2">
                </div>
                <div class="flex items-center justify-between py-2 w-96 max-sm:w-full">
                    <p class="py-1 max-sm:text-sm">City :</p>
                    <input type="text" name="city" id="searchCity" placeholder="Search" class="p-1 border border-black w-60 max-sm:px-1 max-sm:py-0 max-sm:w-40 max-sm:gap-2">
                </div>
                <div class="flex items-center justify-between py-2 w-96 max-sm:w-full">
                    <p class="py-1 max-sm:text-sm">Pincode :</p>
                    <input type="number" name="pincode" id="searchPincode" placeholder="Search" class="p-1 border border-black w-60 max-sm:px-1 max-sm:py-0 max-sm:w-40 max-sm:gap-2">
                </div>
                
                <div class="modal-body flex justify-center gap-3">
                  <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
          </form>
        </div>
      </div>
    </div>
</div>

<!--Edit User Modal -->
<div>
    <div class="modal fade" id="editUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="editUserLabel">Add New User</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body flex justify-center">
              <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="flex items-center justify-between py-2 w-96 max-sm:w-full">
                        <p class="py-1 max-sm:text-sm">Name :</p>
                        <input type="text" name="name" id="userName" placeholder="Search" class="p-1 border border-black w-60 max-sm:px-1 max-sm:py-0 max-sm:w-40 max-sm:gap-2">
                    </div>
                    <div class="flex items-center justify-between py-2 w-96 max-sm:w-full">
                        <p class="py-1 max-sm:text-sm">Email :</p>
                        <input type="email" name="email" id="userEmail" placeholder="Search" class="p-1 border border-black w-60 max-sm:px-1 max-sm:py-0 max-sm:w-40 max-sm:gap-2">
                    </div>
                    <div class="flex items-center justify-between py-2 w-96 max-sm:w-full">
                        <p class="py-1 max-sm:text-sm">Password :</p>
                        <input type="password" name="password" id="userPassword" placeholder="Search" class="p-1 border border-black w-60 max-sm:px-1 max-sm:py-0 max-sm:w-40 max-sm:gap-2">
                    </div>
                    <div class="flex items-center justify-between py-2 w-96 max-sm:w-full">
                        <p class="py-1 max-sm:text-sm">Phone number :</p>
                        <input type="number" name="phone_no" id="userPhone" placeholder="Search" class="p-1 border border-black w-60 max-sm:px-1 max-sm:py-0 max-sm:w-40 max-sm:gap-2">
                    </div>
                    <div class="flex items-center justify-between py-2 w-96 max-sm:w-full">
                        <p class="py-1 max-sm:text-sm">Address :</p>
                        <input type="text" name="address" id="userAddress" placeholder="Search" class="p-1 border border-black w-60 max-sm:px-1 max-sm:py-0 max-sm:w-40 max-sm:gap-2">
                    </div>
                    <div class="flex items-center justify-between py-2 w-96 max-sm:w-full">
                        <p class="py-1 max-sm:text-sm">City :</p>
                        <input type="text" name="city" id="userCity" placeholder="Search" class="p-1 border border-black w-60 max-sm:px-1 max-sm:py-0 max-sm:w-40 max-sm:gap-2">
                    </div>
                    <div class="flex items-center justify-between py-2 w-96 max-sm:w-full">
                        <p class="py-1 max-sm:text-sm">Pincode :</p>
                        <input type="number" name="pincode" id="userPincode" placeholder="Search" class="p-1 border border-black w-60 max-sm:px-1 max-sm:py-0 max-sm:w-40 max-sm:gap-2">
                    </div>
                    
                    <div class="modal-body flex justify-center gap-3">
                      <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
              </form>
            </div>
          </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        const searchInput = document.getElementById('searchInput');
        const tableBody = document.getElementById('tableBody')
        
        function searchUser() {
            const search = searchInput.value;

            fetch(`/user-search?search=${search}`)
            .then(response => response.json())
            .then(users => {
                tableBody.innerHTML = '';
                if(users.length > 0) {
                    users.forEach(user => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>#${ user.id }</td>
                            <td>${ user.name }</td>
                            <td>${ user.email }</td>
                            <td>${ user.phone_no }</td>
                            <td>${ user.address }</td>
                            <td>${ user.city }</td>
                            <td>${ user.pincode }</td>
                            <td>
                                <button class="py-1 px-2 border rounded btn btn-warning" data-bs-toggle="modal" data-bs-target="#editUser"><i class="fa-regular fa-pen-to-square max-sm:text-sm"></i></button>
                                <button class=" border rounded py-0.5 text-white btn btn-danger"><i class="text-lg  icon ion-ios-trash max-sm:text-sm"></i></button>
                            </td>
                        `;
                        tableBody.appendChild(row);
                    });
                } else {
                    tableBody.innerHTML = "<tr><td colspan='8' class='text-center'>No user found.</td></tr>"
                }
            })
            .catch(err => {
                console.log("Error fetch user", err);
            })
        }
        
        searchInput.addEventListener('input', searchUser);

    });
    function editUser(button) {
        let userId = button.getAttribute("data-user-id");
        let userName = button.getAttribute("data-user-name");
        let userEmail = button.getAttribute("data-user-email");
        let userPhone_no = button.getAttribute("data-user-phone_no");
        let userAddress = button.getAttribute("data-user-address");
        let userCity = button.getAttribute("data-user-city");
        let userPincode = button.getAttribute("data-user-pincode");

        console.log({ userId, userName, userEmail, userPhone_no, userAddress, userCity, userPincode });

        document.getElementById('userId').value = userId;
        document.getElementById('userName').value = userName;
        document.getElementById('userEmail').value = userEmail;
        document.getElementById('userPhone').value = userPhone_no;
        document.getElementById('userAddress').value = userAddress;
        document.getElementById('userCity').value = userCity;
        document.getElementById('userPincode').value = userPincode;
    }
</script>
@endsection