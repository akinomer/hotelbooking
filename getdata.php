<?php

include('vt.php');


if($_GET['tip']=='photo'){
    $vtbak = $db->customQuery('SELECT * FROM photos WHERE id='.$_GET['id'])->getRow();
    echo $vtbak->icerik;
}

if($_GET['tip']=='facilities'){
    $vtbak = $db->customQuery('SELECT * FROM facilities WHERE id='.$_GET['id'])->getRow();
    echo $vtbak->icerik;
}

if($_GET['tip']=='reviews'){
    $vtbak = $db->customQuery('SELECT * FROM reviews WHERE id='.$_GET['id'])->getRow();
    echo $vtbak->icerik;
}

if($_GET['tip']=='payment'){
    $vtbak = $db->customQuery('SELECT * FROM payment WHERE id='.$_GET['id'])->getRow();
    echo $vtbak->icerik;
}


    
