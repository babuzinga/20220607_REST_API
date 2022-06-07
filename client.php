<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);



  $method = 'post';
  if (!empty($_POST['method']) && in_array($_POST['method'], ['post', 'get', 'put', 'delete'])) {
    $fields = [];
    $fields['field1'] = !empty($_POST['field1']) ? $_POST['field1'] : 'hello1!';
    $fields['field2'] = !empty($_POST['field2']) ? $_POST['field2'] : 'hello2!';

    $response = request('http://20220607-rest-api.local/server.php', $fields, $_POST['method']);

    $method = $_POST['method'];
  }

  /**
   *
   * https://snipp.ru/php/curl
   * @param $url
   * @param bool $fields
   * @param string $method
   * @return mixed
   */
  function request($url, $fields = false, $method = 'get')
  {
    $return_only_content = false;

    $options = array(
      CURLOPT_RETURNTRANSFER  => true,     // return web page
      CURLOPT_HEADER          => false,    // don't return headers
      CURLOPT_FOLLOWLOCATION  => true,     // follow redirects
      CURLOPT_ENCODING        => "",       // handle all encodings
      CURLOPT_USERAGENT       => "spider", // who am i
      CURLOPT_AUTOREFERER     => true,     // set referer on redirect
      CURLOPT_CONNECTTIMEOUT  => 120,      // timeout on connect
      CURLOPT_TIMEOUT         => 120,      // timeout on response
      CURLOPT_MAXREDIRS       => 10,       // stop after 10 redirects
      CURLOPT_SSL_VERIFYPEER  => false,    // Disabled SSL Cert checks
      CURLOPT_HTTPHEADER      => [
        "Content-Type: application/json",
        "cache-control: no-cache"
      ],
    );

    if (in_array($method, ['put', 'post', 'delete'])) {
      $options[CURLOPT_POST] = true;
      $options[CURLOPT_POSTFIELDS] = http_build_query($fields);
    }
    if (in_array($method, ['put', 'delete'])) {
      $options[CURLOPT_CUSTOMREQUEST] = mb_strtoupper($method);
    }
    if (in_array($method, ['get'])) {
      $url .= '?' . http_build_query($fields);
    }

    $ch      = curl_init($url);
    curl_setopt_array($ch, $options);
    $content = curl_exec($ch);
    $err     = curl_errno($ch);
    $errmsg  = curl_error($ch);
    $header  = curl_getinfo($ch);
    curl_close($ch);

    $header['errno']   = $err;
    $header['errmsg']  = $errmsg;
    $header['content'] = $content;

    return $return_only_content ? $content : $header;
  }
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>REST API</title>
  <style>
    section { padding: 0 10px; max-width: 600px; margin: 0 auto; }
    form { font-family: "Arial"; font-size: 14px; }
    fieldset { line-height: 2; }
    label { cursor: pointer; }
    pre {
      white-space: pre-wrap;       /* css-3 */
      white-space: -moz-pre-wrap;  /* Mozilla, с 1999 года*/
      white-space: -pre-wrap;      /* Opera 4-6 */
      white-space: -o-pre-wrap;    /* Opera 7 */
      word-wrap: break-word;       /* Internet Explorer 5.5+ */
    }
  </style>
</head>
<body>
<section>
  <!-- https://mcs.mail.ru/blog/vvedenie-v-rest-api -->

  <h1>REST API Example</h1>
  <p><b>Representational State Transfer (REST API)</b> — передачей состояния представления или организация в серверном
    приложении возможности предоставления доступа к своим данным клиентскому приложению (виджет на другом сайте,
    мобильное приложение или бот) по определенному URL.</p>
  <p><b>Application Programming Interface (API)</b> — программный интерфейс приложения</p>
  <form action="/client.php" method="post">
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
