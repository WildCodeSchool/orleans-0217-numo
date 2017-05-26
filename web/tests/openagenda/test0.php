<?php

// ***** tests de lecture des agendas *****



$publicKey = '1F6bZ8wy4X1IU7Myf7lJxcwwE5UdnBFo';


//$data = json_decode(file_get_contents("https://api.openagenda.com/v1/agendas?key=$publicKey"));

// --- recuperation UID agenda
$nom = 'duri-wild';
//$nom = 'paloaltours';
$data = json_decode(file_get_contents("https://api.openagenda.com/v1/agendas/uid/$nom?key=$publicKey"));
$uid = 'Non trouvé';
if (true === $data->success) $uid = $data->data->uid;
echo $uid;
var_dump($data);

/*
// --- recuperation des evenements de l'agenda
$data = json_decode(file_get_contents("https://api.openagenda.com/v1/agendas/$uid/events?key=$publicKey"));
if (true === $data->success) $infos = $data->data;
var_dump($data);
*/


////$a_uid = '91057368'; $slug='duri-wild'; // agenda
//
//$e_uid = '44566425 '; // event
//$l_uid = '2859504 '; // location
//$url = "https://api.openagenda.com/v1/agendas/$a_uid/events?key=$publicKey";
//echo "<p>$url</p>";
//$data = json_decode(file_get_contents($url));
//if (true === $data->success) $infos = $data->data;
//var_dump($data);
