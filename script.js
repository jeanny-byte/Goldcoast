const hamburger = document.querySelector('.hamburger');
const sideDrawer = document.getElementById('sideDrawer');
let isOpen = false;

hamburger.addEventListener('click', () => {
    isOpen = !isOpen;
    if (isOpen) {
        sideDrawer.classList.add('open');
        hamburger.setAttribute('aria-expanded', 'true');
        hamburger.children[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
        hamburger.children[1].style.opacity = '0';
        hamburger.children[2].style.transform = 'rotate(-45deg) translate(5px, -5px)';
    } else {
        sideDrawer.classList.remove('open');
        hamburger.setAttribute('aria-expanded', 'false');
        hamburger.children[0].style.transform = 'none';
        hamburger.children[1].style.opacity = '1';
        hamburger.children[2].style.transform = 'none';
    }
});

// Close the side drawer when clicking outside of it
document.addEventListener('click', (event) => {
    if (isOpen && !sideDrawer.contains(event.target) && !hamburger.contains(event.target)) {
        sideDrawer.classList.remove('open');
        isOpen = false;
        hamburger.setAttribute('aria-expanded', 'false');
        hamburger.children[0].style.transform = 'none';
        hamburger.children[1].style.opacity = '1';
        hamburger.children[2].style.transform = 'none';
    }
});
document.addEventListener('DOMContentLoaded', (event) => {
    const hero = document.getElementById('hero');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                hero.classList.add('opacity-100');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    observer.observe(hero);
});

//Tailwing config initialization
tailwind.config = {
    theme: {
        extend: {
            colors: {
                'navy-blue': '#000080',
            },
            fontFamily: {
                'paytone': ['"Paytone One"', 'sans-serif'],
                'barlow': ['Barlow', 'sans-serif'],
                'baloo': ['"Baloo Thambi 2"', 'cursive'],
            },
        }
    }
}

//Achievments section animation

const counterSection = document.getElementById('counter-section');
const counters = document.querySelectorAll('[data-target]');
let animated = false;

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting && !animated) {
            counterSection.classList.remove('opacity-0');
            animateCounters();
            animated = true;
            observer.unobserve(counterSection); // Stop observing after animation
        }
    });
}, { threshold: 0.5 });

observer.observe(counterSection);

function animateCounters() {
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        const duration = 2000; // 2 seconds
        const step = target / (duration / 16); // 60 FPS
        let current = 0;

        function updateCounter() {
            if (current < target) {
                current = Math.ceil(Math.min(current + step, target));
                counter.innerText = current.toLocaleString();
                requestAnimationFrame(updateCounter);
            }
        }

        updateCounter();
    });
}
 // Newsletter form submission
 document.getElementById('newsletter-form').addEventListener('submit', function(e) {
    e.preventDefault();
    alert("Thank you for subscribing to our newsletter! We'll get in touch");
    this.reset();
});

// Back to top button
const backToTopButton = document.getElementById('back-to-top');

window.addEventListener('scroll', () => {
    if (window.pageYOffset > 100) {
        backToTopButton.classList.add('opacity-100');
    } else {
        backToTopButton.classList.remove('opacity-100');
    }
});

backToTopButton.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

// Gallery page functionality
document.addEventListener('DOMContentLoaded', () => {
    let page = 1;
    let loading = false;
    let currentView = 'bento';
    
    const bentoGrid = document.getElementById('bento-grid');
    const slideshowContainer = document.getElementById('slideshow-container');
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    
    // View Toggle
    document.getElementById('bentoView').addEventListener('click', () => switchView('bento'));
    document.getElementById('slideshowView').addEventListener('click', () => switchView('slideshow'));
    
    async function loadImages(page) {
        if (loading) return;
        loading = true;
        
        document.getElementById('loading').classList.remove('hidden');
        
        try {
            const response = await fetch(`/api/gallery?page=${page}`);
            const data = await response.json();
            
            renderImages(data.images);
            
            if (data.images.length > 0) {
                page++;
            }
        } catch (error) {
            console.error('Error loading images:', error);
        } finally {
            loading = false;
            document.getElementById('loading').classList.add('hidden');
        }
    }
    
    function renderImages(images) {
        images.forEach(image => {
            const item = document.createElement('div');
            item.className = `gallery-item ${getRandomSpan()}`;
            
            item.innerHTML = `
                <img src="${image.url}" 
                     alt="${image.description}"
                     class="w-full h-full object-cover rounded-lg cursor-pointer"
                     loading="lazy">
            `;
            
            item.querySelector('img').addEventListener('click', () => showModal(image.url));
            bentoGrid.appendChild(item);
        });
    }
    
    function getRandomSpan() {
        const spans = [
            'row-span-1 col-span-1',
            'row-span-2 col-span-1',
            'row-span-1 col-span-2',
            'row-span-2 col-span-2'
        ];
        return spans[Math.floor(Math.random() * spans.length)];
    }
    
    function showModal(imageUrl) {
        modal.classList.remove('hidden');
        modalImage.src = imageUrl;
    }
    
    // Infinite Scroll
    window.addEventListener('scroll', () => {
        if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 1000) {
            loadImages(page);
        }
    });
    
    // Initial load
    loadImages(page);
});
