document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const messageInput = document.getElementById('message');

    const nameError = document.getElementById('nameError');
    const emailError = document.getElementById('emailError');
    const messageError = document.getElementById('messageError');

    form.addEventListener('submit', function(event) {
        let valid = true;

        // Validate Name
        if (nameInput.value.trim() === '') {
            nameError.textContent = 'Name is required.';
            valid = false;
        } else {
            nameError.textContent = '';
        }

        // Validate Email
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(emailInput.value)) {
            emailError.textContent = 'Please enter a valid email address.';
            valid = false;
        } else {
            emailError.textContent = '';
        }

        // Validate Message
        if (messageInput.value.trim() === '') {
            messageError.textContent = 'Message is required.';
            valid = false;
        } else {
            messageError.textContent = '';
        }

        if (!valid) {
            event.preventDefault(); // Prevent form submission if invalid
        } else {
            alert('Your message has been successfully sent!');
            this.reset();
        }
    });
});
