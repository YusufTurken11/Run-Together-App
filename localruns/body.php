<?php

if (isset($_POST['join_run'])) {
    $run_id = $_POST['join_run'];

    $Select_Post_User_Match = mysqli_query($conn, "SELECT * FROM `run_joins` WHERE user_id = '$UserId' AND post_id = '$run_id'") or die('query failed');
    $fetch_Select_Post_User_Match = mysqli_fetch_assoc($Select_Post_User_Match);
    if ($fetch_Select_Post_User_Match) {
        header('Location: index.php?page=5');
        exit();
    } else {
        $InsertJoinRun = mysqli_prepare($conn, "INSERT INTO run_joins (user_id, post_id) VALUES (?,?)");
        mysqli_stmt_bind_param($InsertJoinRun, "ii", $UserId, $run_id);
        mysqli_stmt_execute($InsertJoinRun);

        header('Location: index.php?page=5');
        exit();
    }
}

if(isset($_POST['cancel_run'])){
    $run_id = $_POST['run-id'];
    mysqli_query($conn, "DELETE FROM run_joins WHERE user_id = '$UserId' AND post_id = '$run_id'");
    header('Location: index.php?page=5');
}

?>
<form action="" method="post">
    <div class="row w-100 my-5">
        <?php
        $Select_Runs = mysqli_query($conn, "SELECT * FROM `run_post`") or die('query failed');
        if (mysqli_num_rows($Select_Runs) > 0) {
            while ($fetch_runs = mysqli_fetch_assoc($Select_Runs)) {
        ?>
                <div class="col-2"></div>
                <div class="col-8 rounded shadow mb-5 p-0">
                    <div id="map" style="height: 500px;" class="rounded-top"></div>
                    <div class="row px-4 py-3">
                        <div class="col-12">
                            <p class="text-white fs-1 fw-bold"><?= $fetch_runs['name'] ?></p>
                            <p class="mt-2 fs-5"><?= $fetch_runs['description'] ?></p>
                        </div>
                        <hr>

                        <div class="col-9 text-start">
                            <p class="fs-4 opacity-75"><u>Details</u></p>
                            <p class="fs-5">Host:
                                <?php
                                $temp_id = $fetch_runs['owner'];
                                $Select_User = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$temp_id'") or die('query failed');
                                $fetch_user_for_post = mysqli_fetch_assoc($Select_User);
                                echo $fetch_user_for_post['name'] . " " . $fetch_user_for_post['surname'] . " (" . $fetch_user_for_post['username'] . ")";
                                ?>
                            </p>
                            <p id="distance" class="fs-5"></p>
                            <p class="fs-5">Start Point: <?= $fetch_runs['location'] ?></p>
                            <p class="fs-5">End Point: <?= $fetch_runs['destination'] ?></p>
                            <p class="fs-5">Date: <?= $fetch_runs['date'] ?></p>
                        </div>
                        <div class="col-3 text-center my-auto">
                            <?php
                            $run_id = $fetch_runs['id'];
                            $Select_Post_User_Match = mysqli_query($conn, "SELECT * FROM `run_joins` WHERE user_id = '$UserId' AND post_id = '$run_id'") or die('query failed');
                            $fetch_Select_Post_User_Match = mysqli_fetch_assoc($Select_Post_User_Match);
                            if ($fetch_Select_Post_User_Match) {
                                ?>
                                <input type="hidden" name="run-id" value="<?= $fetch_runs['id'] ?>">
                                <button type="submit" name="cancel_run" class="btn btn-lg btn-danger fs-4">Cancel</button>
                                <?php
                            } else {
                                ?>
                                <button type="submit" name="join_run" value="<?= $fetch_runs['id'] ?>"
                                        class="btn btn-lg btn-warning fs-4">Join Run</button>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-2"></div>
                <script>

            
                    function initMap() {
                        var directionsService = new google.maps.DirectionsService();
                        var directionsRenderer = new google.maps.DirectionsRenderer();
                        var map = new google.maps.Map(document.getElementById('map'), {
                            zoom: 15,
                            center: {lat: -34.397, lng: 150.644}
                        });
                        directionsRenderer.setMap(map);

                        var start = "<?= $fetch_runs['location'] ?>";
                        var end = "<?= $fetch_runs['destination'] ?>";

                        var request = {
                            origin: start,
                            destination: end,
                            travelMode: 'WALKING'
                        };

                        directionsService.route(request, function(result, status) {
                            if (status == 'OK') {
                                directionsRenderer.setDirections(result);
                            }
                        });

                        function calculateDistance(result) {
                        var distance = 0;

                        for (var i = 0; i < result.routes[0].legs.length; i++) {
                            distance += result.routes[0].legs[i].distance.value;
                        }

                        var formattedDistance = (distance / 1000).toFixed(2) + ' km';

                        document.getElementById('distance').innerHTML = 'Distance: ' + formattedDistance;
                        }

                        directionsService.route(request, function(result, status) {
                        if (status == 'OK') {
                        directionsRenderer.setDirections(result);
                
                        calculateDistance(result);

                        
            }
            });
                    }
                </script>
                <script src="https://maps.googleapis.com/maps/api/js?key=API_KEY&callback=initMap" async defer></script>
        <?php
            }
        } else {
            echo "<h2 class='text-center'>No runs found. :(</h2>";
        }
        ?>
    </div>
    </form>
