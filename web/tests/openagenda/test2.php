<?php

// ***** tests de lecture d'un agenda *****

/*
Get the title and description of the agenda.

Parameters:

    uid: uid of the agenda
    key: your public api key
*/

$key = '1F6bZ8wy4X1IU7Myf7lJxcwwE5UdnBFo';
$uid = '91057368';


$data = json_decode(file_get_contents("https://api.openagenda.com/v1/agendas/$uid?key=$key"));

//    var_dump($data);

echo 'Succès = '; if ($data->success) echo 'True'; else echo 'False'; echo '<br />';
echo 'Code = '.$data->code.'<br />';
if (!$data->success) echo 'Message = '.$data->message.'<br />';
else {

//    var_dump($data);

    $evt = $data->data;
    echo '<hr>';
    echo 'title : '.$evt->title.'<br />';
    echo 'uid : '.$evt->uid.'<br />';
    echo 'url : '.$evt->url.'<br />';
    echo 'image : '.$evt->image.'<br />';
    echo 'description : '.$evt->description.'<br />';
    echo 'updatedAt : '.$evt->updatedAt.'<br />';
    echo '<hr>';


}

// --- recuperation des parametres d'entree
if (isset($_GET['uid'])) {
    $uid = $_GET['uid'];
    $data = json_decode(file_get_contents("https://api.openagenda.com/v1/agendas/$uid?key=$key"));

//    var_dump($data);

    echo 'Succès = '; if ($data->success) echo 'True'; else echo 'False'; echo '<br />';
    echo 'Code = '.$data->code.'<br />';
    if (!$data->success) echo 'Message = '.$data->message.'<br />';
    else {

//    var_dump($data);

        $evt = $data->data;
        echo '<hr>';
        echo 'title : '.$evt->title.'<br />';
        echo 'uid : '.$evt->uid.'<br />';
        echo 'url : '.$evt->url.'<br />';
        echo 'image : '.$evt->image.'<br />';
        echo 'description : '.$evt->description.'<br />';
        echo 'updatedAt : '.$evt->updatedAt.'<br />';
        echo '<hr>';


    }
}
