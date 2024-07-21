<!-- footer.php -->
<head>
    <style>
        html, body {
    height: 100%; /* Make sure the html and body elements take up all the height */
    display: flex;
    flex-direction: column; /* Stack elements vertically */
}

body {
    margin: 0; /* Remove default margin */
    display: flex;
    flex-direction: column;
    min-height: 100vh; /* Minimum height of 100% of the viewport height */
    flex: 1; /* Allows the body to expand to fill the space */
}

.container {
    flex: 1; /* Allows container to expand and push the footer down */
}

footer {
    width: 100%;
    background-color: #343a40; /* Adjust color as needed */
    color: white;
    text-align: center;
    padding: 20px 0; /* Padding for aesthetic spacing */
}
    </style>
</head>
<footer class="footer bg-dark text-white pt-4 pb-4">
    <div class="container">
        <div class="row text-center text-md-left">
            <div class="col-md-4">
                <p>&copy; 2024 Mobile Mart. All rights reserved.</p>
            </div>
            <div class="col-md-4">
                <nav class="nav justify-content-center justify-content-md-start">
                    <a href="/privacy" class="nav-link text-white px-2">Privacy Policy</a>|
                    <a href="/terms" class="nav-link text-white px-2">Terms of Service</a>
                </nav>
            </div>
            <div class="col-md-4">
                <p>Follow us:</p>
                <a href="https://twitter.com/mobilemart" class="text-white px-2"><i class="fab fa-twitter"></i></a>
                <a href="https://facebook.com/mobilemart" class="text-white px-2"><i class="fab fa-facebook-f"></i></a>
                <a href="https://instagram.com/mobilemart" class="text-white px-2"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>