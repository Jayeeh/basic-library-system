document.addEventListener('DOMContentLoaded', function() {
    const registrationForm = document.getElementById('registrationForm');
    const navRegisterBtn = document.getElementById('navRegisterBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const form = registrationForm.querySelector('form');

    // Show registration form when navbar register button is clicked
    navRegisterBtn.addEventListener('click', function() {
        registrationForm.style.display = 'block';
    });

    // Hide registration form when cancel button is clicked
    cancelBtn.addEventListener('click', function() {
        registrationForm.style.display = 'none';
        form.reset(); // Clear form fields
    });

    // Form validation
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const password = form.querySelector('input[type="password"]').value;
        const confirmPassword = form.querySelectorAll('input[type="password"]')[1].value;

        if (password !== confirmPassword) {
            alert('Passwords do not match!');
            return;
        }

        // If validation passes, submit the form
        this.submit();
    });
});