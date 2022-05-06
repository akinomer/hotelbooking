<?php
session_start();
ob_start();

/*
echo print_r($_POST,1);

echo "https://booking-com.p.rapidapi.com/v1/hotels/search-filters?dest_id=".strval($_POST['destId'])."&units=metric&filter_by_currency=USD&locale=en-gb&room_number=".$_POST['roomnumber']."&checkout_date=".$_POST['checkout']."&order_by=popularity&checkin_date=".$_POST['checkin']."&adults_number=".$_POST['adult']."&dest_type=city&children_number=".$_POST['children']."&children_ages=5%2C0&categories_filter_ids=facility%3A%3A107%2Cfree_cancellation%3A%3A1&page_number=".$_POST['pagenumber'];

exit;*/


function searchHotel($dest_id, $roomnumber, $checkout, $checkin, $adult, $children, $pagenumber=0){
    
    $curl = curl_init();
    if($children>=1){
        $url = "https://booking-com.p.rapidapi.com/v1/hotels/search?dest_id=".$dest_id."&units=metric&filter_by_currency=USD&locale=en-gb&room_number=".$roomnumber."&checkout_date=".$checkout."&order_by=popularity&checkin_date=".$checkin."&adults_number=".$adult."&dest_type=city&children_number=".$children."&children_ages=5%2C0&categories_filter_ids=facility%3A%3A107%2Cfree_cancellation%3A%3A1&page_number=".$pagenumber;
    }else{
        $url = "https://booking-com.p.rapidapi.com/v1/hotels/search?dest_id=".$dest_id."&units=metric&filter_by_currency=USD&locale=en-gb&room_number=".$roomnumber."&checkout_date=".$checkout."&order_by=popularity&checkin_date=".$checkin."&adults_number=".$adult."&dest_type=city&children_ages=5%2C0&categories_filter_ids=facility%3A%3A107%2Cfree_cancellation%3A%3A1&page_number=".$pagenumber;
    }
    
    curl_setopt_array($curl, [
            CURLOPT_URL => $url,
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

include 'vt.php';

$data = [
    "record"    =>  searchHotel(strval($_POST['destId']), $_POST['roomnumber'], $_POST['checkout'], $_POST['checkin'], $_POST['adult'], $_POST['children'], $_POST['pagenumber'])
];

$_SESSION['adult'] = $_POST['adult'];
$_SESSION['children'] = $_POST['children'];
$_SESSION['checkout'] = $_POST['checkout'];
$_SESSION['checkin'] = $_POST['checkin'];
$_SESSION['roomnumber'] = $_POST['roomnumber'];

$db->table("aramalar")->insert($data);

echo $db->lastInsertId();

?>