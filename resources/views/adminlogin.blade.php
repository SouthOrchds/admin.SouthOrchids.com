<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        @if($errors->any())
        <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        </div>
        @endif
        <p>Login Page</p>
        <form action="{{ route('adminCheck') }}" method="POST">
            <p>Email:</p>
            <input type="email" name="email" id="">
            <p>Password:</p>
            <input type="password" name="password">
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>