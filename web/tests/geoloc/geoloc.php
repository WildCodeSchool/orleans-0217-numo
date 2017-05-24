<?php
    // --- adresse par défaut ---
    $adresse = '45000 Orléans, France';
    $lat = 47.9108329;
    $lng = 1.9157977;

    // --- recup adresse transmise
    if (isset($_GET['lat']) && isset($_GET['lng'])) {
        $lat = $_GET['lat'];
        $lng = $_GET['lng'];
        if (isset($_GET['adresse'])) {
            $adresse = urldecode($_GET['adresse']);
        } else {
            $adresse = '';
        }
    }


// --------------------------------------------------------------------------------------------------------------------------------
// NOTE : pour obtenir une clé d'API valide, voir ici : https://developers.google.com/maps/documentation/javascript/get-api-key#key
// --------------------------------------------------------------------------------------------------------------------------------
    $apikey = 'AIzaSyD5FbMBpVejJw6o_4r3eHkUQQde6vlDItg';

?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8" />
    <title>Test Google Map</title>
</head>

<body>
    <p>
        Adresse : <?php echo $adresse; ?>
    </p>
    <p>
        lattitude : <?php echo $lat; ?><br />
        longitude : <?php echo $lng; ?>
    </p>
    <div id="carte" style="width:800px; height:600px;"></div>
    <p>
        <a href="geocod.php">Une autre adresse</a>
    </p>

    <script type="text/javascript">
        function initialisation(){
            var centreCarte = new google.maps.LatLng('<?php echo $lat; ?>', '<?php echo $lng; ?>');
            var optionsCarte = {
                zoom: 14,
                center: centreCarte,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
            var maCarte = new google.maps.Map(document.getElementById("carte"), optionsCarte);
            var optionsMarqueur = {
                position: centreCarte,
                map: maCarte,
                title: "Vous etes ici"
            }
                var marqueur = new google.maps.Marker(optionsMarqueur);
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $apikey; ?>&callback=initialisation" async defer></script>

</body>

</html>