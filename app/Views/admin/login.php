<?php $base = App\Core\View::baseUrl(); ?>
<section class="py-12">
  <div class="container mx-auto max-w-md bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Admin Login</h1>
    <?php if (!empty($_SESSION['flash_error'])): ?>
      <div class="mb-4 p-3 bg-red-100 text-red-700 rounded"><?php echo htmlspecialchars($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?></div>
    <?php endif; ?>
    <form method="post" action="<?php echo htmlspecialchars($base . '/admin/login'); ?>" class="space-y-4">
      <?php echo App\Core\View::csrfField(); ?>
      <div>
        <label class="block mb-1">Email</label>
        <input type="email" name="email" required class="w-full border rounded px-3 py-2" />
      </div>
      <div>
        <label class="block mb-1">Password</label>
        <input type="password" name="password" required class="w-full border rounded px-3 py-2" />
      </div>
      <button type="submit" class="btn w-full">Sign in</button>
    </form>
    <p class="text-gray-500 text-sm mt-4">First run creates admin using .env: ADMIN_EMAIL/ADMIN_PASSWORD.</p>
  </div>
</section>
