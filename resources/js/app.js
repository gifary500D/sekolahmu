// Antigravity Client Scripts: Dynamic Greetings & UI Enhancements
(function () {
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
