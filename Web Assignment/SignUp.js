document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('signupForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Retrieve form data
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;

        // Validate form data
        if (password !== confirmPassword) {
            alert('Passwords do not match');
            return;
        }

        if (password.length < 6) {
            alert('Password must be at least 6 characters long');
            return;
        }

        // Store user data in localStorage
        localStorage.setItem('username', username);
        localStorage.setItem('password', password);

        // Check the console for stored data
        console.log('Stored Username:', localStorage.getItem('username'));
        console.log('Stored Password:', localStorage.getItem('password'));

        // Registration success
        alert('Sign Up Successful! Please log in.');
        setTimeout(function() {
            window.location.href = 'login.html'; // Redirect to login page after a short delay
        }, 2000); // 2000 milliseconds delay before redirecting
    });
});
