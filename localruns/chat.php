<h3 class="ms-3 mb-2 mt-3">Friends</h3>
<hr class="m-0">

<style>
#chatContainer {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 400px;
    height: 400px;
    background-color: whitesmoke;
    border: 1px solid #ccc;
    display: none;
    z-index: 9999;
}

.overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: none;
    z-index: 9998;
}

#chatHeader {
    background-color: white;
    padding: 10px;
    font-weight: bold;
    color: black;
    font-size: 18px;
}

#chatMessages {
    height: 300px;
    overflow-y: scroll;
    padding: 10px;
}

#chatInput {
    width: 85%;
    border: solid black 1px;
}

.sender {
    display: inline-block;
}

.sender p {
    display: inline-block;
    width: fit-content;
}

.receiver {
    display: inline-block;
}

.receiver p {
    display: inline-block;
    width: fit-content;
}
</style>

<?php

    $Select_Friends = mysqli_query($conn, "SELECT * FROM `friendships` WHERE user_id = $UserId and status = 'accept'") or die('query failed');
    if (mysqli_num_rows($Select_Friends) > 0) {
        while ($fetch_friends = mysqli_fetch_assoc($Select_Friends)) {
            $fetch_friends_friend_id = $fetch_friends['friend_id'];
            $Select_User_Friend = mysqli_query($conn, "SELECT username FROM `users` WHERE id = $fetch_friends_friend_id LIMIT 1") or die('query failed');
            $fetch_friend_username = mysqli_fetch_assoc($Select_User_Friend);
            $friend_username = $fetch_friend_username['username'];


    if(isset($_POST['send_message'])){
        $message = $_POST['message_input'];

        $trimmed_message = trim($message);
        $message_lenght = strlen($trimmed_message);

        if($message_lenght > 0){
            $Insert_Message = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
            $Insert_Message->bind_param("iis", $UserId, $fetch_friends_friend_id, $message);
            $Insert_Message->execute();

        }
        
    }

?>

<div class="row p-2 mx-1 my-2 shadow">
    <div class="col-8">
        <p class="fs-5 m-0 p-0 pt-2"><?= $friend_username ?></p>
    </div>
    <div class="col-4 text-end pt-2">
        <button name="chatButton" id="chatButton" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-chat-left-dots" viewBox="0 0 16 16">
                <path
                    d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                <path
                    d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
            </svg>
        </button>

    </div>
</div>

<div id="chatContainer" class="rounded-3">
    <div id="chatHeader" class="rounded-3">Chat<sub> (<?= $friend_username ?>)</sub></div>

    <div id="chatMessages">

    <?php
    $Select_Messages = mysqli_query($conn, "SELECT sender_id, message, created_at FROM `messages` WHERE sender_id = $UserId OR receiver_id = $UserId ORDER BY created_at ASC");

    if(mysqli_num_rows($Select_Messages) > 0){
        while($fetch_messages = mysqli_fetch_assoc($Select_Messages)){
            $sender_id = $fetch_messages['sender_id'];
            $message = $fetch_messages['message'];
            $created_at = date('d.m.Y H:i', strtotime($fetch_messages['created_at']));
            
            if($sender_id == $UserId){
                // Giden mesaj
?>
                <div class="w-100 text-end my-2">
                    <div class="bg-primary rounded-5 p-1 sender">
                        <p class="text-white m-0 me-2 ms-2"><?= $message ?> <small class="text-muted"><sub> (<?= $created_at ?>)</sub></small></p>
                        
                    </div>
                </div>
<?php
            } else {
                // Gelen mesaj
?>
                <div class="w-100 text-start my-2">
                    <div class="bg-secondary rounded-5 p-1 receiver">
                        <p class="text-white m-0 me-2 ms-2"><?= $message ?> <small class="text-muted"><sub> (<?= $created_at ?>)</sub></small></p>
                    </div>
                </div>
<?php
            }
        }
    }
?>


</div>

<form action="" method="post">
    <div class="row">
        <div class="col-12">
            <input type="text" id="chatInput" name="message_input" class="rounded-2 p-2" placeholder="Message...">
            <button type="submit" name="send_message" class="btn btn-primary mb-1 ">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-send-fill" viewBox="1 0 16 16">
                    <path
                        d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178Z" />
                </svg>
            </button>
        </div>
    </div>
</div>
</form>

<div class="overlay"></div>

<?php
        }
    }

?>

<script>
var chatButton = document.getElementById("chatButton");
var chatContainer = document.getElementById("chatContainer");
var overlay = document.querySelector(".overlay");

chatButton.addEventListener("click", function(event) {
    event.stopPropagation();
    chatContainer.style.display = "block";
    overlay.style.display = "block";
});

chatContainer.addEventListener("click", function(event) {
    event.stopPropagation();
});

overlay.addEventListener("click", function() {
    chatContainer.style.display = "none";
    overlay.style.display = "none";
});

document.addEventListener("click", function(event) {
    var isChatButtonClicked = chatButton.contains(event.target);

    if (!isChatButtonClicked) {
        chatContainer.style.display = "none";
        overlay.style.display = "none";
    }
});
</script>



<hr class="m-0">



