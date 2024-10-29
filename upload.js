document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('uploadForm');
    const progressBar = document.getElementById('uploadProgress');
    const preview = document.getElementById('imagePreview');
    const MAX_WIDTH = 1920; // Maximum width for uploaded images
    const QUALITY = 0.8; // Image quality (0.8 = 80%)
    
    async function optimizeImage(file) {
        return new Promise((resolve) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const img = new Image();
                img.onload = () => {
                    const canvas = document.createElement('canvas');
                    let width = img.width;
                    let height = img.height;
                    
                    // Calculate new dimensions while maintaining aspect ratio
                    if (width > MAX_WIDTH) {
                        height = Math.round((height * MAX_WIDTH) / width);
                        width = MAX_WIDTH;
                    }
                    
                    canvas.width = width;
                    canvas.height = height;
                    
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, width, height);
                    
                    // Convert to blob with specified quality
                    canvas.toBlob((blob) => {
                        resolve(new File([blob], file.name, {
                            type: 'image/jpeg',
                            lastModified: Date.now()
                        }));
                    }, 'image/jpeg', QUALITY);
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        });
    }
    
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        progressBar.classList.remove('hidden');
        
        try {
            const fileInput = form.querySelector('input[type="file"]');
            const files = [...fileInput.files];
            const formData = new FormData();
            
            // Show optimization progress
            const optimizationProgress = document.createElement('div');
            optimizationProgress.className = 'text-center mt-4';
            optimizationProgress.textContent = 'Optimizing images...';
            progressBar.appendChild(optimizationProgress);
            
            // Optimize each image
            const optimizedFiles = await Promise.all(
                files.map(async (file) => {
                    if (file.type.startsWith('image/')) {
                        return await optimizeImage(file);
                    }
                    return file;
                })
            );
            
            // Add optimized files to FormData
            optimizedFiles.forEach((file, index) => {
                formData.append(`images[]`, file);
            });
            
            // Add other form data
            formData.append('eventDate', form.querySelector('[name="eventDate"]').value);
            formData.append('description', form.querySelector('[name="description"]').value);
            
            const response = await fetch('/api/upload.php', {
                method: 'POST',
                body: formData,
                onUploadProgress: (progressEvent) => {
                    const percentCompleted = Math.round(
                        (progressEvent.loaded * 100) / progressEvent.total
                    );
                    document.getElementById('progressPercent').textContent = 
                        `${percentCompleted}%`;
                }
            });
            
            if (response.ok) {
                const result = await response.json();
                if (result.success) {
                    alert('Images uploaded successfully!');
                    form.reset();
                    preview.innerHTML = '';
                } else {
                    throw new Error(result.message || 'Upload failed');
                }
            }
        } catch (error) {
            console.error('Upload failed:', error);
            alert('Upload failed: ' + error.message);
        } finally {
            progressBar.classList.add('hidden');
            progressBar.innerHTML = `
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: 0%"></div>
                </div>
                <p class="text-center mt-2">Uploading... <span id="progressPercent">0%</span></p>
            `;
        }
    });
    
    // Enhanced preview with file size information
    form.querySelector('input[type="file"]').addEventListener('change', async (e) => {
        preview.innerHTML = '';
        const files = [...e.target.files];
        
        for (const file of files) {
            const reader = new FileReader();
            reader.onload = async (e) => {
                const div = document.createElement('div');
                div.className = 'relative aspect-square group';
                
                // Calculate original file size in MB
                const originalSize = (file.size / (1024 * 1024)).toFixed(2);
                
                // Get optimized size
                const optimizedFile = await optimizeImage(file);
                const optimizedSize = (optimizedFile.size / (1024 * 1024)).toFixed(2);
                
                div.innerHTML = `
                    <img src="${e.target.result}" 
                         class="w-full h-full object-cover rounded-lg">
                    <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white p-2 text-sm opacity-0 group-hover:opacity-100 transition-opacity">
                        <p>Original: ${originalSize} MB</p>
                        <p>Optimized: ${optimizedSize} MB</p>
                        <p>Reduction: ${Math.round((1 - optimizedSize/originalSize) * 100)}%</p>
                    </div>
                `;
                
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        }
    });
}); 