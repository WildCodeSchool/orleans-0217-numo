<?php

// Google Maps Geocoder

// --- Test : recuperer des coordonnees GPS a partir d'une adresse postale

if (isset($_POST['chercher'])) {
    $adresse = urlencode(utf8_encode($_POST['adresse']));
    if (strlen($adresse) == 0 ) $adresse = '*';
    $geocoder = "http://maps.googleapis.com/maps/api/geocode/json?address=$adresse&sensor=false";
    $coord = json_decode(file_get_contents($geocoder));
    if ($coord->status == 'OK') {
        $adresse =$coord->results[0]->formatted_address;
        $lat = $coord->results[0]->geometry->location->lat;
        $lng = $coord->results[0]->geometry->location->lng;
        echo 'Adresse détectée : <span style="color:blue;">'.$adresse.'</span><br />';
        echo '&nbsp;&nbsp;&nbsp;Lattitude : <span style="color:blue;">'.$lat.'</span><br />';
        echo '&nbsp;&nbsp;&nbsp;Longitude : <span style="color:blue;">'.$lng.'</span><br />';
        echo '<br /><br /><a href="geoloc.php?adresse='.$adresse.'&lat='.$lat.'&lng='.$lng.'">Voir sur la carte</a>';

    } else {
        echo $coord->status;
    }
    echo '<br /><br /><a href="geocod.php">Autre adresse</a>';
} else {
    echo '
        <form action="geocod.php" method="post">
            <label for="adresse">Adresse recherchée :</label><br />
            <input type="text" name="adresse" id="adresse" size="100"><br />
            <br />
            <input type="submit" name="chercher" value="Chercher">
        </form>
    ';
}

