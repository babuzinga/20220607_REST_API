<?php
include_once '../header.php';

// https://www.php.net/manual/ru/pdo.drivers.php
// https://p0vidl0.info/php-pdo-rabotaem-s-bazami-dannyx-pravilno.html

$host       = 'localhost';
$db         = 'hueta';
$user       = 'root';
$password   = 'root';
$connection = new PDO("mysql:host={$host};dbname={$db};charset=utf8", $user, $password);

// Вставка данных
$uuid = generate_uuid4();
$code = generate_code(10);
$name = find_random_item(['Tom', 'Oliver', 'Noah', 'Jack', 'Liam', 'Olivia', 'Emma', 'Charlotte', 'Amelia', 'Lucas', 'Sophia']);
$connection->exec("INSERT INTO users VALUES ('{$uuid}', '{$name}', '{$code}')");



// TODO Связанные параметры (экранирование записываемыз данных)
$statement = $connection->prepare('SELECT * FROM users WHERE name = ?');
$results = $connection->execute([$name]);

// Удаление данных (случайно)
$connection->exec('DELETE FROM users ORDER BY RAND() LIMIT 1');

class User
{
  protected $uuid;
  protected $name;

  public function getUUID() { return $this->uuid; }
  public function setUUID($uuid) { $this->uuid = $uuid; }
  public function getName() { return $this->name; }
  public function setName($name) { $this->name = $name; }
}

?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../style.css">
  <title>PDO</title>
</head>
<body>
<section>
  <a href="/index.html">Index</a>

  <h1>PDO</h1>
  <p><b>PHP Data Objects (PDO)</b> — расширение для PHP, предоставляющее разработчику универсальный интерфейс для
    доступа к различным базам данных.</p>
  <p>PDO предлагает единые методы для работы с различными базами данных, хотя текст запросов может немного отличаться.</p>
  <p>PDO позволяет получать данные в разных режимах. Для определения режима, класс PDO содержит соответствующие константы.</p>

  <?php
    $query = 'SELECT * FROM users LIMIT 3';

    echo '<h3>PDO::FETCH_BOTH</h3>';
    foreach ($connection->query($query) as $user) { print_array($user); }

    echo '<h3>PDO::FETCH_ASSOC</h3>';
    $statement = $connection->query($query);
    while($user = $statement->fetch(PDO::FETCH_ASSOC)) { print_array($user); }

    echo '<h3>PDO::FETCH_OBJ</h3>';
    $statement = $connection->query($query);
    while($user = $statement->fetch(PDO::FETCH_OBJ)) { print_array($user); }

    echo '<h3>PDO::FETCH_CLASS</h3>';
    $statement = $connection->query($query);
    $statement->setFetchMode(PDO::FETCH_CLASS, 'User');
    while($user = $statement->fetch()) { print_array($user); }
  ?>

</section>
</body>
</html>
