<?php
$controllers = array(
    'pages' => ['home', 'error'],
    'login' => ['login', 'logout'],
    'admin' => ['list', 'getInsert', 'postInsert', 'getEdit', 'postEdit', 'delete', 'postSearch'],
    'user' => ['list', 'getEdit', 'postEdit', 'delete', 'login', 'logout', 'postSearch'],
); // Các controllers trong hệ thống và các action có thể gọi ra từ controller đó.

// Nếu các tham số nhận được từ URL không hợp lệ (không thuộc list controller và action có thể gọi
// thì trang báo lỗi sẽ được gọi ra.
// var_dump($controller);
// echo '<br>';
// echo '<pre>';
// print_r($controllers);
// die;
if (!array_key_exists($controller, $controllers) || !in_array($action, $controllers[$controller])) {
    $controller = 'pages';
    $action = 'error';
}

// Nhúng file định nghĩa controller vào để có thể dùng được class định nghĩa trong file đó
include_once('Controllers/' . $controller . 'Controller.php');
// var_dump($controller);
// Tạo ra tên controller class từ các giá trị lấy được từ URL sau đó gọi ra để hiển thị trả về cho người dùng.

$Class = $controller . 'Controller';
$controller = new $Class;
// var_dump($controller);

$controller->$action();