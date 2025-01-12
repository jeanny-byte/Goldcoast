let currentProgramId = null;

// Event Listeners
document.getElementById('addNewBtn').addEventListener('click', () => showModal());
document.getElementById('cancelBtn').addEventListener('click', hideModal);
document.getElementById('programForm').addEventListener('submit', handleFormSubmit);
document.getElementById('searchInput').addEventListener('input', filterPrograms);
document.getElementById('filterType').addEventListener('change', filterPrograms);

// Tab Switching
document.getElementById('outreachTabBtn').addEventListener('click', () => {
    document.getElementById('outreachSection').classList.remove('hidden');
    document.getElementById('volunteersSection').classList.add('hidden');
});

document.getElementById('volunteersTabBtn').addEventListener('click', () => {
    console.log('Volunteers tab clicked');
    hideAllSections();
    const volunteersSection = document.getElementById('volunteersSection');
    if (volunteersSection) {
        volunteersSection.classList.remove('hidden');
        loadVolunteers();
    } else {
        console.error('Volunteers section not found');
    }
});

document.getElementById('galleryTabBtn').addEventListener('click', () => {
    hideAllSections();
    document.getElementById('gallerySection').classList.remove('hidden');
    loadGalleryImages();
});

async function loadPrograms() {
    try {
        const response = await fetch('/api/outreach-programs');
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const programs = await response.json();
        
        updateStats(programs);
        renderProgramsTable(programs);
    } catch (error) {
        console.error('Error loading programs:', error);
        alert('Error loading programs');
    }
}

function updateStats(programs) {
    document.getElementById('totalPrograms').textContent = programs.length;
    const totalStudents = programs.reduce((sum, p) => sum + p.studentsReached, 0);
    document.getElementById('totalStudents').textContent = totalStudents.toLocaleString();
    const upcomingVisits = programs.filter(p => p.nextVisit && new Date(p.nextVisit) > new Date()).length;
    document.getElementById('upcomingVisits').textContent = upcomingVisits;
}

function renderProgramsTable(programs) {
    const tbody = document.getElementById('programsTableBody');
    tbody.innerHTML = programs.map(program => `
        <tr class="hover:bg-gray-50">
            <td class="px-6 py-4">${program.name}</td>
            <td class="px-6 py-4">${program.location}</td>
            <td class="px-6 py-4">${program.studentsReached}</td>
            <td class="px-6 py-4">${new Date(program.lastVisit).toLocaleDateString()}</td>
            <td class="px-6 py-4">${program.nextVisit ? new Date(program.nextVisit).toLocaleDateString() : '-'}</td>
            <td class="px-6 py-4">
                <button onclick="editProgram('${program._id}')" class="text-blue-600 hover:text-blue-800 mr-3">Edit</button>
                <button onclick="deleteProgram('${program._id}')" class="text-red-600 hover:text-red-800">Delete</button>
            </td>
        </tr>
    `).join('');
}

