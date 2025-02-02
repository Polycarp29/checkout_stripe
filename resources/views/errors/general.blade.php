<!-- resources/views/errors/general.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>Oops! Something went wrong.</h1>
        <p>{{ session('error') }}</p>
        <a href="{{ route('index') }}" class="btn btn-primary">Go Back to Home</a>
    </div>
</body>
</html>
