<?php
// UUID名でjsonファイルを作成

$my_personality = $_GET["personality"];
// var_dump($my_personality);

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

// exit();
header("Location:./room_list.php?personality=$my_personality");
