<?php
 // data marker
 $markers = array(
  array(
   'title'=>'Fakultas Sains dan Teknologi',
   'lat'=>'0.468027',
   'lng'=>'101.355749'
  ),
  array(
   'title'=>'Marker 2',
   'lat'=>'-6.188597',
   'lng'=>'106.58851700000002'
  ),
  array(
   'title'=>'Marker 3',
   'lat'=>'-7.981894',
   'lng'=>'112.62650299999996'
  ),
  array(
   'title'=>'Marker 4',
   'lat'=>'-6.202251',
   'lng'=>'107.001587'
  ),
 );

 // set response
 $response = array(
  'type'=>'FeatureCollection',
  'features'=>array()
 );

 // loop marker
 foreach ($markers as $key=>$val) {
  $title = $val['title'];
  $lat = $val['lat'];
  $lng = $val['lng'];

  // set properties
  $properties = array(
   'title'=>$title
  );

  // push data to features
  array_push($response['features'], array(
   'type'=>'Feature',
   'geometry'=>array(
    'type'=>'Point',
    'coordinates'=>array($lng, $lat)
   ),
   'properties'=>$properties
  ));
 }

 // set response JSON
 header('Content-Type: application/json');
 echo json_encode($response);
