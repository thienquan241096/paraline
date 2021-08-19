<?php
session_start();
require_once './vendor/autoload.php';
require_once './common_const.php';

if (isset($_GET['controller'])) {
    $controller = $_GET['controller'];
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
    } else {
        $action = 'index';
    }
} else {
    $controller = 'pages';
    $action = 'home';
}
require_once('routes.php');