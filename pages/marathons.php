<?php
    if(isset($_SESSION['User'])){
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marathons</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="shortcut icon" href="assets/images/logo_mini_transparent.png" />
    <link rel="stylesheet" href="style/homepage.css">
</head>

<body style="background-image: url(assets/images/marathon_background.jpg); background-size: cover;">

    <?php
        include 'homepage/head.php';
        include 'marathons/body.php';
    ?>

    <?php
}else{
    header('location:index.php?page=1');
}
?>

</body>

</html>