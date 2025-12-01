document.addEventListener("DOMContentLoaded", function() {
    const notificationIcon = document.getElementById('notification-icon');
    const notificationPopup = document.getElementById('notification-popup');
    const closePopup = document.getElementById('close-popup');

    // Show the notification popup when the icon is clicked
    notificationIcon.addEventListener('click', function() {
        notificationPopup.style.display = 'block';
    });

    // Close the popup when the close button is clicked
    closePopup.addEventListener('click', function() {
        notificationPopup.style.display = 'none';
    });

    // Optionally, close the popup if clicked outside (outside click listener)
    window.addEventListener('click', function(event) {
        if (!notificationIcon.contains(event.target) && !notificationPopup.contains(event.target)) {
            notificationPopup.style.display = 'none';
        }
    });
});
