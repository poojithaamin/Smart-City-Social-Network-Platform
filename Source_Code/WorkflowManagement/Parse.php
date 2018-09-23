<?php
$searchPolice = 'police, crime, theft, loot, murder, fire';
$searchAnimal = 'animal, dog, stray';
$searchTransportation = 'road, accident, breakdown';


$arrayPolice = explode(', ', $searchPolice);
$arrayAnimal = explode(', ', $searchAnimal);
$arrayTransportation = explode(', ', $searchTransportation);

$contents = $argv[1];
//$contents = "help theft";
$contents = strtolower($contents);

foreach($arrayPolice as $value) 
{
$value = "/^.*$value.*\$/m";
if(preg_match_all($value, $contents, $matches)){
   echo "Police Department";
   $flag = "Police Department";
   return $flag;
}
}
foreach($arrayAnimal as $value) 
{
$value = "/^.*$value.*\$/m";
if(preg_match_all($value, $contents, $matches)){
   echo "AnimalCare Department";
   $flag = "Animal Care Department";
   return $flag;
}
}
foreach($arrayTransportation as $value) 
{
$value = "/^.*$value.*\$/m";
if(preg_match_all($value, $contents, $matches)){
   echo "Transportation Department";
   $flag = "Transportation Department";
   return $flag;
}
}
//return $flag;
echo $flag;
