<?php
// UUID名でjsonファイルを作成
var_dump(uniqid());

$uniqid = uniqid();
$file_name = "{$uniqid}.json";

$jsonObj = [
  "fileName" => $file_name,
  "roomName" => "新規ルーム",
  "Chimpanzee" => "",
  "Orangutan" => "",
  "Human" => "",
  "Gorilla" => "",
  "Bonobo" => "",
  "chat" => []
];



$file = fopen("./data/{$file_name}", "w");
flock($file, LOCK_EX);

fwrite($file, json_encode($jsonObj));

flock($file, LOCK_UN);
fclose($file);
