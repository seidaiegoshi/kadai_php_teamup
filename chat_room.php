<?php

// var_dump($_POST["fileName"]);

$htmlElement = "";
$fileName = $_GET["fileName"];
// $write_data = "{$_POST['test']}";

$json =
  json_decode(file_get_contents("./data/" . $fileName), true);
// echo '<pre>';
// var_dump($json);
// echo '</pre>';

$chat_hist = $json["chat"];
// echo '<pre>';
// var_dump(json_encode($chat_hist));
// echo '</pre>';

foreach ($chat_hist as $key => $value) {
  $htmlElement .= "
  <li>
    <span class='name'>{$value["name"]}</span>
    <span class='text'>{$value["text"]}</span>
  </li>";
}
// $file = fopen($fileName, "r");
// flock($file, LOCK_EX);

// fwrite($file, json_encode($text));
// flock($file, LOCK_UN);
// fclose($file);

$user_name = "";
if (isset($_GET["userName"])) {
  $user_name = $_GET["userName"];
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
  <form action="./chat_write.php" method="POST">
    <input type="text" name="fileName" value="<?= $fileName ?>" hidden>
    <input type="text" name="name" value='<?= $user_name ?>'>
    <input type="text" name="text">
    <input type="submit" value="Send">
  </form>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>

</html>