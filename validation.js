// Form validation for login and register pages

document.addEventListener('DOMContentLoaded', function() {
    
    // Register form validation
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            // Check if passwords match
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match!');
                return false;
            }
            
            // Check password length
            if (password.length < 6) {
                e.preventDefault();
                alert('Password must be at least 6 characters long!');
                return false;
            }
        });
        
        // Real-time password match indicator
        const confirmPasswordInput = document.getElementById('confirm_password');
        const passwordInput = document.getElementById('password');
        
        confirmPasswordInput.addEventListener('input', function() {
            if (this.value !== passwordInput.value && this.value !== '') {
                this.style.borderColor = '#ff4444';
            } else if (this.value === passwordInput.value && this.value !== '') {
                this.style.borderColor = '#00c851';
            } else {
                this.style.borderColor = '';
            }
        });
    }
    
    // Login form validation
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            // Check if fields are empty
            if (email.trim() === '' || password.trim() === '') {
                e.preventDefault();
                alert('Please fill in all fields!');
                return false;
            }
            
            // Basic email validation
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                e.preventDefault();
                alert('Please enter a valid email address!');
                return false;
            }
        });
    }
    
    // Email validation on input
    const emailInputs = document.querySelectorAll('input[type="email"]');
    emailInputs.forEach(input => {
        input.addEventListener('blur', function() {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (this.value !== '' && !emailPattern.test(this.value)) {
                this.style.borderColor = '#ff4444';
            } else if (this.value !== '') {
                this.style.borderColor = '#00c851';
            } else {
                this.style.borderColor = '';
            }
        });
    });
});