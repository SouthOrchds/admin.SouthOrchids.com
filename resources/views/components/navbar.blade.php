<div class="">
    <nav class="flex justify-around w-full border p-5 items-center">
        <div>
            <p class="font-bold text-2xl">Admin</p>
        </div>
        <div class="flex gap-x-10 cursor-pointer items-center">
            <a href= "{{ route('dashboard') }}">Home</a>
            <a href= "{{ route('usersdata') }}">Customers</=>
            <a href="{{ route('products') }}">Products</a>
            <select class="w-15" onchange="window.location.href=this.value;">
                <option value=""> Orders </option>
                <option value="{{ route('user.ordersDetails') }}">Order Details</option>
                <option value="{{ route('user.orderItems') }}">Order Items</option>
            </select>
            <a href="{{ route('transactions') }}">Transaction</a>
            <select name="" id="" onchange="window.location.href=this.value;">
                <option value="">-- Others --</option>
                <option value="{{ route('adminRegister') }}">Admin Register</option>
                <option value="">Admin Authorization</option>
            </select>
        </div>
        <div>
            <a href="{{ route('logout') }}">Logout</a>
        </div>
    </nav>
</div>

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
</script>