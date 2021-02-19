<?php

include_once('locationArray.php');

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
    $obj = new Ride($pickup, $drop, $distance, $cabtype, $luggage);
    $cabtypeFare = $obj->cabtypeFare();
    $luggageFare = $obj->luggageFare();
    $distanceFare = $obj->distanceFare($cabtypeFare);
    $totalFare = $obj->totalFare($luggageFare, $distanceFare);
    if($cabtype == 'CedMicro')
    {
        $luggageReturn = "Not Allowed";
    }
    elseif($luggage == ""){
        $luggageReturn = '0 KG';
    }
    else{
        $luggageReturn = "$luggage KG";
    }
    $cabtypeReturn = cabtypes["$cabtype"];
    $arr = [$pickup, $drop, $distance, $totalFare, $luggageReturn, $cabtypeReturn];
    $arr = json_encode($arr);
    print_r($arr);
} else {
    header("Location: index.php");
}
