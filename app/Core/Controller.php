<?php
declare(strict_types=1);

namespace App\Core;

class Controller
{
    protected function view(string $template, array $data = []): void
    {
        echo View::render($template, $data);
    }
}
