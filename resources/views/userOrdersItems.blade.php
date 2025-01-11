<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

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
</head>
<body>
    <div class="p-5">
        <p class="text-2xl font-medium">Customer Order Page</p>
        <div class="py-10">
            <table class="text-lg">
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
                            <td rowspan="{{ $productCount }}">{{ $order->user_name }} <span >(#{{ $order->user_id }})</span></td>
                            @endif
                            <td>{{ $product->product_name }} <span class="text-sm">| {{$product->product_quantity}}</span></td>
                            <td>{{ $product->quantity }}</td>    
                            <td>{{ $product->product_brand }}</td>
                            @if($index === 0)
                            <td rowspan="{{ $productCount }}" class="">
                                <button class="px-2 py-0.5 bg-blue-400 shadow rounded-sm text-lg mr-2" onclick="deliveryUpdate({{ $order->order_id }})">Ship</button>
                                <button class="px-2.5 py-0.5 bg-red-500 shadow rounded-sm text-lg">X</button>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                        @endif
                    @endforeach
                    @if($hasOrders)
                        <tr>
                            <td colspan="7" class="-center text">..No Orders placed..</td>
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
</body>
</html>