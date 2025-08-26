<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;

class AdminController extends Controller
{
    private function requireAuth(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . View::baseUrl() . '/admin/login');
            exit;
        }
    }

    public function dashboard(): void
    {
        $this->requireAuth();
        echo View::render('admin/dashboard', [
            'userName' => $_SESSION['user_name'] ?? 'Admin',
        ]);
    }
}
