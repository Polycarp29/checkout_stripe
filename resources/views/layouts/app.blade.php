<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Check Out')</title>
    <!-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> -->
    <!-- Additional CSS can be added here -->
    <style>
      /* Reset and Basic Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f4f6f9;
    color: #333;
    line-height: 1.6;
}

/* Navbar */
.navbar {
    background-color: #007bff;
    color: #fff;
    padding: 1rem;
}

.navbar .navbar-brand {
    color: #fff;
    font-weight: 500;
    text-decoration: none;
    margin-right: 1.5rem;
}

.navbar-nav {
    list-style: none;
    display: flex;
    gap: 1rem;
    margin-left: auto;
}

.navbar-nav .nav-item {
    display: inline;
}

.navbar-nav .nav-link {
    color: #fff;
    text-decoration: none;
    padding: 0.5rem 1rem;
    border-radius: 3px;
    transition: background-color 0.3s ease;
}

.navbar-nav .nav-link:hover {
    background-color: #0056b3;
}

/* Container */
.container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 20px;
}

/* Heading Styles */
h1 {
    font-size: 2rem;
    margin-bottom: 1rem;
    color: #333;
}

/* Alert Styles */
.alert {
    padding: 15px;
    background-color: #28a745;
    color: white;
    margin-bottom: 20px;
    border-radius: 5px;
}

.alert-success {
    background-color: #28a745;
}

/* Table Styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

table th,
table td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: left;
}

table th {
    background-color: #007bff;
    color: #fff;
}

table tr:nth-child(even) {
    background-color: #f9f9f9;
}

/* Button Styles */
button, .button-link {
    display: inline-block;
    font-weight: 500;
    color: #007bff;
    text-decoration: none;
    padding: 10px 20px;
    border: 1px solid #007bff;
    border-radius: 5px;
    transition: background-color 0.3s ease;
    cursor: pointer;
}

button:hover, .button-link:hover {
    background-color: #007bff;
    color: #fff;
}

/* Form Styles */
form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 20px;
}

form label {
    font-weight: bold;
    margin-bottom: 0.5rem;
}

form input[type="text"],
form textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 1rem;
}

form button[type="submit"] {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

form button[type="submit"]:hover {
    background-color: #0056b3;
}

/* Footer */
footer {
    background-color: #f8f9fa;
    color: #6c757d;
    padding: 15px 0;
    text-align: center;
    font-size: 0.9rem;
    border-top: 1px solid #e9ecef;
}



    </style>

</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('index') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('index') }}">Products</a>
                    </li>
                    <!-- Additional links can be added here -->
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="bg-light text-center py-4 mt-5">
        <p>&copy; {{ date('Y') }} Stripe Gateway. All rights reserved.</p>
    </footer>

    <!-- JavaScript files -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Additional scripts can be added here -->
</body>
</html>
