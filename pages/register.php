<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="style/register.css">
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
                            $username = $_POST['username'];
                            $name = $_POST['name'];
                            $surname = $_POST['surname'];
                            if(isset($_POST['gender'])){
                                $gender = $_POST['gender'];
                                if($gender == "1"){
                                    $genderName = "Male";
                                }else if($gender == "2"){
                                    $genderName = "Female";
                                }else{
                                    $genderName = "";
                                }
                            }else{
                                $gender = "";
                            }
                            $date = $_POST['date'];
                            $password = $_POST['password'];

                            $trimed_email = trim($email);
                            $trimed_username = trim($username);
                            $trimed_name = trim($name);
                            $trimed_surname = trim($surname);
                            $trimed_password = trim($password);

                            $lenght_username = strlen($trimed_username);
                            $lenght_name = strlen($trimed_name);
                            $lenght_surname = strlen($trimed_surname);
                            $lenght_password = strlen($trimed_password);

                            if($trimed_email != "" and $trimed_username != "" and $trimed_name != "" and $trimed_surname != "" and $date != "" and $trimed_password != "" and $gender != "" and $gender != "0" and $gender != 0 and $genderName != ""){
                                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                    echo '<div class="alert alert-danger text-center">Invalid E-mail!</div>';
                                }else{
                                    if($lenght_username >= 6 ){
                                        if($lenght_username <= 30){
                                            if($lenght_name >= 2){
                                                if($lenght_name <= 30){
                                                    if($lenght_surname >= 2){
                                                        if($lenght_surname <= 30){
                                                            if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $trimed_username)){
                                                                echo '<div class="alert alert-danger">Special characters cant be used in username!</div>';
                                                            }else{
                                                                if($lenght_password >= 8){
                                                                    if($lenght_password <= 50){
                                                                        $FetchEmailQuery = $DBConnection->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
                                                                        $FetchEmailQuery->execute([$trimed_email]);
                                                                        $FetchEmailQueryCount = $FetchEmailQuery->rowcount();
                                                                        if($FetchEmailQueryCount > 0){
                                                                            echo '<div class="alert alert-danger text-center">Email using on another account!</div>';
                                                                        }else{
                                                                            $FetchUsernameQuery = $DBConnection->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
                                                                            $FetchUsernameQuery->execute([$trimed_username]);
                                                                            $FetchUsernameQueryCount = $FetchUsernameQuery->rowcount();
                                                                            if($FetchUsernameQueryCount > 0){
                                                                                echo '<div class="alert alert-danger text-center">Username already taken!</div>';
                                                                            }else{
                                                                                $InsertUser = $DBConnection->prepare("INSERT INTO users (email, username, name, surname, gender, birth_date, password) values (?, ?, ?, ?, ?, ?, ?)");
                                                                                $InsertUser->execute([$trimed_email, $trimed_username, $trimed_name, $trimed_surname, $genderName, $date, md5(md5(md5($trimed_password)))]);
                                                                                $InsertUserCount = $InsertUser->rowcount();
                                                                                if($InsertUserCount == 0){
                                                                                    echo '<div class="alert alert-danger text-center">Error occured, please try again!</div>';
                                                                                }else if($InsertUserCount > 0){
                                                                                    header('location:index.php?page=1');
                                                                                }
                                                                            }
                                                                        }
                                                                    }else{
                                                                        echo '<div class="alert alert-danger text-center">Password must be under 50 characters!</div>';
                                                                    }
                                                                }else{
                                                                    echo '<div class="alert alert-danger text-center">Password must be at least 8 characters!</div>';
                                                                }
                                                            }
                                                        }else{
                                                            echo '<div class="alert alert-danger text-center">Surname must be under 30 characters!</div>';
                                                        }
                                                    }else{
                                                        echo '<div class="alert alert-danger text-center">Surname must be at least 2 characters!</div>';
                                                    }
                                                }else{
                                                    echo '<div class="alert alert-danger text-center">Name must be under 30 characters!</div>';
                                                }
                                            }else{
                                                echo '<div class="alert alert-danger text-center">Name must be at least 2 characters!</div>';
                                            }
                                        }else{
                                            echo '<div class="alert alert-danger text-center">Username must be under 30 characters!</div>';
                                        }
                                    }else{
                                        echo '<div class="alert alert-danger text-center">Username must be at least 6 characters!</div>';
                                    }
                                }
                            }else{
                                echo '<div class="alert alert-danger text-center">Please fill the form completely!</div>';
                            }
                        }
                    }

                ?>
                    <form method="post">
                        
                        <label for="email" class=" mb-2 fs-5 fw-bold">Email</label>
                        <input type="email" id="email" name="email" placeholder="E-mail" class="form-control">
                        <label for="username" class="mt-3 mb-2 fs-5 fw-bold">Username</label>
                        <input type="text" id="username" name="username" placeholder="Username" class="form-control">
                        <div class="row">
                            <div class="col-xl-6">
                                <label for="name" class="mt-3 mb-2 fs-5 fw-bold">Name</label>
                                <input type="text" id="name" name="name" placeholder="Name" class="form-control shadow-lg">
                            </div>
                            <div class="col-xl-6">
                                <label for="surname" class="mt-3 mb-2 fs-5 fw-bold">Surname</label>
                                <input type="text" id="surname" name="surname" placeholder="Surname" class="form-control shadow-lg">
                            </div>
                            <div class="col-xl-6">
                                <label for="gender" class="mt-3 mb-2 fs-5 text-white fw-bold">Gender</label>
                                <select name="gender" id="gender" class="form-select shadow-lg">
                                    <option disabled selected>Select Gender</option>
                                    <option value="1">Male</option>
                                    <option value="2">Female</option>
                                </select>
                            </div>
                            <div class="col-xl-6">
                                <label for="date" class="mt-3 mb-2 fs-5 fw-bold">Birth Date</label>
                                <input type="date" id="date" name="date" class="form-control shadow-lg">
                            </div>
                            <div class="col-12">
                                <label for="password" class="mt-3 mb-2 fs-5 text-white fw-bold">Password</label>
                                <input type="password" id="password" name="password" placeholder="Password" class="form-control shadow-lg">
                            </div>
                            <div class="col-12 mt-4 text-center">
                                <button type="submit" class="btn btn-outline-light btn-lg register-button" name="register">Register</button>
                            </div>
                            <div class="col-md-6">
                                <a href="index.php" class="homepage-button">Homepage</a>
                            </div>
                            <div class="col-md-6 text-end">
                                <a href="index.php?page=1" class="homepage-button">Login</a>
                            </div>
                        </div>
                    </form>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous">
    </script>
</body>

</html>