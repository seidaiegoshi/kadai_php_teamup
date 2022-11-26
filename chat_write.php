<?php

echo "<pre>";
var_dump($_POST);
echo "</pre>";

$user_name = $_POST['name'];
$file_name = $_POST["fileName"];
$file_path  = "./data/" . $file_name;
// $write_data = "{$_POST['test']}";

$json =
  json_decode(file_get_contents($file_path), true);

echo "<pre>";
var_dump($json["chat"]);
echo "</pre>";



$add_obj = ["name" => $_POST["name"], "text" => $_POST["text"]];
// echo "<pre>";
// var_dump($add_obj);
// echo "</pre>";

array_push($json["chat"], $add_obj);


// echo "<pre>";
// var_dump($json);
// echo "</pre>";


$file = fopen($file_path, "r+");
flock($file, LOCK_EX);
file_put_contents($file_path, '');

fwrite($file, json_encode($json));
flock($file, LOCK_UN);
fclose($file);



// 掲示板の名前が必要なので、POSTで戻る。
// $url = './chat_room.php';

// $data = array(
//   'fileName' => $_POST["fileName"],
// );

// $context = array(
//   'http' => array(
//     'method'  => 'POST',
//     'header'  => implode("\r\n", array('Content-Type: application/x-www-form-urlencoded',)),
//     'content' => http_build_query($data)
//   )
// );

// $html = file_get_contents($url, false, stream_context_create($context));

// //var_dump($http_response_header);

// echo $html;
echo "Location:./chat_room.php?fileName={$file_name}";

header("Location:./chat_room.php?fileName={$file_name}&userName={$user_name}");
