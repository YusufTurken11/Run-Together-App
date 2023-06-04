<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
<link rel="stylesheet" href="style/login.css">
<link rel="shortcut icon" href="assets/images/logo_mini_transparent.png"/>
</head>

<body style="background-image: url('assets/images/register_background.png');">
<div class="container">
<div class="row">
<div class="col-md-4"></div>
<div class="col-md-4 shadow-lg rounded-4 p-4 bg-secondary bg-opacity-25">
<img src="assets/images/logo_transparent.png" alt="logo" class="w-100 mb-3">
<?php
if(isset($_SESSION['User'])){
header('location:index.php');
}else{
if($_POST){
$email = $_POST["email"];
$password = $_POST['password'];

$trimed_email = trim($email);
$trimed_password = trim($password);

if($email != ""){
if($password != ""){
$UserValidation = $DBConnection->prepare("SELECT * FROM users WHERE email = ? and password = ? ");
$UserValidation->execute([$trimed_email, md5(md5(md5($trimed_password)))]);
$UserValidationCount = $UserValidation->rowcount();
if($UserValidationCount > 0){
$_SESSION['User'] = $trimed_email;
header('location:index.php');
}
}
}
}
}
?>
<form method="post">

<label for="email" class=" mb-2 fs-5 fw-bold">Email</label>
<input type="email" id="email" name="email" placeholder="E-mail" class="form-control">
<div class="row">
<div class="col-12">
<label for="password" class="mt-3 mb-2 fs-5 fw-bold">Password</label>
<input type="password" id="password" name="password" placeholder="Password" class="form-control shadow-lg">
</div>
<div class="col-12 mt-4 text-center">
<button type="submit" class="btn btn-outline-light btn-lg register-button" name="register">Login</button>
</div>
<div class="col-md-6">
<a href="index.php" class="homepage-button">Homepage</a>
</div>
<div class="col-md-6 text-end">
<a href="index.php?page=2" class="homepage-button">Register</a>
</div>
</div>
</form>
</div>
<div class="col-md-4">

</div>
</div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"
integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous">
</script>
</body>

</html>