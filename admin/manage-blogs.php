<?php
require_once '../db_config.php';
session_start();

// Basic security check - you should implement proper authentication
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

// Handle deletion
if (isset($_POST['delete']) && isset($_POST['id'])) {
    $stmt = $conn->prepare("DELETE FROM blogs WHERE id = ?");
    $stmt->execute([$_POST['id']]);
    header('Location: manage-blogs.php');
    exit();
}

// Fetch all blogs
$stmt = $conn->query("SELECT id, title, category, author_name, created_at FROM blogs ORDER BY created_at DESC");
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Blogs - GCLP Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../style.css">
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Manage Blog Posts</h1>
            <a href="edit-blog.php" class="btn px-4 py-2">Add New Post</a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($blogs as $blog): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($blog['title']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($blog['category']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($blog['author_name']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= date('M d, Y', strtotime($blog['created_at'])) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex space-x-2">
                                    <a href="edit-blog.php?id=<?= $blog['id'] ?>" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                        <input type="hidden" name="id" value="<?= $blog['id'] ?>">
                                        <button type="submit" name="delete" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html> 