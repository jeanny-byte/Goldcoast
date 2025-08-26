<?php
declare(strict_types=1);

// Front controller

// Composer autoload
require __DIR__ . '/vendor/autoload.php';

use App\Core\Router;
use App\Core\View;

// Load environment
$envPath = __DIR__ . DIRECTORY_SEPARATOR;
if (file_exists($envPath . '.env')) {
    Dotenv\Dotenv::createImmutable($envPath)->load();
}

// Start session for auth
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load config
require __DIR__ . '/config/config.php';

// Initialize Router
$router = new Router();

// Load routes
require __DIR__ . '/config/routes.php';

// Dispatch current request
$uriPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$basePath = rtrim($scriptDir, '/');
$relativePath = preg_replace('#^' . preg_quote($basePath, '#') . '#', '', str_replace('\\', '/', $uriPath));
$path = '/' . ltrim($relativePath, '/');
$path = rtrim($path, '/') ?: '/';
$router->dispatch($_SERVER['REQUEST_METHOD'], $path);
