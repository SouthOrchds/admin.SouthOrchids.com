<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    @if($errors->any())
    <div class="absolute inset-x-0 text-center bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded max-sm:text-start" role="alert">
        <strong class="font-bold">Whoops!</strong>
        {{-- <span class="block sm:inline max-sm:text-sm">Something went wrong:</span> --}}
        <ul class="mt-2 ml-4 list-disc list-inside  max-sm:text-sm max-sm:mt-0 max-sm:ml-0">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="flex justify-center items-center h-screen md:p-16 md:items-start max-sm:p-10 max-sm:items-start ">
        <div class="p-10 border w-96 shadow-md md:w-full max-sm:w-full ">
            <p class="text-2xl font-medium text-center md:text-3xl">Login Page</p>
            <div class="py-10 flex justify-center">
                <form action="{{ route('admin.check') }}" method="POST">
                    @csrf
                    <div class="py-1 md:py-5">
                        <p class="pb-1 text-lg md:text-xl">Email:</p>
                        <input type="email" name="email" id="" class="border outline-none p-1 w-56 shadow md:w-96">
                    </div>
                    <div class="py-2 md:py-5">
                        <p class="pb-1 text-lg md:text-xl">Password:</p>
                        <input type="password" name="password" class="border outline-none p-1 w-56 shadow md:w-96">
                    </div>
                    <div class="text-center mt-5">
                        <button type="submit" class="border px-3 py-1 font-medium bg-blue-500 text-white rounded md:px-5">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>