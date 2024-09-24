<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Belajar Validation di Laravel dengan form login sederhana</h1>
    <form action="/login" method="post">
        @csrf
        <div>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="{{ old('username') }}" placeholder="masukkan username anda">
            @error('username')
            <p>{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="masukkan password anda">
            @error('password')
            <p>{{ $message }}</p>
            @enderror
        </div>
        <div>
            <input type="submit" value="Login">
        </div>
    </form>
</body>
</html>