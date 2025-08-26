<?php
declare(strict_types=1);

namespace App\Models;

use App\Config\Config;
use PDO;

class Post
{
    public static function paginatePublished(int $page = 1, int $perPage = 6): array
    {
        $page = max(1, $page);
        $perPage = max(1, min(50, $perPage));
        $offset = ($page - 1) * $perPage;
        $pdo = Config::db();
        $total = (int)$pdo->query("SELECT COUNT(*) FROM posts WHERE status = 'published'")->fetchColumn();
        $stmt = $pdo->prepare("SELECT id, title, slug, excerpt, hero_image, published_at FROM posts WHERE status = 'published' ORDER BY published_at DESC, id DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        return [
            'items' => $items,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'pages' => (int)ceil($total / $perPage),
        ];
    }

    public static function findBySlug(string $slug): ?array
    {
        $pdo = Config::db();
        $stmt = $pdo->prepare("SELECT * FROM posts WHERE slug = :slug AND status = 'published' LIMIT 1");
        $stmt->execute([':slug' => $slug]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function paginateAll(int $page = 1, int $perPage = 10): array
    {
        $page = max(1, $page);
        $perPage = max(1, min(100, $perPage));
        $offset = ($page - 1) * $perPage;
        $pdo = Config::db();
        $total = (int)$pdo->query("SELECT COUNT(*) FROM posts")->fetchColumn();
        $stmt = $pdo->prepare("SELECT id, title, slug, status, published_at, created_at FROM posts ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        return [
            'items' => $items,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'pages' => (int)ceil($total / $perPage),
        ];
    }

    public static function find(int $id): ?array
    {
        $pdo = Config::db();
        $stmt = $pdo->prepare('SELECT * FROM posts WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function slugify(string $title): string
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title), '-'));
        $slug = preg_replace('/-+/', '-', $slug);
        return $slug ?: uniqid('post-');
    }

    public static function ensureUniqueSlug(string $baseSlug, ?int $ignoreId = null): string
    {
        $pdo = Config::db();
        $slug = $baseSlug;
        $i = 1;
        while (true) {
            if ($ignoreId) {
                $stmt = $pdo->prepare('SELECT id FROM posts WHERE slug = ? AND id <> ? LIMIT 1');
                $stmt->execute([$slug, $ignoreId]);
            } else {
                $stmt = $pdo->prepare('SELECT id FROM posts WHERE slug = ? LIMIT 1');
                $stmt->execute([$slug]);
            }
            if (!$stmt->fetch(PDO::FETCH_ASSOC)) {
                return $slug;
            }
            $slug = $baseSlug . '-' . (++$i);
        }
    }

    public static function create(array $data): int
    {
        $pdo = Config::db();
        $title = trim($data['title'] ?? '');
        $slug = self::ensureUniqueSlug(self::slugify($data['slug'] ?? $title));
        $excerpt = $data['excerpt'] ?? null;
        $content = $data['content'] ?? '';
        $hero = $data['hero_image'] ?? null;
        $status = in_array(($data['status'] ?? 'draft'), ['draft','published'], true) ? $data['status'] : 'draft';
        $publishedAt = ($status === 'published') ? (date('Y-m-d H:i:s')) : null;
        $authorId = (int)($data['author_id'] ?? 1);
        $stmt = $pdo->prepare('INSERT INTO posts (title, slug, excerpt, content, hero_image, status, published_at, author_id) VALUES (?,?,?,?,?,?,?,?)');
        $stmt->execute([$title, $slug, $excerpt, $content, $hero, $status, $publishedAt, $authorId]);
        return (int)$pdo->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        $pdo = Config::db();
        $existing = self::find($id);
        if (!$existing) return;
        $title = trim($data['title'] ?? $existing['title']);
        $baseSlug = self::slugify($data['slug'] ?? $existing['slug'] ?? $title);
        $slug = self::ensureUniqueSlug($baseSlug, $id);
        $excerpt = $data['excerpt'] ?? $existing['excerpt'];
        $content = $data['content'] ?? $existing['content'];
        $hero = $data['hero_image'] ?? $existing['hero_image'];
        $status = in_array(($data['status'] ?? $existing['status']), ['draft','published'], true) ? ($data['status'] ?? $existing['status']) : $existing['status'];
        $publishedAt = ($status === 'published') ? ($existing['published_at'] ?: date('Y-m-d H:i:s')) : null;
        $stmt = $pdo->prepare('UPDATE posts SET title=?, slug=?, excerpt=?, content=?, hero_image=?, status=?, published_at=? WHERE id=?');
        $stmt->execute([$title, $slug, $excerpt, $content, $hero, $status, $publishedAt, $id]);
    }

    public static function delete(int $id): void
    {
        $pdo = Config::db();
        $stmt = $pdo->prepare('DELETE FROM posts WHERE id = ?');
        $stmt->execute([$id]);
    }
}
