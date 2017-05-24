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


// --- recuperation des evenements de l'agenda
$data = json_decode(file_get_contents("https://api.openagenda.com/v1/agendas/$uid/events?key=$publicKey"));
if (true === $data->success) $infos = $data->data;
var_dump($data);



// --- recuperation des lieux
$e_uid = '97185906';
$l_uid = '46297259';
$url = "https://api.openagenda.com/v1/events/$e_uid/locations?key=$publicKey";
$data = json_decode(file_get_contents($url));
if (true === $data->success) $infos = $data->data;
var_dump($data);
