@extends('layouts.app')

@section('title', 'Shipped Orders Page')

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
            <p class="text-3xl font-medium max-sm:text-2xl">Shipped Orders <span id="totalCount" class="text-2xl max-sm:text-xl">( Total: {{ $shippedOrderCount }} )</span></p>
        </div>
        <div class="py-5 max-sm:py-5">
            <form action="{{ route('user.shippedOrders.search') }}" method="GET">
                <input type="text" name="search" id="searchInput" placeholder="Search" class="p-1 border border-black w-96 max-sm:w-full">
                <p class="px-1 text-sm text-gray-600 max-sm:text-xs">Enter name or phone number</p>
            </form>
        </div>
        <div class="py-5 max-sm:py-2 max-sm:text-sm max-sm:overflow-x-scroll">
            <table>
                <thead>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Products</th>
                    <th>Ordered Date</th>
                    <th>Shipped Date</th>
                    <th>Action</th>
                </thead>
                <tbody id="tableBody" class="text-sm">
                    @if (!Empty($shippedDetails) && $shippedOrderCount > 0 )
                      @foreach ($shippedDetails as $shippedItems)
                        <tr>
                            <td>#{{ $shippedItems->order_id }}</td>
                            <td>{{ $shippedItems->user_name }} <span class="text-blue-600">(#{{$shippedItems->user_id}})</span></td>
                            <td>{{ $shippedItems->user_phone_no }}</td>
                            <td>
                                <p>{{ $shippedItems->user_address }}</p>
                                <p>{{ $shippedItems->user_city }}-{{ $shippedItems->user_pincode}}</p>
                            </td>
                            <td>
                                @foreach ($shippedItems->products as $items )
                                    <p>{{ $items->product_name }} | <span  class="text-sm text-green-600 font-medium">qty: {{ $items->quantity }}</span></p>
                                @endforeach
                            </td>
                            <td>{{ \Carbon\Carbon::parse($shippedItems->order_date)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($shippedItems->shipped_date)->format('d-m-Y') }}</td>
                            <td>
                                <button onclick="deliveryStatus({{ $shippedItems->order_id }})" class="px-2 border rounded max-sm:px-1.5 max-sm:my-1"><i class="fa-solid fa-people-carry-box text-2xl text-blue-500"></i></button>
                            </td>
                        </tr>
                      @endforeach
                    @else
                        <tr>
                            <td colspan="8" class="text-center">...No data found...</td>
                        </tr>
                    @endif
                </tbody>    
            </table>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('searchInput');
        const tableBody = document.getElementById('tableBody');
        const totalCount = document.getElementById('totalCount');

        function fetchRender() {
            fetch(`{{ route('user.shippedOrders.search') }}?search=${searchInput.value}`)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                tableBody.innerHTML = '';
                if(data.length > 0) {
                    data.forEach(shippedItems => {
                        const row = document.createElement('tr');
                        const productOrder = shippedItems.orderitems && shippedItems.orderitems.length > 0 ? shippedItems.orderitems.map(item => {
                            return `<span>${item.product.name} | <span class="text-sm text-green-600 font-medium">qty: ${item.quantity}</span></span><br>`;
                        }): '';
                        row.innerHTML = `
                            <td>#${ shippedItems.id }</td>
                            <td>${ shippedItems.user.name } <span class="text-blue-600">(#${shippedItems.user.id})</span></td>
                            <td>${ shippedItems.user.phone_no }</td>
                            <td>
                                <p>${ shippedItems.user.address }</p>
                                <p>${ shippedItems.user.city }-${ shippedItems.user.pincode}</p>
                            </td>
                            <td>${ productOrder }</td>
                            <td>${ new Date(shippedItems.order_date).toLocaleDateString() }</td>
                            <td>${ new Date(shippedItems.updated_at).toLocaleDateString() }</td>
                            <td>
                                <button onclick="deliveryStatus(${ shippedItems.id })" class="px-2 border rounded max-sm:px-1.5 max-sm:my-1"><i class="fa-solid fa-people-carry-box text-2xl text-blue-500"></i></button>
                            </td>
                            `;
                        tableBody.appendChild(row);
                    })
                } else {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td colspan="10" class="text-center text-lg">..No orders found..</td>
                    `;
                    tableBody.appendChild(row);
                }
            })
        }
        searchInput.addEventListener('input', fetchRender);

    })
    function deliveryStatus(orderId) {
        fetch(`/admin/order/${orderId}/ship`, {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' 
            },
            body: JSON.stringify({ status : 'Delivered' })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                alert('Order Delivered successfully ');
                fetchRender();
            }
            else{
                alert('Failed to update order status')
            }
        })
    }
</script>
@endsection