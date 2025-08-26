<?php
declare(strict_types=1);

namespace App\Core;

class Controller
{
    protected function view(string $template, array $data = []): void
    {
        echo View::render($template, $data);
    }

    protected function verifyCsrfOrAbort(): void
    {
        $token = (string)($_POST['csrf_token'] ?? '');
        $sessionToken = View::csrfToken();
        if (!$token || !hash_equals($sessionToken, $token)) {
            http_response_code(419);
            echo 'CSRF token mismatch.';
            exit;
        }
    }
}
