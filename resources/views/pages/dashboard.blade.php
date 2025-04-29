@extends('layouts.app')

@section('title', 'Dashboard Page')

@section('content')
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td{
        border: 1px solid black;
        padding: 2px;
        text-align: center;
    }
</style>

<div class="p-3 max-sm:p-2">
    <p class="text-3xl font-medium max-sm:text-2xl">Dashboard Page</p>
    <div class="flex justify-around mt-5 text-center">
        <div class="border px-5 py-3 shadow">
            <p class="font-medium text-xl">Customers Count</p>
            <p class="font-medium text-3xl pt-4">3</p>
        </div>
        <div class="border px-5 py-3 shadow">
            <p class="font-medium text-xl">Shipped Orders Count</p>
            <p class="font-medium text-3xl pt-4">3</p>
        </div>
        <div class="border px-5 py-3 shadow">
            <p class="font-medium text-xl">Delivered Orders Count</p>
            <p class="font-medium text-3xl pt-4">3</p>
        </div>
    </div>
    <div class="flex justify-between p-14 text-center">
        <div class="w-1/2">
            <p class="text-2xl font-medium p-2 text-left max-sm:text-2xl">New Orders</p>
            <table>
                <thead>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Product</th>
                    <th>Quantity</th>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Shivaram</td>
                        <td>Hill Honey</td>
                        <td>x2</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div>
            <div class="border px-5 py-3 shadow">
                <p class="font-medium text-xl">Total Sales</p>
                <p class="font-medium text-3xl pt-4">$3,000</p>
            </div>
        </div>
    </div>
</div>
@endsection