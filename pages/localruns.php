<?php
    if(isset($_SESSION['User'])){
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Local Runs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="shortcut icon" href="assets/images/logo_mini_transparent.png" />
    <link rel="stylesheet" href="style/localruns.css">
</head>

<style>
.sticky-chat {
    position: sticky;
    top: 0;
    height: 99vh;
}

.sticky-add-button {
    bottom: 2%;
}
</style>

<body>

    <div class=" px-2">
        <div class="row w-100 text-white">
            <div class="col-8">
                <?php
                    include 'localruns/head.php';
                    include 'localruns/body.php';
                ?>
            </div>
            <div class="col-1 px-5">

                <a href="index.php?page=6" class="btn btn-lg btn-warning position-fixed sticky-add-button"><svg
                        xmlns="http://www.w3.org/2000/svg" width="32" fill="currentcolor" class="bi bi-plus-lg"
                        viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
                    </svg>
                </a>
            </div>
            <div class="col-3 shadow chat-scale rounded-lg sticky-chat">
                <?php
                    include 'localruns/chat.php';
                ?>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous">
    </script>
</body>

</html>
<?php
}else{
    header('location:index.php?page=1');
}
?>