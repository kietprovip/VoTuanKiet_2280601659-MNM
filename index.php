<?php
session_start();
require_once 'app/models/ProductModel.php';
require_once 'app/helper/SessionHelper.php';

// Lấy URL từ REQUEST_URI thay vì GET['url']
$request_uri = $_SERVER['REQUEST_URI'];
$base_path = '/VoTuanKiet/'; // Đường dẫn base của project

// Loại bỏ base path và query string
$url = str_replace($base_path, '', $request_uri);
$url = strtok($url, '?'); // Loại bỏ query string
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Debug để kiểm tra
// echo "URL Array: " . print_r($url, true) . "<br>";

// Kiểm tra phần đầu tiên của URL để xác định controller
$controllerName = isset($url[0]) && $url[0] != '' ? ucfirst(strtolower($url[0])) . 'Controller' : 'ProductController';

// Kiểm tra phần thứ hai của URL để xác định action
$action = isset($url[1]) && $url[1] != '' ? strtolower($url[1]) : 'index';

// Debug
// echo "Controller: $controllerName<br>";
// echo "Action: $action<br>";
// echo "Controller file: app/controllers/$controllerName.php<br>";

// Kiểm tra xem controller có tồn tại không
$controllerFile = 'app/controllers/' . $controllerName . '.php';

if (!file_exists($controllerFile)) {
    // Thử tìm với tên khác
    $altControllerName = ucfirst(strtolower($url[0] ?? 'Product')) . 'Controller';
    $altControllerFile = 'app/controllers/' . $altControllerName . '.php';
    
    if (file_exists($altControllerFile)) {
        $controllerName = $altControllerName;
        $controllerFile = $altControllerFile;
    } else {
        // Debug chi tiết
        echo "Controller not found!<br>";
        echo "Looking for: $controllerFile<br>";
        echo "Alternative: $altControllerFile<br>";
        echo "Available controllers:<br>";
        $controllers = glob('app/controllers/*Controller.php');
        foreach($controllers as $ctrl) {
            echo "- " . basename($ctrl) . "<br>";
        }
        die();
    }
}

require_once $controllerFile;

// Kiểm tra class có tồn tại không
if (!class_exists($controllerName)) {
    die("Controller class '$controllerName' not found");
}

$controller = new $controllerName();

// Kiểm tra method có tồn tại không
if (!method_exists($controller, $action)) {
    // Debug chi tiết
    echo "Action '$action' not found in controller '$controllerName'<br>";
    echo "Available methods:<br>";
    $methods = get_class_methods($controller);
    foreach($methods as $method) {
        if (!str_starts_with($method, '__')) { // Loại bỏ magic methods
            echo "- $method<br>";
        }
    }
    die();
}

// Gọi action với các tham số còn lại (nếu có)
call_user_func_array([$controller, $action], array_slice($url, 2));
?>