@extends('layouts.app')

@section('title', 'Registration Page')

@section('content')
<div class="max-sm:p-5 max-sm:w-full">
    <p class="text-2xl font-medium text-center max-sm:text-xl">Register Page</p>
    <div class="p-5 flex justify-center">
        <form action="{{ route('adminRegister') }}" method="POST">
            @csrf
            <div class="py-1">
                <p class="py-1 md:text-lg">Name :</p>
                <input type="text" name="name" id="" class="p-1 border border-black rounded outline-none md:w-96 max-sm:w-full">
            </div>
            <div class="py-1">
                <p class="py-1 md:text-lg">Email :</p>
                <input type="email" name="email" id="" class="p-1 border border-black rounded outline-none md:w-96 max-sm:w-full">
            </div>
            <div class="py-1">
                <p class="py-1 md:text-lg">Password :</p>
                <input type="password" name="password" id="" class="p-1 border border-black rounded outline-none md:w-96 max-sm:w-full">
            </div>
            <div class="py-1">
                <p class="py-1 md:text-lg">Confirm Password :</p>
                <input type="password" name="confirm_password" id="" class="p-1 border border-black rounded outline-none md:w-96 max-sm:w-full">
            </div>
            <div class="py-1">
                <p class="py-1 md:text-lg">Phone Number :</p>
                <input type="number" name="phone_no" id="" class="p-1 border border-black rounded    outline-none md:w-96 max-sm:w-full">
            </div>
            <div class="py-5 text-center">
                <button type="submit" class="border px-3 py-1 font-medium bg-blue-500 text-white rounded">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection