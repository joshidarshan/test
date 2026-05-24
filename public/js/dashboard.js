document.addEventListener('DOMContentLoaded', () => {
    // Stat counters slide animation
    const stats = document.querySelectorAll('.stat-value');
    stats.forEach(stat => {
        const value = parseInt(stat.textContent, 10);
        if (!isNaN(value)) {
            let start = 0;
            const duration = 1200;
            const stepTime = Math.abs(Math.floor(duration / value));
            
            const timer = setInterval(() => {
                start += 1;
                stat.textContent = start + (stat.dataset.suffix || '');
                if (start >= value) {
                    clearInterval(timer);
                }
            }, stepTime);
        }
    });
});
