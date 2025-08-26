<div class="container mx-auto p-4 mt-20">
    <h1 class="text-4xl font-bold mb-4">Gallery</h1>
    <div class="timeline">
        <div class="timeline-item">
            <div class="timeline-content left">
                <h3>Event 1</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
        </div>
        <div class="timeline-item">
            <div class="timeline-content right">
                <h3>Event 2</h3>
                <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>
        </div>
        <div class="timeline-item">
            <div class="timeline-content left">
                <h3>Event 3</h3>
                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
            </div>
        </div>
    </div>
</div>
<style>
.timeline { position: relative; padding: 10px 0; }
.timeline-item { position: relative; margin: 20px 0; }
.timeline-item::before { content: ''; position: absolute; left: 50%; top: 0; height: 100%; width: 2px; background: #ccc; transform: translateX(-50%); }
.timeline-content { position: relative; width: 45%; padding: 10px; background: #f9f9f9; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); }
.timeline-content.left { left: 0; }
.timeline-content.right { left: 55%; }
</style>
