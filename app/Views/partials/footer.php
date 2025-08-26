<footer class="bg-gray-800 text-white py-12">
    <?php $base = rtrim($_ENV['APP_URL'] ?? str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/'); ?>
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div>
                <h3 class="text-xl font-semibold mb-4">About Us</h3>
                <p class="text-gray-400">Goldcoast Literacy Program is hoping for an illiteracy free world where we wish for every child learn how to read and having whiles doing.</p>
            </div>
            <div>
                <h3 class="text-xl font-semibold mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="<?php echo htmlspecialchars($base ?: '/'); ?>" class="text-gray-400 hover:text-white transition duration-300">Home</a></li>
                    <li><a href="<?php echo htmlspecialchars($base . '/programs'); ?>" class="text-gray-400 hover:text-white transition duration-300">Our Programs</a></li>
                    <li><a href="<?php echo htmlspecialchars($base . '/donate'); ?>" class="text-gray-400 hover:text-white transition duration-300">Get Involved</a></li>
                    <li><a href="<?php echo htmlspecialchars($base . '/donate'); ?>" class="text-gray-400 hover:text-white transition duration-300">Donate</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-xl font-semibold mb-4">Contact Us</h3>
                <ul class="space-y-2 text-gray-400">
                    <li>Accra, Ghana</li>
                    <li>+233 (27) 360 5996</li>
                    <li>contact@golcoastliteracyprogram.org</li>
                </ul>
            </div>
            <div>
                <h3 class="text-xl font-semibold mb-4">Newsletter</h3>
                <form id="newsletter-form" class="space-y-2">
                    <input type="email" placeholder="Your email" class="w-full px-3 py-2 bg-gray-700 text-white rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <button type="submit" class="w-full hover:bg-blue-600 text-black font-semibold py-2 px-4 rounded transition duration-300 btn">Subscribe</button>
                </form>
            </div>
        </div>
        <hr class="my-8 border-gray-700">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div class="text-gray-400 mb-4 md:mb-0">
                &copy; <?php echo date('Y'); ?> GCLP-NGO | Powered By Dcom Technology Ltd.
            </div>
            <div class="flex space-x-4">
                <a href="<?php echo htmlspecialchars($base . '/#'); ?>" class="text-gray-400 hover:text-white transition duration-300">FB</a>
                <a href="<?php echo htmlspecialchars($base . '/#'); ?>" class="text-gray-400 hover:text-white transition duration-300">TW</a>
                <a href="<?php echo htmlspecialchars($base . '/#'); ?>" class="text-gray-400 hover:text-white transition duration-300">IG</a>
                <a href="<?php echo htmlspecialchars($base . '/#'); ?>" class="text-gray-400 hover:text-white transition duration-300">IN</a>
            </div>
        </div>
    </div>
</footer>
