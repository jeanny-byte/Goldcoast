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