async function handleFormSubmit(e) {
    e.preventDefault();
    const formData = new FormData(e.target);
    const programData = Object.fromEntries(formData.entries());

    try {
        const url = currentProgramId 
            ? `/api/outreach-programs/${currentProgramId}`
            : '/api/outreach-programs';
        
        const response = await fetch(url, {
            method: currentProgramId ? 'PUT' : 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(programData)
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const result = await response.json();
        hideModal();
        loadPrograms();
    } catch (error) {
        console.error('Error saving program:', error);
        alert('Error saving program');
    }
}

async function editProgram(id) {
    try {
        const response = await fetch(`/api/outreach-programs/${id}`);
        const program = await response.json();
        
        currentProgramId = id;
        const form = document.getElementById('programForm');
        Object.entries(program).forEach(([key, value]) => {
            const input = form.elements[key];
            if (input) {
                if (key === 'lastVisit' || key === 'nextVisit') {
                    input.value = value ? new Date(value).toISOString().split('T')[0] : '';
                } else {
                    input.value = value;
                }
            }
        });
        
        document.getElementById('modalTitle').textContent = 'Edit Program';
        showModal();
    } catch (error) {
        console.error('Error loading program:', error);
        alert('Error loading program details');
    }
}

async function deleteProgram(id) {
    if (!confirm('Are you sure you want to delete this program?')) return;
    
    try {
        const response = await fetch(`/api/outreach-programs/${id}`, {
            method: 'DELETE'
        });
        
        if (!response.ok) throw new Error('Failed to delete program');
        
        loadPrograms();
    } catch (error) {
        console.error('Error deleting program:', error);
        alert('Error deleting program');
    }
}

function filterPrograms() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const filterType = document.getElementById('filterType').value;
    
    const rows = document.querySelectorAll('#programsTableBody tr');
    rows.forEach(row => {
        const name = row.cells[0].textContent.toLowerCase();
        const type = row.dataset.type;
        const matchesSearch = name.includes(searchTerm);
        const matchesFilter = !filterType || type === filterType;
        row.style.display = matchesSearch && matchesFilter ? '' : 'none';
    });
}

function showModal() {
    document.getElementById('programModal').style.display = 'flex';
}

function hideModal() {
    document.getElementById('programModal').style.display = 'none';
    document.getElementById('programForm').reset();
    currentProgramId = null;
    document.getElementById('modalTitle').textContent = 'Add New Program';
}

// Volunteer Management
async function loadVolunteers() {
    try {
        const response = await fetch('/api/volunteers');
        if (!response.ok) throw new Error('Failed to fetch volunteers');
        const volunteers = await response.json();
        
        updateVolunteerStats(volunteers);
        renderVolunteersTable(volunteers);
    } catch (error) {
        console.error('Error loading volunteers:', error);
        alert('Error loading volunteers');
    }
}

function updateVolunteerStats(volunteers) {
    const activeCount = volunteers.filter(v => v.status === 'active').length;
    const pendingCount = volunteers.filter(v => v.status === 'pending').length;
    
    document.getElementById('activeVolunteers').textContent = activeCount;
    document.getElementById('pendingVolunteers').textContent = pendingCount;
}

function renderVolunteersTable(volunteers) {
    const tbody = document.getElementById('volunteersTableBody');
    tbody.innerHTML = volunteers.map(volunteer => `
        <tr class="hover:bg-gray-50">
            <td class="px-6 py-4">${volunteer.firstName} ${volunteer.lastName}</td>
            <td class="px-6 py-4">${volunteer.email}</td>
            <td class="px-6 py-4">${volunteer.phone}</td>
            <td class="px-6 py-4">
                <span class="px-2 py-1 rounded-full text-xs ${getStatusColor(volunteer.status)}">
                    ${volunteer.status}
                </span>
            </td>
            <td class="px-6 py-4">${new Date(volunteer.appliedDate).toLocaleDateString()}</td>
            <td class="px-6 py-4">
                <button onclick="viewVolunteerDetails('${volunteer._id}')" 
                        class="text-blue-600 hover:text-blue-800 mr-3">View</button>
                <button onclick="updateVolunteerStatus('${volunteer._id}')"
                        class="text-green-600 hover:text-green-800">Update Status</button>
            </td>
        </tr>
    `).join('');
}

function getStatusColor(status) {
    const colors = {
        pending: 'bg-yellow-100 text-yellow-800',
        approved: 'bg-blue-100 text-blue-800',
        active: 'bg-green-100 text-green-800',
        inactive: 'bg-gray-100 text-gray-800'
    };
    return colors[status] || colors.pending;
}

async function viewVolunteerDetails(id) {
    try {
        const response = await fetch(`/api/volunteers/${id}`);
        if (!response.ok) throw new Error('Failed to fetch volunteer details');
        const volunteer = await response.json();
        
        const detailsDiv = document.getElementById('volunteerDetails');
        detailsDiv.innerHTML = `
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <h4 class="font-bold">Name</h4>
                    <p>${volunteer.firstName} ${volunteer.lastName}</p>
                </div>
                <div>
                    <h4 class="font-bold">Contact</h4>
                    <p>Email: ${volunteer.email}</p>
                    <p>Phone: ${volunteer.phone}</p>
                </div>
                <div>
                    <h4 class="font-bold">Occupation</h4>
                    <p>${volunteer.occupation}</p>
                </div>
                <div>
                    <h4 class="font-bold">Status</h4>
                    <p>${volunteer.status}</p>
                </div>
                <div>
                    <h4 class="font-bold">Availability</h4>
                    <p>${volunteer.availability.join(', ')}</p>
                </div>
                <div>
                    <h4 class="font-bold">Interests</h4>
                    <p>${volunteer.interests.join(', ')}</p>
                </div>
                <div class="col-span-2">
                    <h4 class="font-bold">Experience</h4>
                    <p>${volunteer.experience}</p>
                </div>
            </div>
        `;
        
        document.getElementById('volunteerModal').style.display = 'flex';
    } catch (error) {
        console.error('Error loading volunteer details:', error);
        alert('Error loading volunteer details');
    }
}

async function updateVolunteerStatus(id) {
    const newStatus = prompt('Enter new status (pending/approved/active/inactive):');
    if (!newStatus) return;
    
    try {
        const response = await fetch(`/api/volunteers/${id}/status`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ status: newStatus })
        });
        
        if (!response.ok) throw new Error('Failed to update status');
        
        loadVolunteers();
    } catch (error) {
        console.error('Error updating volunteer status:', error);
        alert('Error updating volunteer status');
    }
}

// Event Listeners for volunteer management
document.getElementById('closeVolunteerModal').addEventListener('click', () => {
    document.getElementById('volunteerModal').style.display = 'none';
});

