<?php
/**
 * Main entry point for the application
 */

// Define base path constant
define('BASE_PATH', dirname(__DIR__));

// Include the autoloader
require_once BASE_PATH . '/vendor/autoload.php';

// Simple router
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$route = trim($uri, '/');

// Default route
if (empty($route)) {
    require BASE_PATH . '/src/views/home.php';
    exit;
}

// Handle download route
if ($route === 'download' || strpos($route, 'download') === 0) {
    $controller = new \App\controllers\Cwe22Controller();
    $filename = isset($_GET['file']) ? $_GET['file'] : null;
    $controller->downloadFile($filename);
    exit;
}

// Handle 404 error
require BASE_PATH . '/src/views/404.php';
?>