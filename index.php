<?php

if (!function_exists('apache_request_headers')) {
    function apache_request_headers()
    {
        $headers = array();
        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', strtolower(str_replace('_', ' ', strtolower(substr($key, 5)))))] = $value;
            }
        }
        if (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) $headers['authorization'] = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
        return $headers;
    }
}

session_start();

date_default_timezone_set("America/Sao_Paulo");
setlocale(LC_ALL, 'pt_BR');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");

if (isset($_SERVER['HTTP_ORIGIN'])) {

    header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Credentials: true');
    header("Access-Control-Allow-Methods: *");
}

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: *");
    if (isset($_SERVER['HTTP_ACCESS_CONWTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers:{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

require 'routers.php';
require 'vendor/autoload.php';

$core = new Core\Core();
$core->run();
