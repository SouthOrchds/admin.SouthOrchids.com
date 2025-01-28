@extends('layouts.app')

@section('title', 'Customers Order Page')

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
    <p class="text-3xl font-medium max-sm:text-2xl">Order Details <span id="totalCount" class="text-2xl max-sm:text-xl">( Total: {{ $userorders->count() }} )</span></p>
  </div>
  <div class="py-5 max-sm:py-5">
    <form action="{{ route('user.ordersDetails.search') }}" method="GET" class="flex gap-20 items-center max-sm:block">
      <div class="max-sm:mb-3">
        <input type="text" name="search" id="searchInput" placeholder="Search" class="p-1 border border-black w-96 max-sm:w-full">
        <p class="px-1 text-sm text-gray-600 max-sm:text-xs">Enter name or phone number</p>
      </div>
      <div class="max-sm:mb-3">
        <select name="" id="selectStatus" class="p-1 border border-black min-w-32">
          <option value="">--All--</option>
          <option value="Order Placed">Placed Orders</option>
          <option value="Shipped">Shipped Orders</option>
          <option value="Delivered">Delivered Orders</option>
        </select>
        <p class="px-1 text-sm text-gray-600 max-sm:text-xs">Select Status</p>
      </div>
    </form>
  </div>

    <div class="py-5 max-sm:py-2 max-sm:text-sm max-sm:overflow-x-scroll">
      <table>
        <thead>
          <th>Id</th>
          <th>Ordered Date</th>
          <th>Transaction Id</th>
          <th>Customer Name</th>
          <th>Phone Number</th>
          <th>Products Ordered</th>
          <th>Total Amount</th>
          <th>Payment Status</th>
          <th>Delivery Status</th>
          <th>Action</th>
        </thead>
        <tbody id="tableBody" class="text-sm">
          @if (!Empty($userorders) && $userorders->count() > 0)
            @foreach ($userorders as $order)
            <tr>
              <td>{{ $order->id }}</td>
              <td>{{ \Carbon\Carbon::parse($order->order_date)->format('Y-m-d') }}</td>
              <td>{{ $order->transaction_id }}</td>
              <td>{{ $order->user->name }} <span class="text-blue-600">(#{{ $order->user_id }})</span></td>
              <td>{{ $order->user->phone_no }}</td>
              <td>
                @foreach ($order->orderItems as $item)
                <p>{{ $item->product->name }} | <span class="text-sm text-green-600 font-medium">qty: {{ $item->quantity }}</span></p>
                @endforeach
              </td>
              <td><span class="font-medium">&#8377;</span>{{ $order->total_amount }}.00</td>
              <td>{{ $order->payment_status }}</td>
              <td>{{ $order->delivery_status }}</td>
              <td>
                <button class="px-2 bg-yellow-400 border rounded max-sm:px-1.5 max-sm:my-1"><i class="text-xl icon ion-md-create max-sm:text-sm"></i></button>
                <button class="px-2 bg-red-500 border rounded max-sm:px-1.5 max-sm:my-1"><i class="text-xl icon ion-ios-trash max-sm:text-sm"></i></button>
              </td>
            </tr>
            @endforeach
          @else
            <tr>
              <td colspan="10" class="text-center">No orders found.</td>
            </tr>
          @endif
        </tbody>
      </table>
    </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    const selectStatus = document.getElementById('selectStatus');
    const tableBody = document.getElementById('tableBody');

    function fetchRender() {
      fetch(`{{ route('user.ordersDetails.search') }}?search=${searchInput.value}&status=${selectStatus.value}`)
      .then(response => response.json())
      .then(data => {
        tableBody.innerHTML = '';
        if(data.length > 0) {
          data.forEach(order => {
            const row = document.createElement('tr');
            
            const productOrder = order.orderitems && order.orderitems.length > 0 ? order.orderitems.map(item => {
              return `<p>${item.product.name} | <span class="text-sm">qty: ${item.quantity}</span></p>`;
            }).join('') : '';
            
            row.innerHTML = `
              <td>${ order.id }</td>
              <td>${ order.order_date }</td>
              <td>${ order.transaction_id }</td>
              <td>${ order.user.name }</td>
              <td>${ order.user.phone_no }</td>
              <td>${ productOrder }</td>
              <td><span class="font-medium">&#8377;</span>${ order.total_amount }.00</td>
              <td>${ order.payment_status }</td>
              <td>${ order.delivery_status }</td>
              <td>
                <button class="px-2 bg-yellow-400 border rounded"><i class="text-xl icon ion-md-create"></i></button>
                <button class="px-2 bg-red-500 border rounded"><i class="text-xl icon ion-ios-trash"></i></button>
              </td>
            `;
            tableBody.appendChild(row);
          });
        } else {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td colspan="10" class="text-center text-lg">..No orders found..</td>
          `;
          tableBody.appendChild(row);
        }
      });
    }

    searchInput.addEventListener('input', fetchRender);
    selectStatus.addEventListener('change', fetchRender);
  });

</script>
@endsection