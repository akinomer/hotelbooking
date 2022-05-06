<?php
    include('vt.php');
    
    if($_GET['tip']=='sendreservation'){
        $db->table('reservation')->insert($_POST);
        exit;
    }
    
    $hotel = $db->customQuery("SELECT * FROM aramalar WHERE id=".$_GET['vtid'])->getRow();
    $index = $_GET['index'];
    $hotel_details = json_decode($hotel->record,1)['result'][$index];
    
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Hotel Detail</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <style>
            .bg-light {
                background-color: rgba(0, 0, 0, 0.3) !important;
            }
            .navbar-brand{
                color: white !important;
            }
            .card{
                margin-top: 20px;
                right: 10px;
                float: right;
                background-color: rgba(255,255,255, 0.9) !important;
            }
            .price{
                font-size: 32px !important;
            }
            .navigasyon{
                padding: 25px;
                background-color: rgba(0,0,0, 0.9) !important;
                color: white;
            }
            .navigasyon span{
                margin-right: 10px;
            }
            .tab-pane{
                padding: 15px;
            }
            .lightbox {
                /* Default to hidden */
                display: none;

                /* Overlay entire screen */
                position: fixed;
                z-index: 999;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;

                /* A bit of padding around image */
                padding: 1em;

                /* Translucent background */
                background: rgba(0, 0, 0, 0.8);
              }

              /* Unhide the lightbox when it's the target */
              .lightbox:target {
                display: block;
              }

              .lightbox span {
                /* Full width and height */
                display: block;
                width: 100%;
                height: 100%;

                /* Size and position background image */
                background-position: center;
                background-repeat: no-repeat;
                background-size: contain;
              }

              
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                
                <div class="col-md-12">
                    <div class="main-content" style="height: 500px; background-image: url(<?=$hotel_details['max_1440_photo_url']?>); background-position: center center;background-repeat: no-repeat; background-size: cover;">
                        <nav class="navbar navbar-expand-lg navbar-light bg-light">
                            <div class="container-fluid">
                                <a class="navbar-brand" href="#"><?=$hotel_details['hotel_name']?></a>
                                <span class="navbar-text">
                                    <button type='button' class="btn btn-success" data-toggle="modal" data-target="#myModal">Reserve</button>
                                    <div class="modal" id="myModal">
                                        <div class="modal-dialog">
                                          <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                              <h7 class="modal-title"><?=$hotel_details['hotel_name']?> Reservation</h7>
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <form id='reservationForm'>
                                                <table class="table">
                                                    <tr><td>Your Name</td><td><input type="text" name='name' class="form-control" id="name"></td></tr>
                                                    <tr><td>Your Lastame</td><td><input type="text" name='lastname' class="form-control" id="lastname"></td></tr>
                                                    <tr><td>Your E-mail Adress</td><td><input type="text" name='email' class="form-control" id="email"></td></tr>
                                                    <tr><td>Your Mobile Number</td><td><input type="text" name='mobile' class="form-control" id="mobile"></td></tr>
                                                    <tr><td colspan="2"><p>Not</p><textarea class="form-control" name="extranote" id="extranote"></textarea></td></tr>
                                                </table>
                                                </form>
                                                <div id="sonuc"></div>
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="button" onclick="sendReservation();" class="btn btn-primary">Send</button>
                                            </div>

                                          </div>
                                        </div>
                                      </div>
                                </span>
                            </div>
                        </nav> 
                        <div class="card" style="width: 14rem;">
                            <div class="card-body">
                                <p style="float: right;" class="price"><?=$hotel_details['min_total_price']?> <small><?=$hotel_details['currencycode']?></small></p>
                                <hr>
                                <p class="card-text" style="float: left;">
                                    <i class="fa fa-trophy" aria-hidden="true"></i>
                                    Review Score: <b><?=$hotel_details['review_score']?></b>
                                </p>
                                <p class="card-text" style="float: left;">
                                    <i class="fa fa-comments-o" aria-hidden="true"></i>
                                    Review Amount: <b><?=$hotel_details['review_nr']?></b>
                                </p>
                                <p class="card-text" style="float: left;">
                                    Checkin <br><b><small>From <?=$hotel_details['checkin']['from']?> - Until <?=$hotel_details['checkin']['until']?> </small> </b>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="navigasyon">
                        <span>
                            <i class="fa fa-users" aria-hidden="true"></i>
                            Adult: <b><?=$_SESSION['adult']?></b>
                        </span>
                        <span style="float: left;">
                            <i class="fa fa-child" aria-hidden="true"></i>
                            Child: <b><?=$_SESSION['children']?></b>
                        </span>
                        <span class="card-text" style="float: right;">
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                            Check-in / Check-out: <b><?=$_SESSION['checkin']?> / <?=$_SESSION['checkout']?></b>
                        </span>
                    </div>   
                </div>
                <div class="col-md-12">
                    <ul class="nav nav-tabs" role="tablist" style="margin-top:10px;">
                        <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Location</a>
                        </li>
                        <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Hotel Photos</a>
                        </li>
                        
                        <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-4" role="tab">Reviews</a>
                        </li>
                        <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-5" role="tab">Facilities</a>
                        </li>
                    </ul><!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabs-1" role="tabpanel">
                            <p><div id="googleMap" style="width:100%;height:480px;"></div></p>
                        </div>
                        <div class="tab-pane" id="tabs-2" role="tabpanel">
                            <div class="row text-center text-lg-start" id="photos">
                            </div>
                        </div>
                        
                        <div class="tab-pane" id="tabs-4" role="tabpanel">
                            <div class="row" id="reviews"></div>
                        </div>
                        <div class="tab-pane" id="tabs-5" role="tabpanel">
                            <div class="row" id="facilities"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
            
            
            function sendReservation(){
                
                if($('#name').val()==''){
                    $('#sonuc').html('<div class="alert alert-warning" role="alert"><b>Please input your name</b></div>');
                }
                else if($('#lastname').val()==''){
                    $('#sonuc').html('<div class="alert alert-warning" role="alert"><b>Please input your lastname</b></div>');
                }
                else if($('#mobile').val()==''){
                    $('#sonuc').html('<div class="alert alert-warning" role="alert"><b>Please input your mobile number</b></div>');
                }
                else{
                   $.ajax({
                        type: 'post',
                        url: 'hoteldetail.php?tip=sendreservation',
                        data: $("#reservationForm").serialize(),
                        success: function (data) {
                            $('#sonuc').html('<div class="alert alert-success" role="alert"><b>Thank you very much</b><br>Your reservation has been added to our system. We will be back to you as soon as possible.</div>');
                        }
                    }); 
                }
                
            }
            
            $( ".nav-link" ).click(function() {
               
                if($(this).text()=='Reviews'){
                    $.get("bringdata.php?hotel_id=<?=$hotel_details['hotel_id']?>&tip=reviews", function(data, status){
                        console.log(data);
                        $.get("getdata.php?tip=reviews&id="+data, function(data, status){
                            var cisin = JSON.parse(data)['result'];
                            console.log(cisin.length);
                            for(var i=0; i < cisin.length; i++){
                                if(cisin[i]['pros']!=''){
                                    $('#reviews').append(`
                                        <div class='col-md-12'>
                                            <span><b>`+cisin[i]['title']+`</b></span>
                                            <span style='float: right;'><small>Score: <b>`+cisin[i]['average_score'].toFixed(1)+`</b></small></span>
                                            <p>`+cisin[i]['pros']+`<br><small>Date: <b>`+cisin[i]['date']+`</b></small></p>
                                            
                                        </div>
                                    `);
                                }
                            }
                        });
                    });
                }
                if($(this).text()=='Facilities'){
                    $.get("bringdata.php?hotel_id=<?=$hotel_details['hotel_id']?>&tip=facilities", function(data, status){
                        console.log(data);
                        $.get("getdata.php?tip=facilities&id="+data, function(data, status){
                            var cisin = JSON.parse(data);
                            console.log(cisin.length);
                            for(var i=0; i < cisin.length; i++){
                                $('#facilities').append(`
                                    <div class='col-md-4' style='margin-top:10px;'>
                                        <b>`+cisin[i]['facility_name']+`</b><br>
                                        <small>`+cisin[i]['facilitytype_name']+`</small>
                                    </div>
                                `);
                            }
                        });
                    });
                }
                if($(this).text()=='Hotel Photos'){
                    $.get("bringdata.php?hotel_id=<?=$hotel_details['hotel_id']?>&tip=photos", function(data, status){
                        $.get("getdata.php?tip=photo&id="+data, function(data, status){
                            var cisin = JSON.parse(data);
                            console.log(cisin.length);
                            for(var i=0; i < cisin.length; i++){
                                $('#photos').append(`<div class="col-lg-3 col-md-4 col-6">
                                    <a href='#galphoto-`+i+`' onclick='getImgUrl(this);' data-url="`+cisin[i]['url_max']+`" class="d-block mb-4 h-100">
                                      <img class="img-fluid img-thumbnail" style='width: 70%; height:auto:' src="`+cisin[i]['url_square60']+`" alt="">
                                    </a>
                                    <a href="#" class="lightbox" id="galphoto-`+i+`">
                                        <span style="background-image: url('`+cisin[i]['url_max']+`')"></span>
                                    </a>
                                </div>`);
                            }
                        });
                    });
                }
            });
            
            $( document ).ready(function() {
                var lat = parseFloat(<?=$hotel_details['latitude']?>);
                var lng = parseFloat(<?=$hotel_details['longitude']?>);
                const myLatLng = { lat: lat, lng: lng };
                const map = new google.maps.Map(document.getElementById("googleMap"), {
                  zoom: 15,
                  center: myLatLng,
                });

                new google.maps.Marker({
                  position: myLatLng,
                  map,
                  title: "<?=$hotel_details['hotel_name']?>",
                });
            });
        </script>
        
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBxteZOFFJL6FJvWDBOrmKO3sHHSbq0hm4&callback=myMap"></script>
<!-- Creates the bootstrap modal where the image will appear -->


    </body>
</html>
