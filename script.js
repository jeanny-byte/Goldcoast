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

async function loadOutreachPrograms() {
    try {
        const response = await fetch('/api/outreach-programs');
        const programs = await response.json();
        
        const programsContainer = document.getElementById('programs-container');
        if (!programsContainer) return;

        programsContainer.innerHTML = programs.map(program => `
            <div class="program-card p-6">
                <h3 class="font-barlow font-bold text-xl mb-4">${program.name}</h3>
                <div class="mb-4">
                    <img src="${program.imageUrl}" alt="${program.name}" 
                         class="w-full h-48 object-cover rounded-lg mb-4">
                </div>
                <ul class="space-y-2 text-gray-600">
                    <li>📍 Location: ${program.location}</li>
                    <li>👥 Students Reached: ${program.studentsReached}+</li>
                    <li>📅 Last Visit: ${new Date(program.lastVisit).toLocaleDateString()}</li>
                    ${program.nextVisit ? `<li>🗓️ Next Visit: ${new Date(program.nextVisit).toLocaleDateString()}</li>` : ''}
                </ul>
                <a href="#" class="btn mt-4 inline-block">View Details</a>
            </div>
        `).join('');

        // Update statistics
        const totalSchools = document.getElementById('total-schools');
        if (totalSchools) {
            totalSchools.textContent = programs.length;
        }

        const totalStudents = document.getElementById('total-students');
        if (totalStudents) {
            const total = programs.reduce((sum, program) => sum + program.studentsReached, 0);
            totalStudents.textContent = total.toLocaleString();
        }

    } catch (error) {
        console.error('Error loading outreach programs:', error);
    }
}

// Call this function when the page loads
document.addEventListener('DOMContentLoaded', loadOutreachPrograms);

// Gallery Management
const GALLERY_STORAGE_KEY = 'galleryImages';

function getGalleryImages() {
    const stored = localStorage.getItem(GALLERY_STORAGE_KEY);
    return stored ? JSON.parse(stored) : [];
}

function saveGalleryImages(images) {
    localStorage.setItem(GALLERY_STORAGE_KEY, JSON.stringify(images));
}

function addGalleryImage(imageData) {
    const images = getGalleryImages();
    const newImage = {
        id: Date.now().toString(),
        ...imageData,
        dateAdded: new Date().toISOString(),
        active: true
    };
    images.push(newImage);
    saveGalleryImages(images);
    return newImage;
}

function deleteGalleryImage(imageId) {
    const images = getGalleryImages();
    const updatedImages = images.filter(img => img.id !== imageId);
    saveGalleryImages(updatedImages);
}

// FAQ Accordion functionality
document.addEventListener('DOMContentLoaded', function() {
    const faqButtons = document.querySelectorAll('.faq-button');
    
    faqButtons.forEach(button => {
        button.addEventListener('click', () => {
            const faqItem = button.parentElement;
            const answer = button.nextElementSibling;
            const icon = button.querySelector('svg');
            
            // Close all other answers
            document.querySelectorAll('.faq-answer').forEach(item => {
                if (item !== answer) {
                    item.classList.add('hidden');
                    item.previousElementSibling.querySelector('svg').classList.remove('rotate-180');
                }
            });
            
            // Check if current answer is already visible
            const isVisible = !answer.classList.contains('hidden');
            
            if (isVisible) {
                // If visible, hide it
                answer.classList.add('hidden');
                icon.classList.remove('rotate-180');
            } else {
                // If hidden, show it
                answer.classList.remove('hidden');
                icon.classList.add('rotate-180');
            }
            
            // Optional: Smooth scroll to the opened item
            if (!answer.classList.contains('hidden')) {
                faqItem.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        });
    });
});