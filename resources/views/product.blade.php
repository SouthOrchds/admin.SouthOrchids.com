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
            <h1 class="text-3xl font-medium">Products (Total: <span id="totalCount"></span>)</h1>
        </div>
        
        <div class="flex justify-between p-5 ">
            <form action="{{ route('products.search') }}" >
                <div class="flex gap-x-10">
                    <div>
                        <input type="" name="" id="searchInput" placeholder="Search" class="p-1 border border-black w-96">
                        <p class="px-1 text-sm text-gray-600">Enter the Product Name</p>
                    </div>
                    <div>
                        <select name="" id="" class="p-1 border border-black min-w-32">
                            <option value="">--Select Brand--</option>
                            <option value=""></option>
                        </select>
                        <p class="px-1 text-sm text-gray-600">Brand</p>
                    </div>
                    <div>
                        <select name="" id="" class="p-1 border border-black min-w-32">
                            <option value="">--Select Status--</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">In-Active</option>
                        </select>
                        <p class="px-1 text-sm text-gray-600">Status</p>
                    </div>
                </div>
            </form>
            
            <div>
                <button class="px-4 py-1 font-medium text-white bg-blue-500 border rounded" id="addNewProduct">Add New</button>
            </div>
        </div>

        <div class="py-5">
            <table>
                <thead>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Brand</th>
                    <th>Price</th>
                    <th>Mrp_price</th>
                    <th>Category_id</th>
                    <th>Status</th>
                    <th>Action</th>
                </thead>
                <tbody id="tableBody">
                    @if($products->count() > 0)
                    @foreach($products as $product)
                    <tr>
                        <td>#{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->brand }}</td>
                        <td><span>&#8377;</span> {{ $product->price }}</td>
                        <td><span>&#8377;</span> {{ $product->mrp_price }}</td>
                        <td>{{ $product->category_id }}</td>
                        <td>{{ $product->status }}</td>
                        <td>
                            <button class="px-2 text-white bg-blue-400 border rounded"><i class="text-xl icon ion-md-image"></i></button>
                            <button class="px-2 bg-yellow-400 border rounded"><i class="text-xl icon ion-md-create"></i></button>
                            <button class="px-2 bg-red-500 border rounded"><i class="text-xl icon ion-ios-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="9" class="text-center">No products found.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div id="addProdectModel" class="fixed inset-0 z-50 flex items-center justify-center hidden pt-5 overflow-y-scroll bg-black bg-opacity-50">
        <div class="bg-white ">
            <div class="border ">
                <p class="pt-10 text-xl font-medium text-center">Add New Product</p>
                <div class="flex justify-start p-5">
                    <form action="{{ route('addproduct') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="flex items-center justify-between py-2">
                            <p class="py-1 ">Name :</p>
                            <input type="text" name="product_name" id="" class="w-56 p-1 border border-black">
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <p class="py-1 ">Description :</p>
                            <textarea rows="4" name="product_decrp" id="" class="w-56 p-1 border border-black"></textarea>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <p class="py-1 ">Quantity :</p>
                            <input type="text" name="product_quantity" id="" class="w-56 p-1 border border-black">
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <p class="py-1 ">Brand Name:</p>
                            <input type="text" name="brand_name" id="" class="w-56 p-1 border border-black">
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <p class="py-1 ">Our Price:</p>
                            <input type="number" name="price" id="" class="w-56 p-1 border border-black">
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <p class="py-1 ">MRP Price:</p>
                            <input type="number" name="mrp_price" id="" class="w-56 p-1 border border-black">
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <p class="py-1 ">Category:</p>
                            <select name="category" id="" class="w-56 p-1 border border-black">
                                <option value="">--Select--</option>
                                <option value="1">Milk</option>
                                <option value="2">Honey</option>
                                <option value="3">Crafts</option>
                            </select>
                        </div>
                        <div class="flex items-center py-3 gap-x-36">
                            <p>Status:</p>
                            <div class="flex justify-between gap-10">
                                <div class="flex items-center gap-x-2">
                                    <input type="radio" name="product_status" id="active" value="Active">
                                    <p for="active">Active</p>
                                </div>
                                <div class="flex items-center gap-x-2">
                                    <input type="radio" name="product_status" id="inactive" value="Inactive">
                                    <p for="inactive">Inactive</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between gap-5 py-2">
                            <p class="py-2 ">Product Image:</p>
                            <input type="file" name="product_image" id="">
                        </div>
                        <div class="flex justify-center gap-5 pt-3">
                            <button class="px-4 py-0.5 border rounded bg-blue-500 text-white" type="submit">Submit</button>
                            <button class="px-4 py-0.5 border rounded bg-black text-white" id="CancelButton">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    document.getElementById('addNewProduct').addEventListener('click', () => {
        document.getElementById('addProdectModel').classList.remove('hidden');
    });
    
    document.getElementById('CancelButton').addEventListener('click', (event) => {
        event.preventDefault();
        document.getElementById('addProdectModel').classList.add('hidden');
    });
    
    const SuccessMesg = "{{ session('success') }}";
    if(SuccessMesg) {
        alert(SuccessMesg);
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('addProdectModel').classList.add('hidden');
        });
    }

    const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('tableBody');

    searchInput.addEventListener('input', function() {
        
        const query = searchInput.value;
        const ProductCount = document.getElementById('totalCount');

        fetch(`/products/search?search=${query}`)
            .then(response => response.json())
            .then(products => {
                tableBody.innerHTML = '';
                ProductCount.innerHTML = products.length;
                if (products.length > 0) {
                    products.forEach(product => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>#${product.id}</td>
                            <td>${product.name}</td>
                            <td>${product.quantity}</td>
                            <td>${product.brand}</td>
                            <td>&#8377; ${product.price}</td>
                            <td>&#8377; ${product.mrp_price}</td>
                            <td>${product.category_id}</td>
                            <td>${product.status}</td>
                            <td>
                                <button class="px-2 text-white bg-blue-400 border rounded">
                                    <i class="text-xl icon ion-md-image"></i>
                                </button>
                                <button class="px-2 bg-yellow-400 border rounded">
                                    <i class="text-xl icon ion-md-create"></i>
                                </button>
                                <button class="px-2 bg-red-500 border rounded">
                                    <i class="text-xl icon ion-ios-trash"></i>
                                </button>
                            </td>
                        `;
                        tableBody.appendChild(row);
                    });
                } else {
                    tableBody.innerHTML = `<tr><td colspan="9" class="text-center">No products found.</td></tr>`;
                }
            })
            .catch(error => {
                console.error('Error fetching products:', error);
            });
    });

</script>
</html>