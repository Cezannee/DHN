import './bootstrap';
import 'flowbite';

/**
 * Frontend Theme Switcher
 * ------------------------------------------------------------------
 */

// On page load, set the theme
function setInitialTheme() {
    if (
        localStorage.getItem('color-theme') === 'dark' ||
        (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
    ) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
}

// Update the toggle icons
function updateThemeToggleIcons() {
    const darkIcon = document.getElementById('theme-toggle-dark-icon');
    const lightIcon = document.getElementById('theme-toggle-light-icon');
    if (!darkIcon || !lightIcon) return;

    if (
        localStorage.getItem('color-theme') === 'dark' ||
        (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
    ) {
        lightIcon.classList.remove('hidden');
        darkIcon.classList.add('hidden');
    } else {
        darkIcon.classList.remove('hidden');
        lightIcon.classList.add('hidden');
    }
}

// Initialize theme toggle
function initThemeToggle() {
    const themeToggleBtn = document.getElementById('theme-toggle');
    if (!themeToggleBtn) return;
    
    // Remove any existing listeners to prevent duplicates
    const newBtn = themeToggleBtn.cloneNode(true);
    themeToggleBtn.parentNode.replaceChild(newBtn, themeToggleBtn);
    
    newBtn.addEventListener('click', function () {
        // Toggle theme
        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        }
        updateThemeToggleIcons();
    });
}

function activateHomeBackgroundSlide(slides, activeIndex) {
    slides.forEach((slide, index) => {
        const video = slide.querySelector('video');
        const isActive = index === activeIndex;

        slide.classList.toggle('is-active', isActive);

        if (!video) return;

        if (isActive) {
            video.play().catch(() => {});
        } else {
            video.pause();
        }
    });
}

function initHomeBackgroundSliders() {
    document.querySelectorAll('[data-home-background-slider]').forEach((slider) => {
        if (slider.dataset.homeBackgroundReady === 'true') return;

        const slides = Array.from(slider.querySelectorAll('[data-home-background-slide]'));
        if (!slides.length) return;

        slider.dataset.homeBackgroundReady = 'true';

        let activeIndex = 0;
        const interval = Number(slider.dataset.homeBackgroundInterval || 7000);

        activateHomeBackgroundSlide(slides, activeIndex);

        if (slides.length < 2) return;

        const timerId = window.setInterval(() => {
            if (!document.body.contains(slider)) {
                window.clearInterval(timerId);
                return;
            }

            activeIndex = (activeIndex + 1) % slides.length;
            activateHomeBackgroundSlide(slides, activeIndex);
        }, Number.isFinite(interval) && interval > 0 ? interval : 7000);
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    setInitialTheme();
    updateThemeToggleIcons();
    initThemeToggle();
    initHomeBackgroundSliders();
});

// Re-initialize Flowbite components after Livewire navigation (SPA-like page transitions)
document.addEventListener('livewire:navigated', () => {
    initFlowbite();
    updateThemeToggleIcons();
    initThemeToggle();
    initHomeBackgroundSliders();
});

// Re-initialize Flowbite components after Livewire updates the DOM (for dynamic content)
document.addEventListener('livewire:update', () => {
    initFlowbite();
    initHomeBackgroundSliders();
});
