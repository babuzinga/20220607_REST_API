<?php
include_once '../header.php';

// https://mcs.mail.ru/blog/vvedenie-v-rest-api

$method = 'post';
if (!empty($_POST['method']) && in_array($_POST['method'], ['post', 'get', 'put', 'delete'])) {
  $fields = [];
  $fields['field1'] = !empty($_POST['field1']) ? $_POST['field1'] : 'hello1!';
  $fields['field2'] = !empty($_POST['field2']) ? $_POST['field2'] : 'hello2!';

  $response = request('http://20220607-training.local/REST_API/server.php', $fields, $_POST['method']);

  $method = $_POST['method'];
}

?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../style.css">
  <title>REST API</title>
</head>
<body>
<section>
  <a href="/index.html">Index</a>

  <h1>REST API</h1>
  <p><b>Representational State Transfer (REST API)</b> — передачей состояния представления или организация в серверном
    приложении возможности предоставления доступа к своим данным клиентскому приложению (виджет на другом сайте,
    мобильное приложение или бот) по определенному URL.</p>
  <p><b>Application Programming Interface (API)</b> — программный интерфейс приложения</p>
  <form action="/REST_API/client.php" method="post">
    <fieldset>
      <legend>Методы HTTP (CRUD)</legend>
      <input type="radio" id="method1" name="method" value="post" <?= $method == 'post' ? 'checked' : ''; ?>>
      <label for="method1"><b>POST</b> — создание новых записей (Create)</label>
      <br>
      <input type="radio" id="method2" name="method" value="get" <?= $method == 'get' ? 'checked' : ''; ?>>
      <label for="method2"><b>GET</b> — метод чтения информации (Read)</label>
      <br>
      <input type="radio" id="method3" name="method" value="put" <?= $method == 'put' ? 'checked' : ''; ?>>
      <label for="method3"><b>PUT</b> — редактирование записей (Update)</label>
      <br>
      <input type="radio" id="method4" name="method" value="delete" <?= $method == 'delete' ? 'checked' : ''; ?>>
      <label for="method4"><b>DELETE</b> — удаление записей (Delete)</label>
    </fieldset>

    <br>

    <fieldset>
      <legend>Данные</legend>
      Field 1: <input type="text" name="field1" value="Hello server!">
      <br>
      Field 2: <input type="text" name="field2" value="How are you doing?">
    </fieldset>

    <br>

    <button type="submit">Request</button>
  </form>

  <?php if (!empty($response)) : ?><div class="response"><h3>Response server:</h3><pre><?= print_r($response, 1); ?></pre></div><? endif; ?>
</section>
</body>
</html>
