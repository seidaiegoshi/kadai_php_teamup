<?php
// var_dump($_POST);



$room_files = glob('./data/*.json');
$htmlElement  = "";
if ($room_files) {
  foreach ($room_files as $key => $value) {
    // var_dump(json_decode(readfile($value)));
    $room_obj = json_decode(file_get_contents($value), true);
    // var_dump($room_obj);
    // echo ($room_obj['roomName']);

    $htmlElement .= "
    <li>
    <form action='./chat_room.php' method='GET'>
    <input type='text' name='fileName' value='{$room_obj["fileName"]}' hidden>
    {$room_obj["roomName"]}
    <button>入る</button>
    </form>
    </li>
    ";
  }
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
    <a href="./create_chat_room.php">新規作成</a>
  </div>
  <div>
    <ul><?= $htmlElement ?></ul>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>

</html>