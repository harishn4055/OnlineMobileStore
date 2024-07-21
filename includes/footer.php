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

<footer>
    <div class="container">
        <div class="row">
            <div class="col">
                <p>&copy; 2024 Mobile Mart. All rights reserved.</p>
            </div>
            <div class="col">
                <nav>
                    <a href="/privacy">Privacy Policy</a>|
                    <a href="/terms">Terms of Service</a>
                </nav>
            </div>
            <div class="col">
                <p>Follow us:</p>
                <a href="https://twitter.com/mobilemart"><i class="fab fa-twitter"></i></a>
                <a href="https://facebook.com/mobilemart"><i class="fab fa-facebook-f"></i></a>
                <a href="https://instagram.com/mobilemart"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>
</footer>