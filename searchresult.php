<?php
    include('vt.php');
    
    $searchresults = $db->customQuery('SELECT * FROM aramalar WHERE id='.$_GET['record_id'])->getRow();
    
    
    
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <title>Search Results</title>
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" type="text/css" href="css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
      <style>
          html, body {
            height: 100%;
            margin: 0;
          }
      </style>
   </head>
   <body>
      <section class="main-content">
         <div class="container-fluid">
            <br>
            <div class="row">
                <div class="col-lg-8" style="overflow: scroll; height: 800px;">
                    <?php
                        $map_bounding_box = json_decode($searchresults->record,1)['map_bounding_box'];
                        $json = json_decode($searchresults->record,1)['result'];
                        for($i=0; $i < count($json); $i++){
                       ?> 
                    <div class="place-card">
                      <div class="place-card__img">
                          <a href="hoteldetail.php?hotel_id=<?=$json[$i]['hotel_id']?>&index=<?=$i?>&vtid=<?=$_GET['record_id']?>"><img src="<?=$json[$i]['max_photo_url']?>" class="place-card__img-thumbnail" alt="Thumbnail"></a>
                      </div>
                      <div class="place-card__content">
                          <h4 class="place-card__content_header"><a href="hoteldetail.php?hotel_id=<?=$json[$i]['hotel_id']?>&index=<?=$i?>&vtid=<?=$_GET['record_id']?>" class="text-dark place-title"><?=$json[$i]['hotel_name']?></a> <a href="#!" style="font-size:14px;" class="text-muted"><?=$json[$i]['city']?></a></h4>
                         <p><i class="fa fa-map-marker"></i> <span class="text-muted"><?=$json[$i]['address']?></span></p>
                         <div class="rating-box">
                            <div class="rating-box__items">
                               <!--<div class="rating-stars">
                                  <img src="img/grey-star.svg" alt="">
                                  <div class="filled-star" style="width:90%"></div>
                               </div>-->
                               <span class="ml-1">Review Score <b><?=$json[$i]['review_score']?></b> Review Amount <b><?=$json[$i]['review_nr']?></b> </span>
                            </div>
                            <a href="#!" class="text-muted"></a>
                         </div>
                         <span style="float: left;" class="card-price"><?=$json[$i]['min_total_price']?> <small><?=$json[$i]['currencycode']?></small></span>
                         <span style="float: right;" class="text-muted mb-0 d-none d-sm-block"><button class="btn btn-default" id="hotel-<?=$json[$i]['hotel_id']?>" data-coords="<?=$json[$i]['latitude']?>,<?=$json[$i]['longitude']?>"><i class="fa fa-map-marker" aria-hidden="true"></i> Show on map</button></span>
                      </div>
                   </div>
                    <?php } ?>
                </div>
                
               <div class="col-md-6 col-lg-6 col-xl-4">
                    <div id="googleMap" style="width:100%;height:780px;"></div>
               </div>
            </div>
         </div>
      </section>
       <script>
            
            $( document ).ready(function() {
                var mapDiv = document.getElementById('googleMap');
                var map = new google.maps.Map(mapDiv, {
                  mapTypeId: google.maps.MapTypeId.ROADMAP
                });

                var southWest = new google.maps.LatLng(<?=$map_bounding_box['sw_lat']?>, <?=$map_bounding_box['sw_long']?>);
                var northEast = new google.maps.LatLng(<?=$map_bounding_box['ne_lat']?>, <?=$map_bounding_box['ne_long']?>);
                var bounds = new google.maps.LatLngBounds(southWest,northEast);
                map.fitBounds(bounds);
                
                

                $("[id^=hotel-]").on("click", function(){
                    var coords = $('#'+this.id).data('coords');
                    var lat = parseFloat(coords.split(',')[0]);
                    var lng = parseFloat(coords.split(',')[1]);
                    console.log(lat);
                    const myLatLng = { lat: lat, lng: lng };
                    const map = new google.maps.Map(document.getElementById("googleMap"), {
                      zoom: 15,
                      center: myLatLng,
                    });

                    new google.maps.Marker({
                      position: myLatLng,
                      map,
                      title: "<?=$json[$i]['hotel_name']?>",
                    });
                    
                });
                
                
            });
           
        
        </script>

<script src="https://maps.googleapis.com/maps/api/js?key=xxxx&callback=myMap"></script>
   </body>
</html>
