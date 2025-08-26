<?php $base = App\Core\View::baseUrl(); ?>
<div class="container mx-auto p-4 mt-20">
    <h1 class="text-3xl font-bold mb-6">Blog</h1>

    <?php if (!empty($items)): ?>
        <div class="grid md:grid-cols-2 gap-6">
            <?php foreach ($items as $post): ?>
                <article class="bg-white rounded shadow p-4">
                    <?php if (!empty($post['hero_image'])): ?>
                        <img class="mb-3 w-full h-48 object-cover rounded" src="<?php echo htmlspecialchars($base . '/' . ltrim($post['hero_image'], '/')); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
                    <?php endif; ?>
                    <h2 class="text-xl font-semibold mb-2">
                        <a href="<?php echo htmlspecialchars($base . '/blog/show?slug=' . urlencode($post['slug'])); ?>" class="hover:underline">
                            <?php echo htmlspecialchars($post['title']); ?>
                        </a>
                    </h2>
                    <?php if (!empty($post['published_at'])): ?>
                        <div class="text-gray-500 text-sm mb-2"><?php echo htmlspecialchars(date('M j, Y', strtotime($post['published_at']))); ?></div>
                    <?php endif; ?>
                    <p class="text-gray-700"><?php echo htmlspecialchars($post['excerpt'] ?? ''); ?></p>
                    <div class="mt-3">
                        <a class="btn" href="<?php echo htmlspecialchars($base . '/blog/show?slug=' . urlencode($post['slug'])); ?>">Read more</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <?php if (($pages ?? 1) > 1): ?>
            <div class="mt-8 flex items-center justify-center space-x-2">
                <?php for ($p = 1; $p <= $pages; $p++): ?>
                    <?php $active = ($p === ($page ?? 1)); ?>
                    <a href="<?php echo htmlspecialchars($base . '/blog?page=' . $p); ?>"
                       class="px-3 py-1 rounded <?php echo $active ? 'bg-blue-600 text-white' : 'bg-gray-200'; ?>">
                        <?php echo $p; ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <p>No posts yet.</p>
    <?php endif; ?>
</div>
