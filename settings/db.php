<?php
try {
    $conn = mysqli_connect('localhost','root','','run_together') or die('connection failed');

    $DBConnection = new PDO("mysql:host=localhost;dbname=run_together;charset=utf8;",'root','');

    //echo 'DB Conn 200';
}catch(PDOException $e){
    echo $e->getMessage();
}

if(isset($_SESSION['User'])){
    $UserInfos = $DBConnection->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $UserInfos->execute([$_SESSION['User']]);
    $UserInfosCount = $UserInfos->rowcount();
    $UserInfo = $UserInfos->fetch(PDO::FETCH_ASSOC);

    if($UserInfosCount > 0){
        $UserId = $UserInfo['id'];
        $UserEmail = $UserInfo['email'];
        $Username = $UserInfo['username'];
        $Name = $UserInfo['name'];
        $Surname = $UserInfo['surname'];
        $Gender = $UserInfo['gender'];
        $Birth_Date = $UserInfo['birth_date'];
    }
}