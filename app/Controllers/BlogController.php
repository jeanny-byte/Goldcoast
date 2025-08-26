<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Models\Post;

class BlogController extends Controller
{
    public function index(): void
    {
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $data = Post::paginatePublished($page, 6);
        echo View::render('blog/index', $data);
    }

    public function show(): void
    {
        $slug = (string)($_GET['slug'] ?? '');
        if ($slug === '') {
            http_response_code(404);
            echo View::render('errors/404');
            return;
        }
        $post = Post::findBySlug($slug);
        if (!$post) {
            http_response_code(404);
            echo View::render('errors/404');
            return;
        }
        echo View::render('blog/show', ['post' => $post]);
    }
}
