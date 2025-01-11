<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

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
</head>
<body>
    <div class="p-5">
        <div class="py-5">
            <h1 class="text-3xl font-medium">Users (Total: <span id="totalCount">{{ $users->count() }}</span>)</h1>
        </div>
        
        <div class="flex justify-between p-5 ">
            <form action="{{ route('user.search') }}">
                <div class="">
                    <div>
                        <input type="text" name="search" id="searchInput" placeholder="Search" class="p-1 border border-black w-96">
                        <p class="px-1 text-sm text-gray-600">Enter email or phone number</p>
                    </div>
                </div>
            </form>
            
            <div>
                <button class="px-4 py-1 font-medium text-white bg-blue-500 border rounded" id="addNewProduct">Add New</button>
            </div>
        </div>
        
        <div>
            <table>
                <thead>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone_NO</th>
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
                            <button class="px-2 bg-yellow-400 border rounded"><i class="text-xl icon ion-md-create"></i></button>
                            <button class="px-2 bg-red-500 border rounded"><i class="text-xl icon ion-ios-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        
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
</html>