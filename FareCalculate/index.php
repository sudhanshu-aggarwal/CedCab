<?php

require_once('locationArray.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CedCab</title>
    <link rel="stylesheet" href="index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <div id="logo">
            <img src="images/logo.png" alt="CEDCAB" width="100px" height="100px">
            <h1>CEDCAB</h1>
        </div>
        <nav class="navlinks">
            <a href="#">Home</a>
            <a href="#">Contact Us</a>
            <a href="#">Login</a>
        </nav>
    </header>
    <div id="main">
    <h1>Book a City Taxi to your destination in town</h1>
    <h3>Choose from a range of categories and prices</h3>
        <div id="data">
            <label for="pickup" class="form-label" id="labelPickup">Enter Pickup Location</label>
            <select class="form-select" aria-label="Default select example" name="pickup" id="pickup">
                <option value="Pickup" selected disabled>Pickup Location</option>
                <?php
                foreach (locations as $key => $value) {
                ?>
                    <option value="<?= $key ?>"><?= $key ?></option>
                <?php
                } ?>
            </select><br>
            <label for="drop" class="form-label" id="labelDrop">Enter Drop Location</label>

            <select class="form-select" aria-label="Default select example" name="drop" id="drop">
                <option value="Drop" selected disabled>Drop Location</option>
                <?php
                foreach (locations as $key => $value) {
                ?>
                    <option value="<?= $key ?>"><?= $key ?></option>
                <?php
                } ?>
            </select><br>
            <label for="cabtype" class="form-label" id="labelCabtype">Enter Cab Type</label>

            <select class="form-select" aria-label="Default select example" name="cabtype" id="cabtype">
                <option value="cabtype" selected disabled>Cab Type</option>
                <?php
                foreach (cabtypes as $key => $value) {
                ?>
                    <option value="<?= $key ?>"><?= $value ?></option>
                <?php
                } ?>
            </select><br>
            <div class="input-group mb-3">
                <span class="input-group-text" id="labelLuggage">Luggage</span>
                <input type="number" class="form-control" aria-label="Dollar amount (with dot and two decimal places)" placeholder="Luggage in KG" id="luggage">
            </div>
            <button type="submit" class="btn btn-dark" id="calculate">Calculate Fare</button>
            </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ride Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Book Ride</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>


<script>
    let selected = [];
    $('#cabtype').change(() => {
        if ($('#cabtype').val() == 'CedMicro') {
            $('#luggage').val('');
            $('#luggage').prop('disabled', true);
            $('#luggage').attr('placeholder', 'Luggage not allowed');
        } else {
            $('#luggage').prop('disabled', false);
            $('#luggage').attr('placeholder', 'Luggage in KG');
        }
    });

    $('#pickup').change(() => {
        $('#drop').children('option[value="' + selected[0] + '"]').show();
        selected[0] = $('#pickup').val();
        $('#drop').children('option[value="' + selected[0] + '"]').hide();
    });

    $('#drop').change(() => {
        $('#pickup').children('option[value="' + selected[1] + '"]').show();
        selected[1] = $('#drop').val();
        $('#pickup').children('option[value="' + selected[1] + '"]').hide();
    });

    $('#calculate').click((e) => {
        e.preventDefault();
        if ($('#pickup').val() == null) {
            $('#labelPickup').text('Please Select Pickup Location');
            $('#labelPickup').css('color', '#870900');
        } else if ($('#drop').val() == null) {
            $('#labelPickup').text('Select Pickup Location');
            $('#labelPickup').css('color', 'black');
            $('#labelDrop').text('Please Select Drop Location');
            $('#labelDrop').css('color', '#870900');
        } else if ($('#cabtype').val() == null) {
            $('#labelPickup').text('Select Pickup Location');
            $('#labelPickup').css('color', 'black');
            $('#labelDrop').text('Select Drop Location');
            $('#labelDrop').css('color', 'black');
            $('#labelCabtype').text('Please Select Cab Type');
            $('#labelCabtype').css('color', '#870900');
        } else {
            $.ajax({
                url: 'calculateFare.php',
                method: 'post',
                data: {
                    pickup: $('#pickup').val(),
                    drop: $('#drop').val(),
                    cabtype: $('#cabtype').val(),
                    luggage: $('#luggage').val()
                },
                success: (res) => {
                    let response = JSON.parse(res);
                    $('.modal-body').html('Pickup Location: ' + response[0] + '<br>Drop Location: ' + response[1] + '<br>Distance: ' + response[2] + ' KM<br>Total Fare: ' + response[3]);
                    $('#exampleModal').modal('show');
                }
            });
        }
    });
</script>

</html>