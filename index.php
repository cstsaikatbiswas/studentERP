<?php
// Start session
session_start();

// Define base path
define('BASE_PATH', __DIR__);

// Autoload classes
spl_autoload_register(function ($class) {
    $paths = [
        BASE_PATH . '/controller/',
        BASE_PATH . '/model/',
        BASE_PATH . '/config/'
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Get the requested URL
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'home';

// Route the request
switch ($url) {
    case 'home':
        $controller = new HomeController();
        $controller->index();
        break;
    case 'login':
        $controller = new AuthController();
        $controller->login();
        break;
    case 'forgot-password':
        $controller = new AuthController();
        $controller->forgotPassword();
        break;
    case 'register':
        $controller = new AuthController();
        $controller->register();
        break;
    case 'dashboard':
        $controller = new DashboardController();
        $controller->index();
        break;
    case 'profile':
        $controller = new AuthController();
        $controller->profile();
        break;
    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;
    default:
        http_response_code(404);
        include BASE_PATH . '/view/404.php';
        break;
}