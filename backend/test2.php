<?php

echo calculateco2(57.7097704, 11.9661608, 57.6969943, 11.9865);
echo "<br>";
echo differentco2(57.7097704, 11.9661608, 57.6969943, 11.9865, "CAR");

function calculateco2($flat, $flg, $tlat, $tlg)
{
$path= "http://api.commutegreener.com/api/co2/tworadial?format=json&startLat=$flat&startLng=$flg&startRadius=3000&endLat=$tlat&endLng=$tlg&endRadius=3000&from=2011-09-12T05%3A00%3A00%2B0000&to=2011-09-12T10%3A00%3A11%2B0000&format=json" ;
$out =toArray(json_decode (file_get_contents("$path")) ) ; 
$out= $out['prospects'] ;
$allco2= 0 ;
foreach($out as $record) {
    $allco2  = $allco2+  $record['grammesCO2'];
    }
 return $allco2 ; 
}

function differentco2($flat, $flg, $tlat, $tlg, $type)
{

$path= "http://www.commutegreener.com/api/co2/emissions?startLat=57.7097704&startLng=11.9661608&endLat=57.6969943&endLng=11.9865&format=json" ;
$out =toArray(json_decode (file_get_contents("$path")) ) ; 

$out= $out['emissions'] ;

if ($type== "BUS" ) {
return( $out[3]["totalCo2"]);
}
elseif ($type== "CAR" ) {
return( $out[5]["totalCo2"]);
}
}


function toArray( $data )
{
  if ( is_object( $data ) )
  {
    $data = get_object_vars( $data );
  }
  return is_array($data) ? array_map(__FUNCTION__, $data) : $data;
}

?>