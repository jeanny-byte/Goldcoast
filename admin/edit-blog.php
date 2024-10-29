<?php
require_once '../db_config.php';
session_start();

// Basic security check - you should implement proper authentication
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

$blog = [
    'id' => '',
    'title' => '',
    'excerpt' => '',
    'content' => '',
    'category' => '',
    'author_name' => '',
    'author_role' => '',
    'author_image' => ''
];

// If editing existing post
if (isset($_GET['id'])) {
    $stmt = $conn->prepare("SELECT * FROM blogs WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $blog = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_GET['id'])) {
            // Update existing post
            $stmt = $conn->prepare("UPDATE blogs SET 
                title = ?, excerpt = ?, content = ?, category = ?,
                author_name = ?, author_role = ?, author_image = ?
                WHERE id = ?");
            $stmt->execute([
                $_POST['title'],
                $_POST['excerpt'],
                $_POST['content'],
                $_POST['category'],
                $_POST['author_name'],
                $_POST['author_role'],
                $_POST['author_image'],
                $_GET['id']
            ]);
        } else {
            // Insert new post
            $stmt = $conn->prepare("INSERT INTO blogs 
                (title, excerpt, content, category, author_name, author_role, author_image)
                VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $_POST['title'],
                $_POST['excerpt'],
                $_POST['content'],
                $_POST['category'],
                $_POST['author_name'],
                $_POST['author_role'],
                $_POST['author_image']
            ]);
        }
        header('Location: manage-blogs.php');
        exit();
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($_GET['id']) ? 'Edit' : 'Add' ?> Blog Post - GCLP Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../style.css">
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold text-gray-800"><?= isset($_GET['id']) ? 'Edit' : 'Add' ?> Blog Post</h1>
                <a href="manage-blogs.php" class="text-gray-600 hover:text-gray-900">Back to Posts</a>
            </div>

            <?php if (isset($error)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="bg-white rounded-lg shadow-md p-6">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" name="title" value="<?= htmlspecialchars($blog['title']) ?>" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Excerpt</label>
                        <textarea name="excerpt" required rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        ><?= htmlspecialchars($blog['excerpt']) ?></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Content</label>
                        <textarea name="content" required rows="10"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        ><?= htmlspecialchars($blog['content']) ?></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Category</label>
                        <input type="text" name="category" value="<?= htmlspecialchars($blog['category']) ?>" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Author Name</label>
                        <input type="text" name="author_name" value="<?= htmlspecialchars($blog['author_name']) ?>" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Author Role</label>
                        <input type="text" name="author_role" value="<?= htmlspecialchars($blog['author_role']) ?>" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Author Image URL</label>
                        <input type="text" name="author_image" value="<?= htmlspecialchars($blog['author_image']) ?>" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="btn px-4 py-2">
                            <?= isset($_GET['id']) ? 'Update' : 'Create' ?> Post
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html> 