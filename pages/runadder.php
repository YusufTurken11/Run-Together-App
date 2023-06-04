<?php
    if(isset($_SESSION['User'])){
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Add Run</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="shortcut icon" href="assets/images/logo_mini_transparent.png" />
    <link rel="stylesheet" href="style/localruns.css">

    <script
        src="https://maps.googleapis.com/maps/api/js?key=API_KEY&callback=initMap&libraries=geometry,places&v=weekly"
        defer></script>

</head>

<body>
    <div class="text-center">
        <div class="container">
            <form action="" method="post">
                <div class="row w-100 text-white p-3 text-center">
                    <h1>Let's Make a Post</h1>
                    <a href="index.php?page=5" class="text-decoration-none">or Go Home</a>
                    <div class="col-2"></div>
                    <div class="col-8 rounded shadow my-3 p-0">
                        <div class="row px-4 py-3">
                            <div id="map" class="rounded mb-3" style="height: 500px;"></div>
                            <div class="col-12 px-5">
                                <label for="name" class="fs-5 mb-2">Name of Your Run Session</label>
                                <input type="text" id="name" name="name" class="form-control mb-3"
                                    placeholder="Session Name">
                                <label for="name" class="fs-5 mb-2">Description</label>
                                <input type="text" id="name" name="description" class="form-control mb-3"
                                    placeholder="Description">
                            </div>
                            <hr>
                            <div class="col-9 text-start">
                                <p class="fs-4 opacity-75"><u>Details</u></p>
                                <div class="w-25">
                                    <input type="text" class="form-control fs-5" value="<?=$Name?> <?=$Surname?>"
                                        disabled>
                                </div>
                                <p class="fs-5 mt-3 mb-0">Start Point:</p>
                                <input id="pac-input" class="form-control w-75" type="text"
                                    placeholder="Enter a location" name="start-point" />
                                <p class="fs-5 mt-3 mb-0">End Point:</p>
                                <input id="pac-input2" class="form-control w-75" type="text"
                                    placeholder="Enter a location" name="end-point" />
                                <p id="distance" class="fs-5 mt-3 mb-2"></p>
                                <p class="fs-5 mt-3 mb-0">Date:</p>
                                <input type="date" name="date" class="form-control w-25 mt-1">
                            </div>
                            <div class="col-3 text-center my-auto">
                                <button type="submit" name="post_button"
                                    class="btn btn-lg btn-warning fs-4">POST!</button>
                                <?php
                                    if(isset($_POST['post_button'])){
                                        $Request_Name = $_POST['name'];
                                        $Request_Description = $_POST['description'];
                                        $Request_Start_Point = $_POST['start-point'];
                                        $Request_End_Point = $_POST['end-point'];
                                        $Request_Date = $_POST['date'];
                                        
                                        if($Request_Name != "" and $Request_Description != "" and $Request_Start_Point != "" and $Request_End_Point != "" and $Request_Date != ""){
                                            $DB_Write = $DBConnection->prepare("INSERT INTO run_post (name, owner, date, location, destination, description) VALUES (?,?,?,?,?,?)");
                                            $DB_Write->execute([$Request_Name, $UserId, $Request_Date, $Request_Start_Point, $Request_End_Point, $Request_Description]);
                                            header('location:index.php?page=5');
                                        }else{
                                            echo '<div style="text-align: center" class="alert alert-danger py-2 px-0 mt-2">Please Fill Form Correctly!</div>';
                                        }
                                    }
                                ?>
                            </div>

                        </div>
                    </div>
                    <div class="col-2"></div>
                </div>
            </form>
        </div>
    </div>


    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script>
    function initMap() {
        // Harita oluşturma ve ayarları
        const map = new google.maps.Map(document.getElementById("map"), {
            center: {
                lat: 40.749933,
                lng: -73.98633
            },
            zoom: 15,
            mapTypeControl: false,
        });

        // İlgili giriş alanlarını seçme
        const input = document.getElementById("pac-input");
        const input2 = document.getElementById("pac-input2");

        // Otomatik tamamlama nesnelerini oluşturma
        const autocomplete = new google.maps.places.Autocomplete(input);
        const autocomplete2 = new google.maps.places.Autocomplete(input2);

        // İşaretçi oluşturma ve ayarlama
        const marker1 = new google.maps.Marker({
            map,
            anchorPoint: new google.maps.Point(0, -29),
        });
        const marker2 = new google.maps.Marker({
            map,
            anchorPoint: new google.maps.Point(0, -29),
        });

        // İşaretçilerin konumlarını güncelleme
        autocomplete.addListener("place_changed", () => {
            const place = autocomplete.getPlace();
            if (!place.geometry || !place.geometry.location) {
                window.alert("Yer bulunamadı");
                return;
            }
            marker1.setPosition(place.geometry.location);
            marker1.setVisible(true);
            map.setCenter(place.geometry.location);

        });
        autocomplete2.addListener("place_changed", () => {
            const place = autocomplete2.getPlace();
            if (!place.geometry || !place.geometry.location) {
                window.alert("Yer bulunamadı");
                return;
            }
            marker2.setPosition(place.geometry.location);
            marker2.setVisible(true);
            map.setCenter(place.geometry.location);

            // Mesafeyi hesapla ve yazdır
            calculateDistance();
        });

        function calculateDistance() {
            const startLocation = marker1.getPosition();
            const endLocation = marker2.getPosition();

            if (startLocation && endLocation) {
                const distance = google.maps.geometry.spherical.computeDistanceBetween(
                    startLocation,
                    endLocation
                );
                const distanceInKm = (distance / 1000).toFixed(
                2); // Mesafeyi kilometre cinsinden hesapla ve 2 ondalık basamağa yuvarla

                const distanceElement = document.getElementById("distance");
                distanceElement.textContent = `Distance: ${distanceInKm} km`;
            }
        }
    }

    // Harita yüklemesi tamamlandığında "initMap" fonksiyonunu çağırma
    window.initMap = initMap;
    </script>

</body>

</html>

<?php
}else{
    header('location:index.php');
}
?>
