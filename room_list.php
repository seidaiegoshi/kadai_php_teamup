<?php
// var_dump($_POST["personality"]);

$my_personality = $_POST["personality"];

// jsonファイルを取得
$room_files = glob('./data/*.json');

$htmlElement  = "";
if ($room_files) {
  foreach ($room_files as $key => $value) {
    // 各jsonファイルの処理

    // var_dump(json_decode(readfile($value)));
    $room_obj = json_decode(file_get_contents($value), true);
    // var_dump($room_obj);
    // echo ($room_obj['roomName']);

    $Chimpanzee = $room_obj["Chimpanzee"] ? "●" : "";
    $Orangutan = $room_obj["Orangutan"] ? "●" : "";;
    $Human = $room_obj["Human"] ? "●" : "";;
    $Gorilla = $room_obj["Gorilla"] ? "●" : "";;
    $Bonobo = $room_obj["Bonobo"] ? "●" : "";;

    $htmlElement .= "
    <tr>
    <form action='./chat_room.php' method='POST'>
    <input type='text' name='fileName' value='{$room_obj["fileName"]}' hidden>
    <input type='text' name='userName' value='{$my_personality}' hidden>
    <input type='text' name='personality' value='{$my_personality}' hidden>
    <td>$Chimpanzee</td>
    <td>$Orangutan</td>
    <td>$Human</td>
    <td>$Gorilla</td>
    <td>$Bonobo</td>
    <td>{$room_obj["roomName"]}</td>
    ";

    if ($room_obj[$my_personality] != "") {
      $htmlElement .= " <td><button disabled>入る</button></td>";
    } else {
      $htmlElement .= " <td><button>入る</button></td>";
    }

    $htmlElement .= "
    </form>
    </tr>
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
  <table>
    <tr>
      <td>Chi</td>
      <td>Ora</td>
      <td>Hum</td>
      <td>Gor</td>
      <td>Bon</td>
      <td>部屋の名前</td>
      <td>参加</td>
    </tr>
    <?= $htmlElement ?>
  </table>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>

</html>