<div class="fixed inset-x-0">
    <nav class="flex justify-around w-full border p-4 items-center bg-black text-white md:gap-10 max-sm:relative max-sm:justify-between">
        <div>
            <p class="font-bold text-2xl">Admin</p>
        </div>
        <div class="flex gap-10 cursor-pointer items-center max-sm:hidden">
            <a href= "{{ route('dashboard') }}">Home</a>
            <a href= "{{ route('usersdata') }}">Customers</a>
            {{-- <a href="{{ route('cart') }}">Cart</a> --}}
            <a href="{{ route('products') }}">Products</a>
            <div class="dropdown">
                <button class="btn btn-black text-white outline-none border-none dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Orders
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="{{ route('user.ordersDetails') }}">Order Details</a></li>
                  <li><a class="dropdown-item" href="{{ route('user.orderItems') }}">Order Items</a></li>
                  <li><a class="dropdown-item" href="{{ route('user.shippedOrders') }}">Shipped Items</a></li>
                </ul>
            </div>
            <a href="{{ route('transactions') }}">Transaction</a>
            <div class="dropdown">
                <button class="btn btn-black text-white outline-none border-none dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Others
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="{{ route('admin.users') }}">Admins</a></li>
                  <li><a class="dropdown-item" href="{{ route('admin.register') }}">Admin Register</a></li>
                </ul>
            </div>
            <div>
                <a href="{{ route('logout') }}">Logout</a>
            </div>
        </div>
        <div class="max-sm:block cursor-pointer hidden overflow-hidden">
            <button id="openMenu" onclick="toggleMenu()"><i class="icon ion-md-menu text-2xl"></i></button>
            <div id="menuSlide" class="h-screen w-52 bg-white absolute z-10 top-0 -right-[208px] text-black transition-all duration-500 shadow">
                <div class="p-3">
                    <button id="closeMenu" onclick="toggleMenu()">
                        <i class="icon ion-md-close text-2xl font-bold"></i>
                    </button>
                </div>
                <div class="max-sm:flex max-sm:flex-col max-sm:items-center max-sm:gap-7 p-5 items-cente">
                    <a href= "{{ route('dashboard') }}" class="hover:font-bold">Home</a>
                    <a href= "{{ route('usersdata') }}" class="hover:font-bold">Customers</a>
                    <a href="{{ route('products') }}" class="hover:font-bold">Products</a>
                    <select class="w-20 outline-none hover:font-bold" onchange="window.location.href=this.value;">
                        <option value=""> Orders </option>
                        <option value="{{ route('user.ordersDetails') }}">Order Details</option>
                        <option value="{{ route('user.orderItems') }}">Order Items</option>
                        <option value="{{ route('user.shippedOrders') }}">Shipped Items</option>
                    </select>
                    <a href="{{ route('transactions') }}" class="hover:font-bold">Transaction</a>
                    <select class="w-20 bg-white outline-none hover:font-bold" name="" id="" onchange="window.location.href=this.value;">
                        <option value=""> Others</option>
                        <option value="{{ route('admin.users') }}">Admin </option>
                        <option value="{{ route('admin.register') }}">Admin Register</option>
                    </select>
                    <div class="">
                        <a href="{{ route('logout') }}" class="text-red-500 hover:font-bold">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>

<script>
      let isMenuClick = false;
    const menuSlide = document.getElementById('menuSlide');

    function toggleMenu() {
        isMenuClick = !isMenuClick;
        menuSlide.style.right = isMenuClick ? "0px" : "-208px";
    }
    
</script>