<?php

// ***** tests de lecture des agendas *****



$key = '1F6bZ8wy4X1IU7Myf7lJxcwwE5UdnBFo';

$data = json_decode(file_get_contents("https://api.openagenda.com/v1/agendas?key=$key"));

//    var_dump($data);

echo 'Succès = '; if ($data->success) echo 'True'; else echo 'False'; echo '<br />';
echo 'Code = '.$data->code.'<br />';
if (!$data->success) echo 'Message = '.$data->message.'<br />';
else {

    echo '<hr>';
    foreach ($data->data as $evt) {
        echo 'uid : '.$evt->uid.'&nbsp;&nbsp;&nbsp;<a href="test3.php?uid='.$evt->uid.'" target="_blanc">Lire</a><br />';
        echo 'title : <span style="color:blue;">'.$evt->title.'</span><br />';
        echo 'description : '.$evt->description.'<br />';
        echo 'image : '.$evt->image.'<br />';
        echo 'url : '.$evt->url.'<br />';
        echo 'link : '.$evt->link.'<br />';
        echo 'updatedAt : '.$evt->updatedAt.'<br />';
        echo '<hr>';
    }


}

