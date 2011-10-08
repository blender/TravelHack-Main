<?php
	include 'dump_r.php';

$path= "http://www.commutegreener.com/api/co2/emissions?startLat=57.7097704&startLng=11.9661608&endLat=57.6969943&endLng=11.9865&format=json" ;
$out =toArray(json_decode (file_get_contents("$path")) ) ; 

$out= $out['emissions'] ;

$allco2= 0 ;
foreach($out as $record) {
    $allco2  = $allco2+  $record['totalCo2'];
    }
echo "((((" . $allco2. "))))" ;
var_dump($out );
die ;


function toArray( $data )
{
  if ( is_object( $data ) )
  {
    $data = get_object_vars( $data );
  }
  return is_array($data) ? array_map(__FUNCTION__, $data) : $data;
}

?>