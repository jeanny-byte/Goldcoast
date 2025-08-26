<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Models\User;

class AuthController extends Controller
{
    private function ensureAdmin(): void
    {
        if (User::countAll() === 0) {
            $name = $_ENV['ADMIN_NAME'] ?? 'Administrator';
            $email = $_ENV['ADMIN_EMAIL'] ?? 'admin@example.com';
            $password = $_ENV['ADMIN_PASSWORD'] ?? 'admin123';
            User::createAdmin($name, $email, $password);
        }
    }

    public function loginForm(): void
    {
        $this->ensureAdmin();
        echo View::render('admin/login');
    }

    public function login(): void
    {
        $this->verifyCsrfOrAbort();
        $this->ensureAdmin();
        $email = trim($_POST['email'] ?? '');
        $password = (string)($_POST['password'] ?? '');
        $user = $email ? User::findByEmail($email) : null;
        if (!$user || !password_verify($password, $user['password_hash'])) {
            $_SESSION['flash_error'] = 'Invalid credentials.';
            header('Location: ' . View::baseUrl() . '/admin/login');
            exit;
        }
        $_SESSION['user_id'] = (int)$user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];
        header('Location: ' . View::baseUrl() . '/admin');
        exit;
    }

    public function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
        header('Location: ' . View::baseUrl() . '/admin/login');
        exit;
    }
}
