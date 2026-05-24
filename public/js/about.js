document.addEventListener('DOMContentLoaded', () => {
    // Dynamic load transition for the timeline roadmap cards
    const valueCards = document.querySelectorAll('.value-card');
    valueCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(15px)';
        card.style.transition = 'all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1)';
        
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 120 * (index + 1));
    });
});
