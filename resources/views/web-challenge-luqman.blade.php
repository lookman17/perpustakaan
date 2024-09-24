<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
h1 {
  text-align:center}
form {
  max-width: 600px;
  margin: auto;
}
input {
  display: block;
  width: 100%;
  margin-bottom: 10px;
  padding: 8px;
}
.all {
   padding:100px;
   border:1px solid black;
   border-radius:30px;
   background-color:#F5F7F8;
   margin-right:300px;
   margin-left:300px;
}
.all:hover {
    background-color:#201E43;
    color:white;
    transition:0.5s;
    scale:105%;
}
    </style>
</head>
<body>
    <br>
    <h1>Form Sederhana Dengan Laravel</h1>
    <br>
<div class="all">
    <form action="" method="">
        <label for="username">Username</label>
    <input type="text" id="username" name="username" placeholder="Username" required class="form-control" aria-label="Sizing example input">
    <label for="password">Password</label>
    <input type="password" name="password" placeholder="Password" required class="form-control" aria-label="Sizing example input">
    <button type="submit" class="btn btn-success col-6 mx-auto">Login</button>
        <a href=""><button type="button" class="btn btn-link">Forgot Password?</button></a>
        <a href=""><button type="button" class="btn btn-link">Register</button></a>
    </form>
</div>
</body>
</html>