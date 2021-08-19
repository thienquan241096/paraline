<?php
$controllers = array(
    'pages' => ['home', 'error'],
    'login' => ['login', 'logout'],
    'admin' => ['list', 'getInsert', 'postInsert', 'getEdit', 'postEdit', 'delete', 'postSearch', 'listDelete'],
    'user' => ['list', 'getEdit', 'postEdit', 'delete', 'login', 'logout', 'postSearch'],
);

if (!array_key_exists($controller, $controllers) || !in_array($action, $controllers[$controller])) {
    $controller = 'pages';
    $action = 'error';
}

include_once('app/Controllers/' . $controller . 'Controller.php');

$Class = $controller . 'Controller';
$controller = new $Class;
$controller->$action();