<?php

// ***** tests de lecture via l'API *****


// --- clé de connexion (fixe, liée au compte openagenda)
$key = '1F6bZ8wy4X1IU7Myf7lJxcwwE5UdnBFo';

// --- préconfiguration pour tests
//$a_uid = '91057368'; $slug='duri-wild';
$a_uid = '40023427'; $slug='paloaltours';

//$e_uid = '44566425'; // event 1 de duri-wild
//$e_uid = '20736833'; // event 2 de duri-wild
//$e_uid = '12248394'; // event 3 de duri-wild
$e_uid = '27506375'; // event 3 de duri-wild

$lat = 47.9108329; $lng = 1.9157977; // Orleans
//$lat = 47.3832745; $lng = 0.6897966; // Tours




//$requete = "https://api.openagenda.com/v1/agendas/uid/$slug?key=$key";   //OK (200) retourne agenda uid.

//$requete = "https://api.openagenda.com/v1/agendas/$a_uid/events?key=$key";   //OK (200) retourne un tableau des x premiers evenements.
/*
//--------------------------------------------------------------------
// les parametres possibles pour la requete ci-dessus
$params = [
    'offset' => 0,                                // numero du 1er element de la liste retourne - fonctionne
    'limit' => 5,                                 // nombre d'objets retournes - fonctionne
//    'what' => 'confirmer',                           // mot-cle de recherche - accent plante, ne fonctionne pas
//    'when' => '24/05/2017',                         // date ou plage '01/05/2017-01/06/2017' - ne fonctionne pas
//    'page' => 2,                                  // ne fonctionne pas
    'lang' => 'fr',                                 // fonctionne, mais ne semble pas servir
    'order' => 'latest',                            // fonctionne (du plus recent au plus vieux si present)
            // note : order s'appuie sur la derniere date de mise a jour, pas la date de l'evenement
//    'last_update' => '',                             // exemple : '2014-07-16T14:17:34' - non teste
//    'last_delete' => '',                             // exemple : '2014-07-16T14:17:34' - non tests
//    'lat' => '47.910',                              // doit etre couple avec lng - ne fonctionne pas
//    'lng' => '1.915',                               // doit etre couple avec lat - ne fonctionne pas
//    'radius' => '5000',                             // rayon exprime en metres, necessite lat et lng - ne fonctionne pas
];

$requete = "https://api.openagenda.com/v1/agendas/$a_uid/events?";
foreach ($params as $opt => $value) {
    $requete .= "$opt=$value&";
}
$requete .= "key=$key";
//----------------------------------------------------------------------
*/
//$requete = "https://api.openagenda.com/v1/agendas/$a_uid/events/$e_uid?key=$key";   // erreur http : failed to open stream (bad request)

//$requete = "https://api.openagenda.com/v1/events/$e_uid?key=$key";  // return data=false (200)
//$requete = "https://api.openagenda.com/v1/events?when=29/05/2017&key=$key";  // return data=false (200)

//$requete = "https://api.openagenda.com/v1/events?uid=$e_uid&key=$key";  // bad request (400)
//$requete = "https://api.openagenda.com/v1/events?key=$key"; // bad request (400)
//$requete = "https://api.openagenda.com/v1/events?uids[]=$e_uid&key=$key"; // retourne vide (200)
//$requete = "https://api.openagenda.com/v1/events?uids[]=$e_uid&uids[]=$e_uid&key=$key"; // retourne vide (200)
//$requete = "https://api.openagenda.com/v1/agendas/$a_uid/events?uids[]=$e_uid&key=$key"; // retourne la liste complete (200)
//$requete = "https://api.openagenda.com/v1/agendas/$a_uid/events?key=$key";   // retourne la liste complete (200)

//$data = json_decode(file_get_contents($requete));
//
//echo $requete;
//    var_dump($data);


// boucle pour recuperer tous les evenements
$offset = 0;
$evtboucle = 20;
$events = [];
while ($evtboucle == 20) {
    $requete = "https://api.openagenda.com/v1/agendas/$a_uid/events?offset=$offset&limit=$evtboucle&key=$key";
//    $requete .= "&lat=$lat&lng=$lng&radius=5000"; // ne fonctionne pas
    $data = json_decode(file_get_contents($requete));
    $evtboucle = count($data->data);
    for ($i=0; $i<$evtboucle; $i++) {
        $events[$offset+$i] = $data->data[$i];
    }
    $offset += $evtboucle;
}
echo 'nombre evt = '.count($events).'<br />';

// affiche evts dont date entre datedeb et datefin (inclus)
$datedeb = '2017-05-30';
$datefin = '2017-06-05';
$selevt = [];
foreach ($events as $event) {
    $found = false;
    $locations = $event->locations;
    foreach ($locations as $location) {
        $dates = $location->dates;
        foreach ($dates as $date) {
            if ($date->date >= $datedeb && $date->date <= $datefin ) {
                $found = true;
            }
        }
    }
    if ($found) {
        $selevt[] = $event;
    }
}
echo 'Plage de sélection : '.$datedeb.' - '.$datefin.' ('.count($selevt).' évènements trouvés)<br />';
foreach ($selevt as $evt) {
    var_dump($evt->locations);
}
