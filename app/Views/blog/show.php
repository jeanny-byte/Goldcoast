<?php $base = App\Core\View::baseUrl(); ?>
<div class="container mx-auto p-4 mt-20 max-w-3xl">
    <a class="text-blue-600 hover:underline" href="<?php echo htmlspecialchars($base . '/blog'); ?>">← Back to Blog</a>
    <h1 class="text-4xl font-bold my-4"><?php echo htmlspecialchars($post['title']); ?></h1>
    <?php if (!empty($post['published_at'])): ?>
        <div class="text-gray-500 text-sm mb-6"><?php echo htmlspecialchars(date('M j, Y', strtotime($post['published_at']))); ?></div>
    <?php endif; ?>
    <?php if (!empty($post['hero_image'])): ?>
        <img class="mb-6 w-full rounded" src="<?php echo htmlspecialchars($base . '/' . ltrim($post['hero_image'], '/')); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
    <?php endif; ?>
    <div class="prose max-w-none">
        <?php echo nl2br(htmlspecialchars($post['content'])); ?>
    </div>
</div>
