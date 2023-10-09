<style>* { font: 14px "Courier New"; background: #262626; color: white; }</style>

<?php

include_once '../header.php';

/**
 * Преобразует строку в двоичный код
 * https://ru.stackoverflow.com/questions/904284/
 *
 * ord — Конвертирует первый байт строки в число от 0 до 255 (Возвращает код символа Unicode)
 * decbin — Переводит число из десятичной системы счисления в двоичную
 * str_pad — Дополняет строку другой строкой до заданной длины
 *
 * @param $string
 * @return string
 */
function decbin_string($string)
{
  $result = '';
  for ($i = 0; $i < strlen($string); $i++) {
    $decbin = str_pad(decbin(ord($string[$i])), 8, '0', STR_PAD_LEFT);
    $result .=
      $string[$i] . ' : ' .
      str_pad(ord($string[$i]), 3, '0', STR_PAD_LEFT) . ' : ' .
      $decbin . '<br/>';
  }

  return $result;
}

/**
 * Encrypt/decrypt with XOR in PHP
 * https://stackoverflow.com/questions/14673551
 *
 * @param $string
 * @param $key
 * @return mixed
 */
function xor_string($string, $key)
{
  // Перебирает все символы строки и заменяет её на значение полученное
  // в результате побитового оператора XOR (Исключающее или)
  for ($i = 0; $i < strlen($string); $i++)
    $string[$i] = ($string[$i] ^ $key[$i % strlen($key)]);

  return $string;
}

/**
 * Замена слов в тексте
 * @param $string
 * @param $arr
 * @return string|string[]
 */
function replace_chr($string, $arr)
{
  return nl2br(str_replace(str_split($arr['from']), str_split($arr['in']), $string));
}

/**
 * Расчет частоты распределения букв в тексте
 * @param $string
 * @return array
 */
function freq($string)
{
  $eng      = 'abcdefghijklmnopqrstuvwxyz ';
  $eng_full = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz ';
  $rus      = 'абвгдеёжзийклмнопрстуфхцчшщъыьэюя ';
  $rus_full = 'АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыьэюя ';
  $num      = '0123456789';

  $all = strlen($string);
  $result = [];
  for ($i = 0; $i < strlen($eng); $i++)
    $result[$eng[$i]] = round(substr_count($string, $eng[$i]) / $all * 100, 3);

  arsort($result);
  return $result;
}

/**
 * Перевод символа в двоичный код
 * @param $char
 * @param int $len
 * @return string
 */
function char_to_bin($char, $len = 8)
{
  $r = is_numeric($char) ? decbin($char) : decbin(ord($char));
  $r = str_pad($r, $len, '0', STR_PAD_LEFT);

  return $r;
}

// 1.1 ============================================================================================================== //
//echo decbin_string('creature_creature_creature');
//echo xor_string('creature_creature_creature', '>$18');
// 1.2 ============================================================================================================== //
//echo xor_string(file_get_contents('tmp/The Conscience of a Hacker.txt'), 'The Conscience of a Hacker');
//echo xor_string(file_get_contents('tmp/The Conscience of a Hacker.txt'), '1981');
// 1.3 Частотный анализ ============================================================================================= //
/*$text = file_get_contents('tmp/tatu.txt');
//echo replace_chr($text, ['from'  => 'zyxwvutsrqponmleikbghfdcj', 'in' => 'ABCDEFGHIJKLMNOVRPYTSUWXQ']);

// Частоты распределения букв в английском языке
// ETAOINSRHLDCUMFPGWYBVKXJQZ
$freq_eng = [
    'a' => 0.0804,
    'b' => 0.0154,
    'c' => 0.0306,
    'd' => 0.0399,
    'e' => 0.1251,
    'f' => 0.0230,
    'g' => 0.0196,
    'h' => 0.0549,
    'i' => 0.0726,
    'j' => 0.0016,
    'k' => 0.0067,
    'l' => 0.0414,
    'm' => 0.0253,
    'n' => 0.0709,
    'o' => 0.0760,
    'p' => 0.0200,
    'q' => 0.0011,
    'r' => 0.0612,
    's' => 0.0654,
    't' => 0.0925,
    'u' => 0.0271,
    'v' => 0.0099,
    'w' => 0.0192,
    'x' => 0.0019,
    'y' => 0.0173,
    'z' => 0.0009,
    ' ' => 0.1500,
];
// Сортировка частот от наибольшей к наименьшей
arsort($freq_eng);
// Подсчет частот букв в текст
$freq_text = freq($text);
// Замена
echo replace_chr($text, ['from'  => implode(array_keys($freq_text)), 'in' => ' ETAOINSRHLDCUMFPGWYBVKXJQZ',]);*/
// 1.6 ============================================================================================================== //
/*$mask_pass1 = 'XXXXX';  // 26 : ABCDEFGHIJKLMNOPQRSTUVWXYZ
$mask_pass2 = 'XXXX';   // 72 : ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890!@#$%^&()*

$var1 = 26 + pow(26, 2) + pow(26, 3) + pow(26, 4) + pow(26, 5);
$var2 = 72 + pow(72, 2) + pow(72, 3) + pow(72, 4);

echo $var1 / 50000, '<br/>', $var2 / 50000;*/
// 1.16 ============================================================================================================= //
// 21 - 124


$files = [
  'all.php',
  'auth.php',
  'auth.txt',
  'base.txt',
  'chat.html',
  'config.php',
  'count.txt',
  'count_new.php',
  'counter.dat',
  'counter.php',
  'create.php',
  'dat.db',
];

$t1 = '<table border="1"><tr>';
foreach ($files as $key => $file) {
  if ($key != 0 && $key % 3 === 0) $t1 .= '</tr><tr>';
  $t1 .= "<td>{$file}</td>";
}
$t1 .= '</tr></table>';
echo $t1;

echo '<br>';

$t2 = '<table border="1"><tr>';
$i = $j = 0;
foreach ($files as $key => $file) {
  if ($key != 0 && $key % 3 === 0) {
    $t2 .= '</tr><tr>';
    $i++; $j = 0;
  }
  $t2 .= "<td>{$files[$i + $j]}</td>";
  $j += 4;
}
$t2 .= '</tr></table>';
echo $t2;
















