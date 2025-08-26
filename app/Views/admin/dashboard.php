<?php $base = App\Core\View::baseUrl(); ?>
<section class="py-12">
  <div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-4">Welcome, <?php echo htmlspecialchars($userName ?? 'Admin'); ?></h1>
    <div class="space-x-4 mb-6">
      <a class="btn" href="<?php echo htmlspecialchars($base . '/admin/logout'); ?>">Logout</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <a class="block p-6 bg-white rounded shadow" href="<?php echo htmlspecialchars($base . '/admin/posts'); ?>">Manage Blog</a>
      <a class="block p-6 bg-white rounded shadow" href="<?php echo htmlspecialchars($base . '/gallery'); ?>">Manage Gallery</a>
      <a class="block p-6 bg-white rounded shadow" href="<?php echo htmlspecialchars($base . '/donate'); ?>">Donations</a>
    </div>
  </div>
</section>
