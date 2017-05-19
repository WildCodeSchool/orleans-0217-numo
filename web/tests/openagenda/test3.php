<?php

// ***** tests de lecture des évènements d'un agenda *****

/*
Use this to fetch events of the agenda

Parameters:

    uid: uid of the agenda
    key: your public api key
    offset: the offset from which to start fetching the events
    limit: the number of events to retrieve (between 0 and 20)
    order: optionally, set this to 'latest' to get an ordering relative to event update timestamps
    last_update: filter events by their last update timestamp (format: YYYY-MM-DDTH:m:s).
*/

// --- clé de connexion (fixe, liée au compte openagenda)
$key = '1F6bZ8wy4X1IU7Myf7lJxcwwE5UdnBFo';
// --- préconfiguration pour tests
$uid = '91057368';

// --- recuperation des parametres d'entree
if (isset($_GET['uid'])) $uid = $_GET['uid'];



function affiche($tab, $texte, $info='*-*-*-*', $option=null) {
    for ($i=0; $i<$tab; $i++) echo '&nbsp;&nbsp;';
//    if ('*-*-*-*' === $info) echo '<br />';
    echo $texte.'<span style="color:green;">';
    if (null === $info) echo '(Null)';
    elseif (true === $info) echo 'True';
    elseif (false === $info) echo 'False';
    elseif ('*-*-*-*' !== $info) echo $info;
    echo '</span> '.$option.'<br />';
}

$data = json_decode(file_get_contents("https://api.openagenda.com/v1/agendas/$uid/events?key=$key"));

//    var_dump($data);

affiche(0, "", "Lecture d'un évènement par son ID (uid)");
echo '<hr>';
affiche(0, "uid : ", $uid);
affiche(0, "key : ", $key);
affiche(0, "Requête : ", "https://api.openagenda.com/v1/agendas/$uid/events?key=$key");
echo '<br /><br />';

affiche(0, '', 'Statut élément récupéré : ');
echo '<hr>';
affiche(0, 'success = ', $data->success);
affiche(0, 'code = ', $data->code);
if (!$data->success) affiche(0, 'message = ', $data->message);
else {

//    var_dump($data);

    echo '<br /><br />';
    affiche(0, '', 'Données de l\'objet récupéré ('.count($data->data).' évènements) :');
    echo '<hr>';
    if (count($data->data) == 0) affiche(3, '', '(Vide)');
    $nevt = 0;
    foreach ($data->data as $evt) {
        affiche(0, '', '--- Evènement '.$nevt.' ---');
        affiche(0, 'uid (string) : ', $evt->uid);
        $tmp = explode('/', $evt->link);
        $lien = 'https://openagenda.com/duri-wild/events/'.end($tmp);
        affiche(0, 'link (string) : ', $evt->link,'<a href="'.$lien.'" target="_blanc">voir sur OpenAgenda</a>');
        affiche(0, 'updatedAt (string) : ', $evt->updatedAt);
        affiche(0, 'spacetimeinfo (string) : ', $evt->spacetimeinfo);
        affiche(0, 'image (string) : ', $evt->image);
        affiche(0, 'imageThumb (string) : ', $evt->imageThumb);
        if (strlen($evt->imageThumb) > 0) echo '<img src="'.$evt->imageThumb.'" height="100" / ><br />';

        affiche(0, 'title (obj)');
//        var_dump($evt->title);
        affiche(3, 'title->fr (string) : ', $evt->title->fr);

        affiche(0, 'description (obj)');
//        var_dump($evt->description);
        affiche(3, 'description->fr (string) : ', $evt->description->fr);

        affiche(0, 'freeText (obj)');
//        var_dump($evt->freeText);
        affiche(3, 'freeText->fr (string) : ', $evt->freeText->fr);

        affiche(0, 'tags (obj)');
//        var_dump($evt->tags);
        affiche(3, 'tags->fr (string) : ', $evt->tags->fr);

        affiche(0, 'locations (array)');
//        var_dump($evt->locations);
        $locations = $evt->locations;
        if (count($locations) == 0) affiche(3, '', '(Vide)');
        else {
            for ($i=0; $i<count($locations); $i++) {
                affiche(3, 'locations['.$i.'] (obj)');
                if (property_exists($locations[$i], 'uid')) affiche(6, 'locations['.$i.']->uid (string) : ', $locations[$i]->uid);
                if (property_exists($locations[$i], 'slug')) affiche(6, 'locations['.$i.']->slug (string) : ', $locations[$i]->slug);
                if (property_exists($locations[$i], 'placename')) affiche(6, 'locations['.$i.']->placename (string) : ', $locations[$i]->placename);
                if (property_exists($locations[$i], 'latitude')) affiche(6, 'locations['.$i.']->latitude (string) : ', $locations[$i]->latitude);
                if (property_exists($locations[$i], 'longitude')) affiche(6, 'locations['.$i.']->longitude (string) : ', $locations[$i]->longitude);
                if (property_exists($locations[$i], 'address')) affiche(6, 'locations['.$i.']->address (string) : ', $locations[$i]->address);
                if (property_exists($locations[$i], 'department')) affiche(6, 'locations['.$i.']->department (string) : ', $locations[$i]->department);
                if (property_exists($locations[$i], 'region')) affiche(6, 'locations['.$i.']->region (string) : ', $locations[$i]->region);
                if (property_exists($locations[$i], 'city')) affiche(6, 'locations['.$i.']->city (string) : ', $locations[$i]->city);
                if (property_exists($locations[$i], 'postalCode')) affiche(6, 'locations['.$i.']->postalCode (string) : ', $locations[$i]->postalCode);
                if (property_exists($locations[$i], 'verified')) affiche(6, 'locations['.$i.']->verified (boolean) : ', $locations[$i]->verified);
                if (property_exists($locations[$i], 'ticketLink')) affiche(6, 'locations['.$i.']->ticketLink (string) : ', $locations[$i]->ticketLink);

                if (property_exists($locations[$i], 'pricingInfo')) {
                    affiche(6, 'locations[' . $i . ']->pricingInfo (obj) : ');
//            var_dump($location->pricingInfo);
                    affiche(9, 'locations[' . $i . ']->pricingInfo->fr (string) : ', $locations[$i]->pricingInfo->fr);
                }

                if (property_exists($locations[$i], 'dates')) {
                    affiche(6, 'locations[' . $i . ']->dates (array) : ');
                    //            var_dump($location->dates);
                    if (count($locations[$i]->dates) == 0) affiche(6, '', '(Vide)');
                    else {
                        for ($j = 0; $j < count($locations[$i]->dates); $j++) {
                            affiche(9, 'locations[' . $i . ']->dates[' . $j . '] (obj)');
                            affiche(12, 'locations[' . $i . ']->dates[' . $j . ']->date (string) : ', $locations[$i]->dates[$j]->date);
                            affiche(12, 'locations[' . $i . ']->dates[' . $j . ']->timeStart (string) : ', $locations[$i]->dates[$j]->timeStart);
                            affiche(12, 'locations[' . $i . ']->dates[' . $j . ']->timeEnd (string) : ', $locations[$i]->dates[$j]->timeEnd);

                        }
                    }
                }

            }
        }

        affiche(0, 'thirdParties (array)');
//        var_dump($evt->thirdParties);
        $thirdParties = $evt->thirdParties;
        if (count($thirdParties) == 0) affiche(3, '', '(Vide)');
        else {
            for ($i=0; $i<count($thirdParties); $i++) {

            }
        }
        $nevt++;
        echo '<hr>';
    }


}

