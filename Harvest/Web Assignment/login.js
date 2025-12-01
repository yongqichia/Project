document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('loginForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Retrieve form data
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        // Retrieve stored data
        const storedUsername = localStorage.getItem('username');
        const storedPassword = localStorage.getItem('password');

        // Check the console for retrieved data
        console.log('Entered Username:', username);
        console.log('Entered Password:', password);
        console.log('Stored Username:', storedUsername);
        console.log('Stored Password:', storedPassword);

        // Validate login
        if (username === storedUsername && password === storedPassword) {
            alert('Login Successful!');
            setTimeout(function() {
                window.location.href = 'FirstPage.html'; // Redirect to homepage after a short delay
            }, 2000); // 2000 milliseconds delay before redirecting
        } else {
            alert('Invalid username or password');
        }
    });
});
