<?php $base = App\Core\View::baseUrl(); ?>
<section class="py-12">
  <div class="container mx-auto max-w-3xl bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Edit Post</h1>
    <form method="post" action="<?php echo htmlspecialchars($base . '/admin/posts/update'); ?>" enctype="multipart/form-data" class="space-y-4">
      <?php echo App\Core\View::csrfField(); ?>
      <input type="hidden" name="id" value="<?php echo (int)$post['id']; ?>">
      <div>
        <label class="block mb-1">Title</label>
        <input class="w-full border rounded px-3 py-2" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
      </div>
      <div>
        <label class="block mb-1">Slug</label>
        <input class="w-full border rounded px-3 py-2" name="slug" value="<?php echo htmlspecialchars($post['slug']); ?>">
      </div>
      <div>
        <label class="block mb-1">Excerpt</label>
        <textarea class="w-full border rounded px-3 py-2" name="excerpt" rows="3"><?php echo htmlspecialchars($post['excerpt'] ?? ''); ?></textarea>
      </div>
      <div>
        <label class="block mb-1">Content</label>
        <div id="quill-editor" class="bg-white"></div>
        <textarea class="w-full border rounded px-3 py-2" name="content" rows="10" style="display:none"><?php echo htmlspecialchars($post['content']); ?></textarea>
      </div>
      <div>
        <label class="block mb-1">Hero Image</label>
        <?php if (!empty($post['hero_image'])): ?>
          <img class="mb-2 max-h-40 rounded" src="<?php echo htmlspecialchars($base . '/' . ltrim($post['hero_image'], '/')); ?>" alt="hero">
        <?php endif; ?>
        <input type="file" name="hero_image" accept="image/*">
      </div>
      <div>
        <label class="block mb-1">Status</label>
        <select class="w-full border rounded px-3 py-2" name="status">
          <option value="draft" <?php echo ($post['status'] === 'draft') ? 'selected' : ''; ?>>Draft</option>
          <option value="published" <?php echo ($post['status'] === 'published') ? 'selected' : ''; ?>>Published</option>
        </select>
      </div>
      <div class="flex items-center justify-between">
        <a class="text-gray-600 hover:underline" href="<?php echo htmlspecialchars($base . '/admin/posts'); ?>">Back</a>
        <button class="btn" type="submit">Save Changes</button>
      </div>
    </form>
  </div>
</section>

<!-- Quill WYSIWYG -->
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var quill = new Quill('#quill-editor', {
      theme: 'snow',
      modules: {
        toolbar: [
          ['bold', 'italic', 'underline'],
          [{ list: 'ordered' }, { list: 'bullet' }],
          ['link', 'image']
        ]
      }
    });
    var form = document.querySelector('form[action$="/admin/posts/update"]');
    var textarea = form.querySelector('textarea[name="content"]');
    if (textarea && textarea.value) {
      quill.root.innerHTML = textarea.value;
    }
    form.addEventListener('submit', function () {
      textarea.value = quill.root.innerHTML;
    });
  });
</script>