document.getElementById('volunteerSearch').addEventListener('input', filterVolunteers);
document.getElementById('volunteerStatusFilter').addEventListener('change', filterVolunteers);

function filterVolunteers() {
    const searchTerm = document.getElementById('volunteerSearch').value.toLowerCase();
    const statusFilter = document.getElementById('volunteerStatusFilter').value;
    
    const rows = document.querySelectorAll('#volunteersTableBody tr');
    rows.forEach(row => {
        const name = row.cells[0].textContent.toLowerCase();
        const status = row.cells[3].textContent.trim().toLowerCase();
        const matchesSearch = name.includes(searchTerm);
        const matchesStatus = !statusFilter || status === statusFilter;
        row.style.display = matchesSearch && matchesStatus ? '' : 'none';
    });
}

// Gallery management functions
async function loadGalleryImages() {
    try {
        const response = await fetch('/api/gallery/images');
        if (!response.ok) throw new Error('Failed to fetch images');
        const images = await response.json();
        
        const galleryGrid = document.getElementById('adminGalleryGrid');
        galleryGrid.innerHTML = images.map(image => `
            <div class="relative group">
                <img src="${image.thumbnailUrl}" alt="${image.title}" 
                     class="w-full h-48 object-cover rounded-lg">
                <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 
                            transition-opacity duration-300 flex items-center justify-center">
                    <div class="text-white text-center p-4">
                        <h3 class="font-bold">${image.title}</h3>
                        <p class="text-sm">${image.category}</p>
                        <button onclick="deleteImage('${image._id}')" 
                                class="mt-2 px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
    } catch (error) {
        console.error('Error loading gallery images:', error);
        alert('Error loading gallery images');
    }
}

async function deleteImage(imageId) {
    if (!confirm('Are you sure you want to delete this image?')) return;
    
    try {
        const response = await fetch(`/api/gallery/images/${imageId}`, {
            method: 'DELETE'
        });
        if (!response.ok) throw new Error('Failed to delete image');
        
        loadGalleryImages();
    } catch (error) {
        console.error('Error deleting image:', error);
        alert('Error deleting image');
    }
}

// Handle image upload
document.getElementById('imageUploadForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    
    try {
        const response = await fetch('/api/gallery/images', {
            method: 'POST',
            body: formData
        });
        
        if (!response.ok) throw new Error('Failed to upload image');
        
        e.target.reset();
        loadGalleryImages();
    } catch (error) {
        console.error('Error uploading image:', error);
        alert('Error uploading image');
    }
});

// Tab switching functionality
function hideAllSections() {
    const sections = [
        'outreachSection',
        'volunteersSection',
        'gallerySection'
    ];
    
    sections.forEach(sectionId => {
        const section = document.getElementById(sectionId);
        if (section) {
            section.classList.add('hidden');
            console.log(`Hiding section: ${sectionId}`);
        } else {
            console.warn(`Section not found: ${sectionId}`);
        }
    });
}

// Initialize dashboard
document.addEventListener('DOMContentLoaded', () => {
    // Show outreach section by default
    hideAllSections();
    document.getElementById('outreachSection').classList.remove('hidden');
    loadPrograms();

    // Add tab switching event listeners
    document.getElementById('outreachTabBtn').addEventListener('click', () => {
        hideAllSections();
        document.getElementById('outreachSection').classList.remove('hidden');
        loadPrograms();
    });

    document.getElementById('volunteersTabBtn').addEventListener('click', () => {
        hideAllSections();
        document.getElementById('volunteersSection').classList.remove('hidden');
        loadVolunteers();
    });

    document.getElementById('galleryTabBtn').addEventListener('click', () => {
        hideAllSections();
        document.getElementById('gallerySection').classList.remove('hidden');
        loadGalleryImages();
    });

    // Initialize other event listeners
    document.getElementById('addNewBtn').addEventListener('click', showModal);
    document.getElementById('cancelBtn').addEventListener('click', hideModal);
    document.getElementById('programForm').addEventListener('submit', handleFormSubmit);
    document.getElementById('searchInput').addEventListener('input', filterPrograms);
    document.getElementById('filterType').addEventListener('change', filterPrograms);
    document.getElementById('closeVolunteerModal').addEventListener('click', () => {
        document.getElementById('volunteerModal').style.display = 'none';
    });
    document.getElementById('volunteerSearch').addEventListener('input', filterVolunteers);
    document.getElementById('volunteerStatusFilter').addEventListener('change', filterVolunteers);
});

// Add this function for handling image uploads
async function handleImageUpload(e) {
    e.preventDefault();
    const formData = new FormData(e.target);
    
    try {
        const response = await fetch('/api/gallery/images', {
            method: 'POST',
            body: formData
        });
        
        if (!response.ok) throw new Error('Failed to upload image');
        
        e.target.reset();
        loadGalleryImages();
    } catch (error) {
        console.error('Error uploading image:', error);
        alert('Error uploading image');
    }
} 