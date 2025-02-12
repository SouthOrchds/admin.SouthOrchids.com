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

<div class="p-5 max-sm:p-2">
    <div class="py-5 max-sm:py-2">
        <h1 class="text-3xl font-medium max-sm:text-2xl">Users <span id="totalCount" class="text-2xl max-sm:text-xl">( Total: {{ $users->count() }} )</span></h1>
    </div>
    
    <div class="flex justify-between py-5 max-sm:py-4">
        <form action="{{ route('user.search') }}">
            <div class="">
                <div>
                    <input type="text" name="search" id="searchInput" placeholder="Search" class="p-1 border border-black w-96 max-sm:w-full">
                    <p class="px-1 text-sm text-gray-600 max-sm:text-xs">Enter email or phone number</p>
                </div>
            </div>
        </form>
        
        <div>
            <button class="px-4 py-1 font-medium text-white bg-blue-500 border rounded max-sm:px-2 max-sm:py-1 max-sm:text-sm" id="addNewUser">Add New</button>
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
                        <button class="px-2 bg-yellow-400 border rounded "><i class="text-xl icon ion-md-create max-sm:text-sm"></i></button>
                        <button class="px-2 bg-red-500 border rounded"><i class="text-xl icon ion-ios-trash max-sm:text-sm"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div id="addUserModel" class="fixed inset-0 z-50 flex items-center hidden justify-center pt-5 overflow-y-scroll bg-black bg-opacity-50 max-sm:pt-2 max-sm:h-screen">
    <div class="bg-white p-5 max-sm:p-2 max-sm:mx-2">
        <p class="text-xl font-medium text-center pb-5 max-sm:text-lg max-sm:pb-3">Add New User</p>
        <div class="flex justify-start p-5 max-sm:p-2">
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
                <div class="flex justify-center gap-7 pt-5 max-sm:gap-3">
                    <button class="px-4 py-0.5 border rounded bg-blue-500 text-white" type="submit">Submit</button>
                    <button class="px-4 py-0.5 border rounded bg-black text-white" id="CancelButton">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {

        document.getElementById('addNewUser').addEventListener('click', () => {
            document.getElementById('addUserModel').classList.remove('hidden');
        });
        
        document.getElementById('CancelButton').addEventListener('click', (event) => {
            event.preventDefault();
            document.getElementById('addUserModel').classList.add('hidden');
        });
        
        const searchInput = document.getElementById('searchInput');
        const tableBody = document.getElementById('tableBody')
        
        function searchUser() {
            const search = searchInput.value;

            fetch(`/admin/user-search?search=${search}`)
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
                                <button class="px-2 bg-yellow-400 border rounded"><i class="text-xl icon ion-md-create"></i></button>
                                <button class="px-2 bg-red-500 border rounded"><i class="text-xl icon ion-ios-trash"></i></button>
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
</script>
@endsection