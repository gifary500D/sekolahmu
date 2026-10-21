// Antigravity Client Scripts: AOS, Dynamic Greetings & UI Enhancements
import AOS from 'aos';
import 'aos/dist/aos.css';

(function () {
    // Inisialisasi Animate On Scroll (AOS)
    if (typeof window !== 'undefined') {
        window.AOS = AOS;
        const initAos = function () {
            AOS.init({
                duration: 700,
                once: true,
                offset: 60,
                easing: 'ease-out-cubic'
            });
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initAos);
        } else {
            initAos();
        }
    }

    // Night Mode (Dark Mode) Helper & Storage Sync
    window.toggleDarkMode = function () {
        const isDark = document.documentElement.classList.toggle('dark');
        try {
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        } catch (e) {}
        window.dispatchEvent(new CustomEvent('theme-changed', { detail: { theme: isDark ? 'dark' : 'light' } }));
    };

    // Listen for storage changes across browser tabs
    window.addEventListener('storage', function (e) {
        if (e.key === 'theme') {
            if (e.newValue === 'dark') {
                document.documentElement.classList.add('dark');
            } else if (e.newValue === 'light') {
                document.documentElement.classList.remove('dark');
            }
        }
    });

    // Sync system color scheme when no explicit preference in localStorage
    if (window.matchMedia) {
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function (e) {
            if (!localStorage.getItem('theme')) {
                if (e.matches) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            }
        });
    }

    function getDeviceGreeting() {
        const hour = new Date().getHours();
        if (hour >= 4 && hour <= 10) {
            return 'Selamat Pagi';
        } else if (hour >= 11 && hour <= 14) {
            return 'Selamat Siang';
        } else if (hour >= 15 && hour <= 17) {
            return 'Selamat Sore';
        } else {
            return 'Selamat Malam';
        }
    }

    function updateDynamicGreetings() {
        const greeting = getDeviceGreeting();
        document.querySelectorAll('[data-greeting], .dynamic-greeting').forEach(function (el) {
            el.textContent = greeting;
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', updateDynamicGreetings);
    } else {
        updateDynamicGreetings();
    }
})();
