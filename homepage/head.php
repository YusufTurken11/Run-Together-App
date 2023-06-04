<div class="shadow-lg p-3 fixed-top bg-light bg-opacity-75">
    <div class="row">
        <div class="col-md-3 text-start">
            <a href="index.php">
                <img src="assets/images/logo_transparent.png" alt="" height="40px">
            </a>
        </div>
        <div class="col-md-6 text-center">
            <span class="mx-2">
                <a href="index.php?page=5" class="btn shadow header-button">Local Runs</a>
            </span>
            <span class="mx-2">
                <a href="index.php?page=7" class="btn shadow header-button">Marathons</a>
            </span>
        </div>
        <div class="col-md-3 text-end">
            <?php
                if(isset($_SESSION['User'])){
            ?>
                <a href="#" class="btn btn-success shadow-lg"><?= $Username ?></a>
                <a href="index.php?page=3" class="btn btn-secondary shadow-lg">Logout</a>
            <?php
                }else{
            ?>
                <a href="index.php?page=2" class="btn shadow mx-2 header-button">Register</a>
                <a href="index.php?page=1" class="btn shadow header-button">Login</a>
            <?php
                }
            ?>
        </div>
    </div>
</div>