<?php
use App\Core\Router;
use App\Controllers\HomeController;

/** @var Router $router */

$router->get('/', [HomeController::class, 'index']);
$router->get('/about', [HomeController::class, 'about']);
$router->get('/programs', [HomeController::class, 'programs']);
$router->get('/gallery', [HomeController::class, 'gallery']);
$router->get('/donate', [HomeController::class, 'donate']);
$router->get('/blog', [HomeController::class, 'blog']);
$router->get('/media', [HomeController::class, 'media']);
