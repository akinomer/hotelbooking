<?php

include('vt.php');

function payment($hotel_id){
    $curl = curl_init();

    curl_setopt_array($curl, [
            CURLOPT_URL => "https://booking-com.p.rapidapi.com/v1/hotels/payment-features?locale=en-gb&hotel_id=".$hotel_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER  => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                    "x-rapidapi-host: booking-com.p.rapidapi.com",
                    "x-rapidapi-key: bMv2r8EKJtmshr5wDUxu7hsu7HTop1gsGKXjsnVngQzMX64Qvf"
            ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
            return "cURL Error #:" . $err;
    } else {
            return $response;
    }
}


function reviews($hotel_id){
    $curl = curl_init();

    curl_setopt_array($curl, [
            CURLOPT_URL => "https://booking-com.p.rapidapi.com/v1/hotels/reviews?sort_type=SORT_MOST_RELEVANT&locale=en-gb&hotel_id=".$hotel_id."&language_filter=en-gb%2Cde%2Cfr&customer_type=solo_traveller%2Creview_category_group_of_friends",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER  => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                    "x-rapidapi-host: booking-com.p.rapidapi.com",
                    "x-rapidapi-key: bMv2r8EKJtmshr5wDUxu7hsu7HTop1gsGKXjsnVngQzMX64Qvf"
            ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
            return "cURL Error #:" . $err;
    } else {
            return $response;
    }
}

function facilities($hotel_id){
    $curl = curl_init();

    curl_setopt_array($curl, [
            CURLOPT_URL => "https://booking-com.p.rapidapi.com/v1/hotels/facilities?hotel_id=".$hotel_id."&locale=en-gb",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER  => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                    "x-rapidapi-host: booking-com.p.rapidapi.com",
                    "x-rapidapi-key: bMv2r8EKJtmshr5wDUxu7hsu7HTop1gsGKXjsnVngQzMX64Qvf"
            ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
            return "cURL Error #:" . $err;
    } else {
            return $response;
    }
}

function photos($hotel_id){
    $curl = curl_init();

    curl_setopt_array($curl, [
            CURLOPT_URL => "https://booking-com.p.rapidapi.com/v1/hotels/photos?locale=en-gb&hotel_id=".$hotel_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER  => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                    "x-rapidapi-host: booking-com.p.rapidapi.com",
                    "x-rapidapi-key: bMv2r8EKJtmshr5wDUxu7hsu7HTop1gsGKXjsnVngQzMX64Qvf"
            ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
            return "cURL Error #:" . $err;
    } else {
            return $response;
    }
}

if($_GET['tip']=='photos'){
    
    $vtbak = $db->customQuery('SELECT COUNT(*) AS toplam,id FROM photos WHERE hotel_id='.$_GET['hotel_id'].' GROUP BY id')->getRow();
    if($vtbak->toplam==0){
        $data = [
            'hotel_id'  =>  $_GET['hotel_id'],
            'icerik'    =>  photos($_GET['hotel_id'])
        ];
        $db->table('photos')->insert($data);
        echo $db->lastInsertId();
    }else{
        echo $vtbak->id;
    }
}

if($_GET['tip']=='facilities'){
    $vtbak = $db->customQuery('SELECT COUNT(*) AS toplam,id FROM facilities WHERE hotel_id='.$_GET['hotel_id'].' GROUP BY id')->getRow();
    if($vtbak->toplam==0){
        $data = [
            'hotel_id'  =>  $_GET['hotel_id'],
            'icerik'    =>  facilities($_GET['hotel_id'])
        ];
        $db->table('facilities')->insert($data);
        echo $db->lastInsertId();
    }else{
        echo $vtbak->id;
    }
}

if($_GET['tip']=='reviews'){
    $vtbak = $db->customQuery('SELECT COUNT(*) AS toplam,id FROM reviews WHERE hotel_id='.$_GET['hotel_id'].' GROUP BY id')->getRow();
    if($vtbak->toplam==0){
        $data = [
            'hotel_id'  =>  $_GET['hotel_id'],
            'icerik'    =>  reviews($_GET['hotel_id'])
        ];
        $db->table('reviews')->insert($data);
        echo $db->lastInsertId();
    }else{
        echo $vtbak->id;
    }
}

if($_GET['tip']=='payment'){
    $vtbak = $db->customQuery('SELECT COUNT(*) AS toplam,id FROM payment WHERE hotel_id='.$_GET['hotel_id'].' GROUP BY id')->getRow();
    if($vtbak->toplam==0){
        $data = [
            'hotel_id'  =>  $_GET['hotel_id'],
            'icerik'    =>  payment($_GET['hotel_id'])
        ];
        $db->table('payment')->insert($data);
        echo $db->lastInsertId();
    }else{
        echo $vtbak->id;
    }
}
