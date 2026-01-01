<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
</head>
<body>
@auth
<p>Congrats you're logged in.</p> 
<form action="/logout" method="POST">
    @csrf
    <button>logout</button>
    @else
    <div style="border: 3px solid black;">
    <h2>Register</h2>

    <form action='/register' method="POST">
        @csrf
        <input type="text" name="name" placeholder="Name"><br><br>
        <input type="email" name="email" placeholder="Email"><br><br>
        <input type="password" name="password" placeholder="Password"><br><br>
        <button type="submit">Register</button>
    </form>
</div>
<div style="border: 3px solid black;">
    <h2>login</h2>

    <form action='/login' method="POST">
        @csrf
        <input type='name' name="Loginname" placeholder="Name"><br><br>
        <input type="password" name="Loginpassword" placeholder="Password"><br><br>
        <button type="submit">Login</button>
    </form>
</div>
@endauth


</body>
</html>
