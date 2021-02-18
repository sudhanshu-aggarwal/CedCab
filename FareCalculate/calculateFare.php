<?php



if (isset($_POST['pickup'])) {
    require_once('Ride.php');
    require_once('locationArray.php');
    $pickup = $_POST['pickup'];
    $drop = $_POST['drop'];
    $cabtype = $_POST['cabtype'];
    $luggage = $_POST['luggage'];
    $loc1 = locations["$pickup"];
    $loc2 = locations["$drop"];
    $distance = abs($loc1 - $loc2);

    $obj = new Ride($distance, $cabtype, $luggage);
    $cabtypeFare = $obj->cabtypeFare();
    $luggageFare = $obj->luggageFare();
    $distanceFare = $obj->distanceFare($cabtypeFare);
    $arr = [$pickup, $drop, $distance, ($luggageFare + $distanceFare)];
    $arr = json_encode($arr);
    print_r($arr);
} else {
    echo 'Can\'t Access This File...';
}
