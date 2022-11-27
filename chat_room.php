<?php
// var_dump($_POST);

$file_name = $_POST["fileName"];
$file_path  = "./data/" . $file_name;
$user_name = $_POST['userName'];
$htmlElement = "";
$personality = $_POST['personality'];

if (isset($_POST["text"])) {
  // $_POST["text"]があるか
  if ($_POST["text"] != "") {
    // $_POST["text"]があったとき、空かどうか
    $json =
      json_decode(file_get_contents($file_path), true);

    $json[$personality] = $user_name;
    $add_obj = ["name" => $_POST["userName"], "text" => $_POST["text"]];
    // var_dump($add_obj);
    array_push($json["chat"], $add_obj);

    $file = fopen($file_path, "r+");
    flock($file, LOCK_EX);
    file_put_contents($file_path, '');

    fwrite($file, json_encode($json));
    flock($file, LOCK_UN);
    fclose($file);
  }
}



// テキストがなかったら読み込みだけを行う。
$json =
  json_decode(file_get_contents($file_path), true);



$chat_hist = $json["chat"];
// echo '<pre>';
// var_dump($json["chat"]);
// echo '</pre>';


//初回表示で$json[$personality]が空だったら、入力
if ($json[$personality] = "") {
  $json[$personality] = $personality;
  $file = fopen($file_path, "r+");
  flock($file, LOCK_EX);
  file_put_contents($file_path, '');

  fwrite($file, json_encode($json));
  flock($file, LOCK_UN);
  fclose($file);
}

foreach ($chat_hist as $key => $value) {
  $htmlElement .= "
        <li>
          <span class='name'>{$value["name"]}</span>
          <span class='text'>{$value["text"]}</span>
        </li>";
}


?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Document</title>
  <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<header>
  <a href="./index.html">team up</a>
</header>

<body>
  <div>
    <ul>
      <?= $htmlElement ?>
    </ul>
  </div>
  <form action="./chat_room.php" method="POST">
    <input type="text" name="fileName" value="<?= $file_name ?>" hidden>
    <input type="text" name="personality" value="<?= $personality ?>" hidden>
    <input type="text" name="userName" value='<?= $user_name ?>'>
    <input type="text" name="text" value="">
    <input type="submit" value="Send">
  </form>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>

</html>