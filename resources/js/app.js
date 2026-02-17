import './bootstrap';
import imageCompression from 'browser-image-compression';

// Image Compression Utility
window.compressImage = async (file, options = {}) => {
    const defaultOptions = {
        maxSizeMB: 1,
        maxWidthOrHeight: 1200,
        useWebWorker: true,
        initialQuality: 0.8
    };
    try {
        return await imageCompression(file, { ...defaultOptions, ...options });
    } catch (error) {
        console.error('Image compression failed:', error);
        return file;
    }
};

// Global form compressor interceptor
document.addEventListener('submit', async (e) => {
    const form = e.target;
    // Check if form has file inputs with data-compress attribute
    const fileInputs = form.querySelectorAll('input[type="file"][data-compress="true"]');

    if (fileInputs.length > 0 && !form.dataset.compressed) {
        e.preventDefault();

        // Show loading state on button
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn ? submitBtn.innerHTML : '';
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span>⏳</span> Compressing...';
        }

        const formData = new FormData(form);

        for (const input of fileInputs) {
            const name = input.name;
            const files = input.files;
            if (files.length > 0) {
                const compressedFile = await window.compressImage(files[0]);
                // Append compressed version to formData
                formData.set(name, compressedFile, compressedFile.name);
            }
        }

        // Send via AJAX
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

            const response = await fetch(form.action, {
                method: form.method,
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            if (response.redirected) {
                window.location.href = response.url;
                return;
            }

            const result = await response.json();
            if (result.success || response.ok) {
                // If the server returned a JSON success or just a 200 OK
                if (result.message) {
                    // Optional: Show a nice toast here
                    console.log(result.message);
                }
                window.location.reload();
            } else {
                // Handle validation errors from Laravel
                let errorMsg = 'Upload failed';
                if (result.errors) {
                    errorMsg = Object.values(result.errors).flat().join('\n');
                } else if (result.message) {
                    errorMsg = result.message;
                }
                alert(errorMsg);

                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                }
            }
        } catch (error) {
            console.error('Form submission failed:', error);
            // Fallback: regular submit if AJAX fails mysteriously
            form.dataset.compressed = "true";
            form.submit();
        }
    }
});

// Dark theme toggle
document.addEventListener('DOMContentLoaded', function () {
    const themeToggle = document.getElementById('theme-toggle');
    const html = document.documentElement;

    // Check for saved theme preference or default to light mode
    const savedTheme = localStorage.getItem('theme') || 'light';
    if (savedTheme === 'dark') {
        html.classList.add('dark');
    } else {
        html.classList.remove('dark');
    }

    if (themeToggle) {
        themeToggle.addEventListener('click', function () {
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        });
    }
});
