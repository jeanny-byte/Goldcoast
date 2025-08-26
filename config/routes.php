<?php
use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\BlogController;
use App\Controllers\AuthController;
use App\Controllers\AdminController;
use App\Controllers\AdminPostsController;

/** @var Router $router */

$router->get('/', [HomeController::class, 'index']);
$router->get('/about', [HomeController::class, 'about']);
$router->get('/programs', [HomeController::class, 'programs']);
$router->get('/gallery', [HomeController::class, 'gallery']);
$router->get('/donate', [HomeController::class, 'donate']);
$router->get('/blog', [BlogController::class, 'index']);
$router->get('/blog/show', [BlogController::class, 'show']);
$router->get('/media', [HomeController::class, 'media']);

// Admin auth
$router->get('/admin/login', [AuthController::class, 'loginForm']);
$router->post('/admin/login', [AuthController::class, 'login']);
$router->get('/admin/logout', [AuthController::class, 'logout']);

// Admin dashboard (protected in controller)
$router->get('/admin', [AdminController::class, 'dashboard']);

// Admin posts CRUD
$router->get('/admin/posts', [AdminPostsController::class, 'index']);
$router->get('/admin/posts/create', [AdminPostsController::class, 'createForm']);
$router->post('/admin/posts', [AdminPostsController::class, 'store']);
$router->get('/admin/posts/edit', [AdminPostsController::class, 'editForm']);
$router->post('/admin/posts/update', [AdminPostsController::class, 'update']);
$router->post('/admin/posts/delete', [AdminPostsController::class, 'delete']);
