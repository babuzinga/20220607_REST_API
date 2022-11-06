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

echo xor_string('creature_creature_creature', '>$18');
//echo decbin_string('create');