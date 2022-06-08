<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * CURl request
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

  $ch = curl_init($url);
  curl_setopt_array($ch, $options);
  $content = curl_exec($ch);
  $err = curl_errno($ch);
  $errmsg = curl_error($ch);
  $header = curl_getinfo($ch);
  curl_close($ch);

  $header['errno'] = $err;
  $header['errmsg'] = $errmsg;
  $header['content'] = $content;

  return $return_only_content ? $content : $header;
}

/**
 * @param int $len
 * @return false|string
 */
function generate_code($len = 10): string
{
  $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_';
  $result = substr(str_shuffle($permitted_chars), 0, $len);

  return $result;
}

/**
 * Генератор UUID значений
 * universally unique identifier «универсальный уникальный идентификатор»
 * https://ru.wikipedia.org/wiki/UUID
 * @return string
 */
function generate_uuid4(): string
{
  // Формат : xxxxxxxx-xxxx-Mxxx-Nxxx-xxxxxxxxxxxx
  return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
    // 32 bits for "time_low" - целое число, обозначающее младшие 32 бита времени
    mt_rand(0, 0xffff), mt_rand(0, 0xffff),

    // 16 bits for "time_mid" - целое число, обозначающее средние 16 бит времени
    mt_rand(0, 0xffff),

    // 16 bits for "time_hi_and_version",
    // 4 старших бита обозначают версию UUID, младшие биты обозначают старшие 12 бит времени
    mt_rand(0, 0x0fff) | 0x4000,

    // 16 bits, 8 bits for "clk_seq_hi_res",
    // 1-3 старших бита обозначают вариант UUID, остальные 13-15 бит обозначают clock sequence
    mt_rand(0, 0x3fff) | 0x8000,

    // 48-битный идентификатор узла
    mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
  );
}

/**
 * Вывод массивов для дебага
 * @param array $array
 * @param bool $exit
 */
function print_array($array = array(), $exit = false)
{
  echo '<pre>', print_r($array, true), '</pre>';
  if ($exit) exit();
}

/**
 * @param $array
 */
function find_random_item(array $array)
{
  $rand_key= array_rand($array);
  $result = $array[$rand_key];

  return $result;
}

/**
 * Возвращает IP-адрес
 *
 * HTTP_X_FORWARDED_FOR - Поле заголовка HTTP X-Forwarded-For (XFF) — это распространенный метод
 * определения исходного IP-адреса клиента, подключающегося к веб-серверу через HTTP-прокси или
 * балансировщик нагрузки.
 *
 * @return mixed
 */
function get_ip()
{
  $ip = (!empty($_SERVER['HTTP_X_FORWARDED_FOR']) && filter_var($_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4))
    ? $_SERVER['HTTP_X_FORWARDED_FOR']
    : $_SERVER['REMOTE_ADDR']
  ;

  return $ip;
}