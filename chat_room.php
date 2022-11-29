<?php
$htmlElement = "";
// ルームに入った、初回のみ、POSTを使う。
//更新はajaxを使う。
if (!empty($_POST)) {
  $file_name = $_POST["fileName"];
  $file_path  = "./data/" . $file_name;
  $user_name = $_POST['userName'];

  $personality = $_POST['personality'];

  $file_size = filesize($file_path);

  $json =
    json_decode(file_get_contents($file_path), true);

  //初回表示で$json[$personality]が空だったら、入力
  if ($json[$personality] == "") {
    $json[$personality] = $personality;
    $file = fopen($file_path, "r+");
    flock($file, LOCK_EX);
    file_put_contents($file_path, '');

    fwrite($file, json_encode($json));
    flock($file, LOCK_UN);
    fclose($file);
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
  <div id="chatLog">
    <ul>
      <?= $htmlElement ?>
    </ul>
  </div>
  <form action="./chat_update.php" method="POST">
    <input type="text" name="fileName" value="<?= $file_name ?>" hidden>
    <input type="text" name="personality" value="<?= $personality ?>" hidden>
    <input type="text" name="userName" id="userName">
    <input type="text" name="text" id="inputText" value="">
    <button type="submit">Send</button>
  </form>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script>
    $("#inputText").focus();

    if ("<?= isset($file_name) ?>" !== "") {
      let t_file_name = `<?= $file_name ?>`;
      let t_user_name = `<?= $user_name ?>`;
      sessionStorage.setItem('file_name', t_file_name);
      sessionStorage.setItem('user_name', t_user_name);
    }
    const file_name = sessionStorage.getItem("file_name");
    const user_name = sessionStorage.getItem("user_name");

    $("[name='fileName']").val(file_name);
    $("[name='userName']").val(user_name);

    $("#userName").on("input", () => {
      sessionStorage.setItem('user_name', $("#userName").val());
    })

    // ajaxで受信し続ける。携帯だと通信量やばくなりそう。。。こんなもんなんかな？
    function readMessage() {

      $.ajax({
          type: 'post',
          url: "./data/" + file_name,
        })
        .then(
          function(data) {
            // console.log(JSON.parse(data));
            let htmlElement = "";
            JSON.parse(data).chat.forEach(element => {
              // console.log(element);
              htmlElement += `
                <li>
                <p>
                  <span class='name'>${element["name"]}</span>:
                  <span class='text'>${element["text"]}</span>
                  </p>
                </li>
              `
            });

            // console.log(htmlElement);
            $('ul').html(htmlElement);
            $("#chatLog")[0].scrollTop = $("#chatLog")[0].scrollHeight;

          },
          function() {
            alert("読み込み失敗");
          }
        );
    }

    readMessage();


    setInterval(readMessage, 1000);
  </script>
</body>

</html>