<?php
$base = rtrim($_ENV['APP_URL'] ?? '', '/');
?>
<div class="nav-container">
    <nav class="navbar">
        <div class="logo"><a href="<?php echo htmlspecialchars($base ?: '/'); ?>"><img src="<?php echo htmlspecialchars($base . '/images/GLP_logo.png'); ?>" alt="logo"></a></div>
        <div class="nav-links">
            <a href="<?php echo htmlspecialchars($base . '/programs'); ?>">Programs</a>
            <a href="<?php echo htmlspecialchars($base . '/about'); ?>">About Us</a>
            <a href="<?php echo htmlspecialchars($base . '/gallery'); ?>">Gallery</a>
            <a href="<?php echo htmlspecialchars($base . '/donate'); ?>">Get Involved</a>
        </div>
        <a class="donate-btn btn" href="<?php echo htmlspecialchars($base . '/donate'); ?>">Donate</a>
        <button class="hamburger" aria-label="Toggle menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </nav>
</div>

<div class="side-drawer" id="sideDrawer">
    <a href="<?php echo htmlspecialchars($base . '/programs'); ?>">Programs</a>
    <a href="<?php echo htmlspecialchars($base . '/about'); ?>">About Us</a>
    <a href="<?php echo htmlspecialchars($base . '/gallery'); ?>">Gallery</a>
    <a href="<?php echo htmlspecialchars($base . '/donate'); ?>">Get Involved</a>
</div>
