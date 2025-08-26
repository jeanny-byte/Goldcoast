<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Models\Post;

class AdminPostsController extends Controller
{
    private function requireAuth(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . View::baseUrl() . '/admin/login');
            exit;
        }
    }

    public function index(): void
    {
        $this->requireAuth();
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $data = Post::paginateAll($page, 10);
        echo View::render('admin/posts/index', $data);
    }

    public function createForm(): void
    {
        $this->requireAuth();
        echo View::render('admin/posts/create');
    }

    public function store(): void
    {
        $this->requireAuth();
        $this->verifyCsrfOrAbort();
        $title = trim($_POST['title'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $excerpt = trim($_POST['excerpt'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $status = $_POST['status'] ?? 'draft';

        $heroPath = null;
        if (!empty($_FILES['hero_image']['name']) && is_uploaded_file($_FILES['hero_image']['tmp_name'])) {
            $heroPath = $this->saveUpload($_FILES['hero_image']);
        }

        $id = Post::create([
            'title' => $title,
            'slug' => $slug ?: $title,
            'excerpt' => $excerpt,
            'content' => $content,
            'hero_image' => $heroPath,
            'status' => $status,
            'author_id' => (int)($_SESSION['user_id'] ?? 1),
        ]);
        header('Location: ' . View::baseUrl() . '/admin/posts/edit?id=' . $id);
        exit;
    }

    public function editForm(): void
    {
        $this->requireAuth();
        $id = (int)($_GET['id'] ?? 0);
        $post = $id ? Post::find($id) : null;
        if (!$post) {
            http_response_code(404);
            echo View::render('errors/404');
            return;
        }
        echo View::render('admin/posts/edit', ['post' => $post]);
    }

    public function update(): void
    {
        $this->requireAuth();
        $this->verifyCsrfOrAbort();
        $id = (int)($_POST['id'] ?? 0);
        $post = $id ? Post::find($id) : null;
        if (!$post) {
            http_response_code(404);
            echo View::render('errors/404');
            return;
        }
        $data = [
            'title' => trim($_POST['title'] ?? $post['title']),
            'slug' => trim($_POST['slug'] ?? $post['slug']),
            'excerpt' => trim($_POST['excerpt'] ?? $post['excerpt']),
            'content' => trim($_POST['content'] ?? $post['content']),
            'status' => $_POST['status'] ?? $post['status'],
            'hero_image' => $post['hero_image'],
        ];
        if (!empty($_FILES['hero_image']['name']) && is_uploaded_file($_FILES['hero_image']['tmp_name'])) {
            $data['hero_image'] = $this->saveUpload($_FILES['hero_image']);
        }
        Post::update($id, $data);
        header('Location: ' . View::baseUrl() . '/admin/posts');
        exit;
    }

    public function delete(): void
    {
        $this->requireAuth();
        $this->verifyCsrfOrAbort();
        $id = (int)($_POST['id'] ?? 0);
        if ($id) {
            Post::delete($id);
        }
        header('Location: ' . View::baseUrl() . '/admin/posts');
        exit;
    }

    private function saveUpload(array $file): string
    {
        $uploadDir = __DIR__ . '/../../images/uploads';
        if (!is_dir($uploadDir)) {
            @mkdir($uploadDir, 0777, true);
        }
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $safeName = preg_replace('/[^a-zA-Z0-9-_\.]/', '_', pathinfo($file['name'], PATHINFO_FILENAME));
        $filename = $safeName . '-' . time() . ($ext ? ('.' . $ext) : '');
        $destPath = $uploadDir . '/' . $filename;
        if (!move_uploaded_file($file['tmp_name'], $destPath)) {
            return '';
        }
        // Return web path relative to project root
        return 'images/uploads/' . $filename;
    }
}

