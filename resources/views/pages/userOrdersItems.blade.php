@extends('layouts.app')

@section('title', 'Customers Order Items Page')

@section('content')
<style>
    table {
        border-collapse: collapse;
        width: 100%;
        font-size: small;
    }
    th, td{
        border: 1px solid black;
        padding: 8px;
        text-align: center;
    }
</style>

<div class="p-5 max-sm:p-2">
    <p class="text-3xl font-medium max-sm:text-2xl">Customer Orders <span id="totalCount" class="text-2xl max-sm:text-xl">( Total: {{ $placedOrderCount }} )</span></p>
    <div class="py-10 max-sm:pt-10 max-sm:pb-2 max-sm:overflow-x-scroll">
        <table class="text-lg max-sm:text-sm">
            <thead>
                <th>Id</th>
                <th>Ordered Date</th>
                <th>Customer</th>
                <th>Items</th>
                <th>Quantity ordered</th>
                <th>Brand</th>
                <th>Action</th>
            </thead>
            <tbody >
                @php
                    $hasOrders = false;
                @endphp
                
                @foreach ($orderDetail as $order)
                @if ($order->delivery_status === 'Order Placed')
                    @php 
                        $productCount = count($order->products);
                    @endphp
                    @foreach($order->products as $index => $product)
                    <tr>
                        @if($index === 0)
                        <td rowspan="{{ $productCount }}">#{{ $order->order_id }}</td>
                        <td rowspan="{{ $productCount }}">{{ \Carbon\Carbon::parse($order->order_date)->format('Y-m-d') }}</td>
                        <td rowspan="{{ $productCount }}">{{ $order->user_name }} <span class="text-blue-600 font-medium">(#{{ $order->user_id }})</span></td>
                        @endif
                        <td>{{ $product->product_name }} |<span class="text-sm text-green-500 font-medium"> {{$product->product_quantity}}</span></td>
                        <td>x{{ $product->quantity }}</td>    
                        <td>{{ $product->product_brand }}</td>
                        @if($index === 0)
                        <td rowspan="{{ $productCount }}" class="">
                            <button class="px-2 py-0.5 bg-blue-400 shadow rounded-sm text-lg mr-2 max-sm:mr-0 max-sm:my-1 max-sm:text-sm" onclick="deliveryUpdate({{ $order->order_id }})">
                                <i class="fa-solid fa-truck-fast"></i>
                            </button>
                            <button class="px-2.5 py-0.5 bg-red-500 shadow rounded-sm text-lg max-sm:text-md">
                                <i class="icon ion-md-close"></i>
                            </button>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                    @endif
                @endforeach
                @if(!$hasOrders)
                    <tr>
                        <td colspan="7" class="text-center p-5">..No Orders placed..</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<script>
    function deliveryUpdate(orderId) {
        fetch(`/admin/order/${orderId}/ship`, {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' 
            },
            body: JSON.stringify({ status : 'Shipped' })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                alert('Order shipped successfully ');
            }
            else{
                alert('Failed to update order status')
            }
        })
        .catch(err =>{
            console.log('Error', err);
        }) 
    }
</script>

@endsection