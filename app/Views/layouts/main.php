<?php
// Main layout
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goldcoast Learning Authority</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/Goldcoast/Goldcoast/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Paytone+One&family=Barlow:wght@400;700&family=Baloo+Thambi+2:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php App\Core\View::partial('nav'); ?>
    <?php echo $content; ?>
    <?php App\Core\View::partial('footer'); ?>
    <button id="back-to-top" class="fixed bottom-4 right-4 bg-blue-500 text-white p-2 rounded-full shadow-lg opacity-0 transition-opacity duration-300">
        <i class="fas fa-arrow-up"></i>
    </button>
    <script src="/Goldcoast/Goldcoast/script.js"></script>
</body>
</html>
