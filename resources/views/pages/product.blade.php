@extends('layouts.app')

@section('title', 'Product Page')

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
        <h1 class="text-3xl font-medium max-sm:text-2xl">Products  <span id="totalCount" class="text-2xl max-sm:text-xl">( Total: {{ $products->count() }} )</span></h1>
    </div>
    
    <div class="flex justify-between py-5 max-sm:py-2 max-sm:flex-col max-sm:gap-4">
        <form action="{{ route('products.search') }}" >
            <div class="flex gap-x-10 max-sm:flex-col max-sm:gap-2">
                <div>
                    <input type="text" name="search" id="searchInput" placeholder="Search" class="p-1 border border-black  w-[720px] max-sm:w-full">
                    <p class="px-1 text-sm text-gray-600">Enter the Product Name</p>
                </div>
                <div class="flex gap-7 max-sm:flex max-sm:py-2 max-sm:flex-row max-sm:gap-5">
                    <div>
                        <select name="brand" id="brandFilter" class="p-1 border border-black  min-w-32">
                            <option value="">--All--</option>
                            @foreach ($brands as $brand)
                            <option value="{{ $brand->brand }}">{{ $brand->brand }}</option>
                            @endforeach
                        </select>
                        <p class="px-1 text-sm text-gray-600">Brand</p>
                    </div>
                    <div>
                        <select name="status" id="statusFilter" class="p-1 border border-black  min-w-32">
                            <option value="">--All--</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">In-Active</option>
                        </select>
                        <p class="px-1 text-sm text-gray-600">Status</p>
                    </div>
                </div>
            </div>
        </form>
        
        <div>
            <button class="px-4 py-1 font-medium text-white bg-blue-500 border rounded" id="addNewProduct">Add New</button>
        </div>
    </div>

    <div class="py-5 max-sm:py-2 max-sm:text-sm max-sm:overflow-x-scroll">
        <table>
            <thead>
                <th>Id</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Brand</th>
                <th>Price</th>
                <th>Mrp_price</th>
                <th>Purchased_price</th>
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
                    <td><span>&#8377;</span> {{ $product->purchased_price }}</td>
                    <td>{{ $product->category_id }}</td>
                    <td>{{ $product->status }}</td>
                    <td>
                        <button class="px-2 text-white bg-blue-400 border rounded max-sm:px-1.5 max-sm:my-1"><i class="text-xl icon ion-md-image max-sm:text-sm"></i></button>
                        <button class="px-2 bg-yellow-400 border rounded max-sm:px-1.5 max-sm:my-1"><i class="text-xl icon ion-md-create max-sm:text-sm"></i></button>
                        <button class="px-2 bg-red-500 border rounded max-sm:px-1.5 max-sm:my-1"><i class="text-xl icon ion-ios-trash max-sm:text-sm"></i></button>
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
<div id="addProdectModel" class="fixed inset-0 z-50 flex items-center justify-center hidden pt-5 overflow-y-scroll bg-black bg-opacity-50 max-sm:pt-2 max-sm:h-screen">
    <div class="bg-white max-sm:p-2 max-sm:mx-2">
        <div class="border mt-20">
            <p class="pt-10 text-xl font-medium text-center max-sm:text-lg max-sm:pb-3">Add New Product</p>
            <div class="flex justify-start p-5 max-sm:px-5">
                <form action="{{ route('addproduct') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex items-center justify-between py-2 max-sm:w-full">
                        <p class="py-1  max-sm:text-sm">Name :</p>
                        <input type="text" name="product_name" id="" class="w-56 p-1 border border-black ">
                    </div>
                    <div class="flex items-center justify-between py-2  max-sm:w-full">
                        <p class="py-1  max-sm:text-sm">Description :</p>
                        <textarea rows="4" name="product_decrp" id="" class="w-56 p-1 border border-black "></textarea>
                    </div>
                    <div class="flex items-center justify-between py-2  max-sm:w-full">
                        <p class="py-1  max-sm:text-sm">Quantity :</p>
                        <input type="text" name="product_quantity" id="" class="w-56 p-1 border border-black ">
                    </div>
                    <div class="flex items-center justify-between py-2  max-sm:w-full">
                        <p class="py-1  max-sm:text-sm">Brand Name:</p>
                        <input type="text" name="brand_name" id="" class="w-56 p-1 border border-black ">
                    </div>
                    <div class="flex items-center justify-between py-2  max-sm:w-full">
                        <p class="py-1  max-sm:text-sm">Our Price:</p>
                        <input type="number" name="price" id="" class="w-56 p-1 border border-black ">
                    </div>
                    <div class="flex items-center justify-between py-2  max-sm:w-full">
                        <p class="py-1  max-sm:text-sm">MRP Price:</p>
                        <input type="number" name="mrp_price" id="" class="w-56 p-1 border border-black ">
                    </div>
                    <div class="flex items-center justify-between py-2  max-sm:w-full">
                        <p class="py-1  max-sm:text-sm">purchase Price:</p>
                        <input type="number" name="purchase_price" id="" class="w-56 p-1 border border-black ">
                    </div>
                    <div class="flex items-center justify-between py-2  max-sm:w-full">
                        <p class="py-1  max-sm:text-sm">Category:</p>
                        <select name="category" id="" class="w-56 p-1 border border-black ">
                            <option value="">--Select--</option>
                            <option value="1">Milk</option>
                            <option value="2">Honey</option>
                            <option value="3">Crafts</option>
                        </select>
                    </div>
                    <div class="flex items-center py-3 gap-x-36  max-sm:w-full">
                        <p class=" max-sm:text-sm">Status:</p>
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
                    <div class="flex items-center justify-between gap-5 py-2  max-sm:w-full">
                        <p class="py-2  max-sm:text-sm">Product Image:</p>
                        <input type="file" name="product_image" id="">
                    </div>
                    <div class="flex justify-center gap-5 pt-3  max-sm:w-full">
                        <button class="px-4 py-0.5 border rounded bg-blue-500 text-white" type="submit">Submit</button>
                        <button class="px-4 py-0.5 border rounded bg-black text-white" id="CancelButton">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
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
    
        let statusFilter = '';
        let brandFilter = '';
        
        const searchInput = document.getElementById('searchInput');
        const selectStatus = document.getElementById('statusFilter');
        const selectBrand = document.getElementById('brandFilter');
        const tableBody = document.getElementById('tableBody');
        
        function fetchRender() {
            const search = searchInput.value;
            const status = statusFilter;
            const brand = brandFilter;
            
            fetch(`{{ route('products.search') }}?search=${search}&brand=${brand}&status=${status}`)
            .then(response => response.json())
            .then(products => {
                tableBody.innerHTML = '';
                if (products.length > 0) {
                    products.forEach(product => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>#${ product.id }</td>
                            <td>${ product.name }</td>
                            <td>${ product.quantity }</td>
                            <td>${ product.brand }</td>
                            <td>&#8377; ${ product.price }</td>
                            <td>&#8377; ${ product.mrp_price }</td>
                            <td>&#8377; ${ product.purchased_price }</td>
                            <td>${ product.category_id }</td>
                            <td>${ product.status }</td>
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
                    tableBody.innerHTML = `<tr><td colspan="10" class="text-center">No products found.</td></tr>`;
                }
            })
            .catch(error => {
                console.error('Error fetching products:', error);
            });
        }
        
        searchInput.addEventListener('input', fetchRender);
        
        selectStatus.addEventListener('change', function(event) {
            statusFilter = event.target.value;
            fetchRender();
        });
        
        selectBrand.addEventListener('change', function(event) {
            brandFilter = event.target.value;
            fetchRender();
        })
    });

</script>
@endsection