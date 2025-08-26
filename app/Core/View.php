<?php
declare(strict_types=1);

namespace App\Core;

class View
{
    public static string $basePath = __DIR__ . '/../Views/';

    public static function render(string $template, array $data = []): string
    {
        $layout = self::$basePath . 'layouts/main.php';
        $viewFile = self::$basePath . str_replace('..', '', $template) . '.php';
        if (!file_exists($viewFile)) {
            return 'View not found: ' . htmlspecialchars($template);
        }
        extract($data, EXTR_SKIP);
        ob_start();
        include $viewFile;
        $content = ob_get_clean();

        if (file_exists($layout)) {
            ob_start();
            include $layout;
            return ob_get_clean();
        }
        return $content;
    }

    public static function partial(string $name, array $data = []): void
    {
        $file = self::$basePath . 'partials/' . $name . '.php';
        if (file_exists($file)) {
            extract($data, EXTR_SKIP);
            include $file;
        }
    }

    public static function baseUrl(): string
    {
        $env = $_ENV['APP_URL'] ?? '';
        if ($env) {
            return rtrim($env, '/');
        }
        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
        return rtrim($scriptDir ?: '/', '/');
    }

    public static function csrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return (string)$_SESSION['csrf_token'];
    }

    public static function csrfField(): string
    {
        $token = self::csrfToken();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }
}
