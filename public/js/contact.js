document.addEventListener('DOMContentLoaded', () => {
    const contactForm = document.getElementById('contactForm');
    const inputs = document.querySelectorAll('.input-group input, .input-group textarea');

    // Validation styling trigger
    if (contactForm) {
        contactForm.addEventListener('submit', (e) => {
            let valid = true;
            inputs.forEach(input => {
                if (!input.checkValidity()) {
                    valid = false;
                    input.style.borderColor = '#ff4433';
                    input.style.boxShadow = '0 0 10px rgba(255, 68, 51, 0.2)';
                    
                    input.addEventListener('input', function resetError() {
                        input.style.borderColor = '';
                        input.style.boxShadow = '';
                        input.removeEventListener('input', resetError);
                    });
                }
            });

            if (!valid) {
                e.preventDefault();
                
                // Shake the card to indicate validation failure
                const card = document.querySelector('.contact-form-card');
                card.style.animation = 'none';
                void card.offsetWidth; // Trigger reflow
                card.style.animation = 'shake 0.5s ease-in-out';
            } else {
                e.preventDefault();
                alert('Thank you, Darshan Joshi! Your secure message has been successfully logged (static confirmation).');
                contactForm.reset();
            }
        });
    }
});

// CSS shake keyframe injector if not already injected
if (!document.getElementById('shake-style')) {
    const style = document.createElement('style');
    style.id = 'shake-style';
    style.innerHTML = `
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-6px); }
        20%, 40%, 60%, 80% { transform: translateX(6px); }
    }
    `;
    document.head.appendChild(style);
}
