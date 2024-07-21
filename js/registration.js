document.getElementById('registrationForm').addEventListener('submit', function(event) {
    event.preventDefault();
    var username = document.getElementById('username').value;
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;

    if (username.length < 5) {
        alert('Username must be at least 5 characters long.');
        return;
    }
    if (password.length < 8) {
        alert('Password must be at least 8 characters long.');
        return;
    }
    if (!email.includes('@')) {
        alert('Please enter a valid email.');
        return;
    }
    this.submit();
});