<form action="" method="POST" class="p-3">

    <div class="mb-3">
        <label for="username" class="form-label fs-4">Add Friend</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
    </div>
    <div class="text-end">
        Username: <?= $Username ?>
        <button type="submit" name="add_friend" class="btn btn-primary">Add</button>
        <?php
            if(isset($_POST['add_friend'])){
                $friend_username = $_POST['username'];
                $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
                $stmt->bind_param("s", $friend_username);
                $stmt->execute();
                $result = $stmt->get_result();
                if(mysqli_num_rows($result) > 0){
                    $friend_id = $result->fetch_assoc()["id"];
                    
                    if($friend_id != $UserId){
                        $Friend_Status_Check = $conn->prepare("SELECT status FROM friendships WHERE user_id = ? AND friend_id = ? LIMIT 1");
                        $Friend_Status_Check->bind_param("ss", $UserId, $friend_id);
                        $Friend_Status_Check->execute();
                        $result_status = $Friend_Status_Check->get_result();
                        if(mysqli_num_rows($result_status) > 0){
                            $status = $result_status->fetch_assoc()["status"];
                            if($status == "pending"){
                                echo '<div class="my-2 p-2 bg-dark">Request is Pending</div>';
                            }else if($status == "accept"){
                                echo '<div class="my-2 p-2 bg-dark">Already a Friend</div>';
                            }else if($status == "deny"){
                                echo '<div class="my-2 p-2 bg-dark">Your request Declined</div>';
                            }
                        }else{
                            $InsertRequest = $DBConnection->prepare("INSERT INTO friendships (user_id, friend_id) VALUES (?, ?)");
                            $InsertRequest->execute([$UserId, $friend_id]);
                            $InsertRequestCount = $InsertRequest->rowcount();
                            if($InsertRequestCount == 0){
                                echo '<div class="my-2 p-2 bg-dark">Something Wrong</div>';
                            }else{
                                echo '<div class="my-2 p-2 bg-success">Friend Request Sent!</div>';
                            }
                        }
                    }else{
                        echo '<div class="my-2 p-2 bg-dark">Something Wrong</div>';
                    }

                }else{
                    echo '<div class="my-2 p-2 bg-dark">Something Wrong</div>';
                }
            }
        ?>
    </div>

</form>

<hr class="m-0">

<?php
    if(isset($_POST['deny_request'])){
        $id = $_POST['request_id'];

        $Update_Friend_Status = $conn->prepare("UPDATE friendships SET status = 'deny' WHERE id = ? LIMIT 1");
        $Update_Friend_Status->bind_param("i", $id);
        $Update_Friend_Status->execute();
        header("Location: index.php?page=5");
    }

    if(isset($_POST['accept_request'])){
        $id = $_POST['request_id'];

        $Update_Friend_Status = $conn->prepare("UPDATE friendships SET status = 'accept' WHERE id = ? LIMIT 1");
        $Update_Friend_Status->bind_param("i", $id);
        $Update_Friend_Status->execute();

        $friend_id = $_POST['friend_id'];
        $status = "accept";
        $Insert_Friend = $conn->prepare("INSERT INTO friendships (user_id, friend_id, status) values (?, ?, ?)");
        $Insert_Friend->bind_param("iis", $UserId, $friend_id, $status);
        $Insert_Friend->execute();
        header("Location: index.php?page=5");
    }
?>

<form action="" method="POST" class="p-3">
    <p class="fs-4">Friend Requests</p>
    <?php
        $Select_Requests = mysqli_query($conn, "SELECT * FROM `friendships` WHERE friend_id = $UserId") or die('query failed');
        if (mysqli_num_rows($Select_Requests) > 0) {
            while ($fetch_requests = mysqli_fetch_assoc($Select_Requests)) {
                if($fetch_requests['status'] == "deny" or $fetch_requests['status'] == "accept"){
                    continue;
                }
                $sender_id = $fetch_requests['user_id'];
                $Select_Sender_Username = $conn->prepare("SELECT username FROM users WHERE id = ? LIMIT 1");
                $Select_Sender_Username->bind_param("i", $sender_id);
                $Select_Sender_Username->execute();
                $result = $Select_Sender_Username->get_result();
                if(mysqli_num_rows($result) > 0){
                    $sender_username = $result->fetch_assoc()["username"];
                }
    ?>
    <div class="row shadow p-3">
        <div class="col-md-6">
            <p class="fs-4"><?= $sender_username ?></p>
        </div>
        <div class="col-2"></div>
        <div class="col-md-2 text-end">
            <button type="submit" name="deny_request" class="btn btn-lg btn-danger fs-4 p-0 px-2 pb-1 rounded-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" fill="currentColor" class="bi bi-dash-circle"
                    viewBox="0 0.2 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                    <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z" />
                </svg>
            </button>
            <input type="hidden" name="request_id" value="<?= $fetch_requests['id'] ?>">

        </div>
        <div class="col-md-2 text-center">
            <button type="submit" name="accept_request" class="btn btn-lg btn-success fs-4 p-0 px-2 pb-1 rounded-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" fill="currentColor" class="bi bi-check-lg"
                    viewBox="0 0 16 16">
                    <path
                        d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                </svg>
            </button>
            <input type="hidden" name="friend_id" value="<?= $fetch_requests['user_id'] ?>">
        </div>
    </div>

    <?php
            }
        }
    ?>
</form>