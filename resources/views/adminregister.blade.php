<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <p>Register Page</p>
        <form action="{{ route('adminRegister') }}" method="POST">
            @csrf
            <div>
                <p>Name :</p>
                <input type="text" name="name" id="">
            </div>
            <div>
                <p>Email :</p>
                <input type="email" name="email" id="">
            </div>
            <div>
                <p>Password :</p>
                <input type="password" name="password" id="">
            </div>
            <div>
                <p>Confirm Password :</p>
                <input type="password" name="confirm_password" id="">
            </div>
            <div>
                <p>Phone Number :</p>
                <input type="number" name="phone_no" id="">
            </div>
            <div>
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>