@extends('layouts.app')

@section('title', 'Transaction Page')

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
    <div class="py-3 max-sm:py-3">
        <p class="text-3xl font-medium max-sm:text-2xl">Transaction Page</p>
    </div>
    <div class="py-3 max-sm:py-2">
        <form action="{{ route('transaction.search') }}">
            <input type="number" name="phone_no" id="name" placeholder="Search number" class="p-1 border border-black w-96 max-sm:w-full">
            <p class="p-1 text-sm text-gray-600 max-sm:text-sm">Search by phone name</p>
        </form>
    </div>
    <div class="py-3 max-sm:text-sm max-sm:overflow-x-scroll">
        <table>
            <thead>
                <th>Id</th>
                <th>User_Name</th>
                <th>Order_Id</th>
                <th>Phone Number</th>
                <th>Reference_Id</th>
                <th>Transaction Amount </th>
                <th>Payment Status</th>
            </thead>
            <tbody id="tableBody">
                @if (!Empty($userTransaction) && $userTransaction->count() > 0)
                    @foreach ($userTransaction as $transaction)
                    <tr>
                        <td>{{ $transaction->id }}</td>
                        <td>{{ $transaction->user->name }}</td>
                        <td>{{ $transaction->order_id }}</td>
                        <td>{{ $transaction->phone_number }}</td>
                        <td>{{ $transaction->reference_id }}</td>
                        <td>{{ $transaction->amount }}</td>
                        <td>{{ $transaction->status }}</td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="text-center">No transaction found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const search = document.getElementById('name');
        const tableBody = document.getElementById('tableBody');

        function fetchRender() {
        
            fetch(`{{ route('transaction.search') }}?phone_no=${search.value}`)
            .then(response => response.json())
            .then(data => {
                tableBody.innerHTML = '';
                if(data.length > 0) {
                    data.forEach(transaction => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${ transaction.id }</td>
                            <td>${ transaction.user.name }</td>
                            <td>${ transaction.order_id }</td>
                            <td>${ transaction.phone_number }</td>
                            <td>${ transaction.reference_id }</td>
                            <td>${ transaction.amount }</td>
                            <td>${ transaction.status }</td>
                        `;
                        tableBody.appendChild(row);
                    });
                }
                else {
                    tableBody.innerHTML = "<tr><td colspan='7' class='text-center'>No transaction found.</td></tr>"
                }
            })
        }
        search.addEventListener('input', fetchRender);
    })
</script>

@endsection