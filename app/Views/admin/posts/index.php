<?php $base = App\Core\View::baseUrl(); ?>
<section class="py-12">
  <div class="container mx-auto">
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold">Posts</h1>
      <a class="btn" href="<?php echo htmlspecialchars($base . '/admin/posts/create'); ?>">New Post</a>
    </div>

    <?php if (!empty($items)): ?>
      <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full">
          <thead class="bg-gray-100">
            <tr>
              <th class="text-left p-3">Title</th>
              <th class="text-left p-3">Slug</th>
              <th class="text-left p-3">Status</th>
              <th class="text-left p-3">Published</th>
              <th class="p-3">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($items as $row): ?>
              <tr class="border-t">
                <td class="p-3"><?php echo htmlspecialchars($row['title']); ?></td>
                <td class="p-3 text-gray-600"><?php echo htmlspecialchars($row['slug']); ?></td>
                <td class="p-3"><?php echo htmlspecialchars($row['status']); ?></td>
                <td class="p-3"><?php echo htmlspecialchars($row['published_at'] ?? '-'); ?></td>
                <td class="p-3 text-right space-x-2">
                  <a class="text-blue-600 hover:underline" href="<?php echo htmlspecialchars($base . '/admin/posts/edit?id=' . (int)$row['id']); ?>">Edit</a>
                  <form method="post" action="<?php echo htmlspecialchars($base . '/admin/posts/delete'); ?>" class="inline" onsubmit="return confirm('Delete this post?');">
                    <?php echo App\Core\View::csrfField(); ?>
                    <input type="hidden" name="id" value="<?php echo (int)$row['id']; ?>">
                    <button class="text-red-600 hover:underline" type="submit">Delete</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <?php if (($pages ?? 1) > 1): ?>
        <div class="mt-6 flex items-center justify-center space-x-2">
          <?php for ($p = 1; $p <= $pages; $p++): $active = ($p === ($page ?? 1)); ?>
            <a href="<?php echo htmlspecialchars($base . '/admin/posts?page=' . $p); ?>" class="px-3 py-1 rounded <?php echo $active ? 'bg-blue-600 text-white' : 'bg-gray-200'; ?>"><?php echo $p; ?></a>
          <?php endfor; ?>
        </div>
      <?php endif; ?>
    <?php else: ?>
      <p>No posts yet. Create your first one.</p>
    <?php endif; ?>
  </div>
</section>
