<?php


$url="http://localhost/api/v1/students/1";
$ch=curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);
$out=curl_exec($ch);
$jsonOut=json_decode($out, true);
// print_r($jsonOut); 

$name=$jsonOut[0]["name"];
$year=$jsonOut[0]["year"];
$grades=$jsonOut[0]["grades"];

echo "Name of student : ".  $name ."\n";
echo "\n Grades of ".$name." are : ".$grades;

curl_close($ch);

?>