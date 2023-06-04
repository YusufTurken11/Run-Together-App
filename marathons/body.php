<div class="pt-5">
<div class="pt-5">
<div class="pt-3">
<div class="container text-white">
<form action="" method="post">
<?php
if(isset($_POST['join_button'])){
$marathon_id = $_POST['join_button'];
$InsertJoinRun = $DBConnection->prepare("INSERT INTO marathon_joins (user_id, post_id) VALUES (?,?)");
$InsertJoinRun->execute([$UserId, $marathon_id]);

header('Location: index.php?page=7');
exit();
}

if(isset($_POST['cancel_button'])){ // İşte yeni eklenti
$marathon_id = $_POST['cancel_button'];
$DeleteJoinRun = $DBConnection->prepare("DELETE FROM marathon_joins WHERE user_id = ? AND post_id = ?");
$DeleteJoinRun->execute([$UserId, $marathon_id]);

header('Location: index.php?page=7');
exit();
}


$Select_Marathon = mysqli_query($conn, "SELECT * FROM `marathons`") or die('query failed');
$count = 0;
if (mysqli_num_rows($Select_Marathon) > 0) {
while ($fetch_marathons = mysqli_fetch_assoc($Select_Marathon)) {
if($count > 0){
$margin_top = 5;
}else{
$margin_top = 0;
$count++;
}

$JoinCheck = $DBConnection->prepare("SELECT * FROM marathon_joins WHERE user_id = ? AND post_id = ?");
$JoinCheck->execute([$UserId, $fetch_marathons['id']]);
$joined = $JoinCheck->rowCount() > 0;
?>

<div class="row p-3 bg-black bg-opacity-75 rounded-2 mt-<?= $margin_top ?>">
<div class="col-md-3">
<img src="assets/images/marathon_background.jpg" alt="" class="img-fluid rounded-3">
</div>
<div class="col-md-6 text-center my-auto ps-5">
<h1><b><?= $fetch_marathons['name'] ?></b></h1>
<p class="fs-4"><?= $fetch_marathons['description'] ?></p>
</div>
<div class="col-md-3 text-center my-auto ps-5">
<?php if($joined): ?>
<button type="submit" name="cancel_button" value="<?= $fetch_marathons['id'] ?>" class="btn btn-lg fs-2 btn-danger px-4">Cancel</button>
<?php else: ?>
<button type="submit" name="join_button" value="<?= $fetch_marathons['id'] ?>" class="btn btn-lg fs-2 btn-success px-4">Join!</button>
<?php endif; ?>
</div>
</div>

<?php
}
}
?>

</form>
</div>
</div>
</div>
</div>
