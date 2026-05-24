document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('loginForm');
    const submitBtn = document.querySelector('.btn-submit');
    const inputs = document.querySelectorAll('.input-group input');

    // Create click ripple effect on submission button
    if (submitBtn) {
        submitBtn.addEventListener('click', function(e) {
            // Check if form is valid first before performing ripple
            if (!loginForm.checkValidity()) return;

            let x = e.clientX - e.target.offsetLeft;
            let y = e.clientY - e.target.offsetTop;
            
            let ripple = document.createElement('span');
            ripple.classList.add('ripple');
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    }

    // Input interaction animation
    inputs.forEach(input => {
        // Keep focus border glowing if values exist
        input.addEventListener('blur', () => {
            if (input.value !== "") {
                input.classList.add('has-content');
            } else {
                input.classList.remove('has-content');
            }
        });
    });

    // Login Form Validation / Shake Animation on Error
    if (loginForm) {
        loginForm.addEventListener('submit', (e) => {
            let valid = true;
            inputs.forEach(input => {
                if (!input.checkValidity()) {
                    valid = false;
                    // Trigger input error border styling
                    input.style.borderColor = '#ff4433';
                    input.style.boxShadow = '0 0 10px rgba(255, 68, 51, 0.2)';
                    
                    // Simple reset styling on typing
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
                const container = document.querySelector('.login-container');
                container.style.animation = 'none';
                void container.offsetWidth; // Trigger reflow to restart animation
                container.style.animation = 'shake 0.5s ease-in-out';
            }
        });
    }
});

// CSS shake keyframe injector
const style = document.createElement('style');
style.innerHTML = `
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-6px); }
    20%, 40%, 60%, 80% { transform: translateX(6px); }
}
`;
document.head.appendChild(style);
