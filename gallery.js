// Gallery timeline images data
const timelineEvents = [
    {
        title: "Community Reading Session",
        description: "Young students engaged in our reading program, developing crucial literacy skills.",
        image: "gallery/1.jpg"
    },
    {
        title: "Teacher Training Workshop",
        description: "Professional development session for our dedicated literacy educators.",
        image: "gallery/2.jpg"
    },
    {
        title: "Book Distribution Event",
        description: "Distributing reading materials to local schools and communities.",
        image: "gallery/3.jpg"
    }
];

// Function to populate the timeline
function populateTimeline() {
    const timeline = document.querySelector('.timeline');
    if (!timeline) return; // Guard clause in case timeline element doesn't exist
    
    timeline.innerHTML = ''; // Clear existing content

    timelineEvents.forEach((event, index) => {
        const position = index % 2 === 0 ? 'left' : 'right';
        
        const timelineItem = document.createElement('div');
        timelineItem.className = 'timeline-item';
        
        timelineItem.innerHTML = `
            <div class="timeline-content ${position}">
                <h3 class="text-xl font-bold mb-2">${event.title}</h3>
                <div class="mb-3">
                    <img src="${event.image}" alt="${event.title}" 
                         class="w-full h-48 object-cover rounded-lg shadow-md">
                </div>
                <p class="text-gray-700">${event.description}</p>
            </div>
        `;
        
        timeline.appendChild(timelineItem);
    });
}

// Initialize timeline when DOM is loaded
document.addEventListener('DOMContentLoaded', populateTimeline);
