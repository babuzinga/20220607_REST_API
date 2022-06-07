<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



class Server
{

}



if (in_array($_SERVER['REQUEST_METHOD'], ['PUT', 'POST'])) parse_str(file_get_contents('php://input'), $_REQUEST);
elseif ($_SERVER['REQUEST_METHOD'] === 'GET') $_REQUEST = $_GET;
else $_REQUEST = [];

echo '<pre><b>REQUEST_METHOD: ', $_SERVER['REQUEST_METHOD'], '</b><br><br>', print_r($_REQUEST, 1), '</pre>';