<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Mode</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles */
        .maintenance-page {
            height: 100vh; /* Full height */
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            background-color: #f8f9fa;
        }
        .maintenance-message {
            padding: 30px;
            border: 2px solid #007bff;
            border-radius: 10px;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #dc3545;
        }
        p {
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="maintenance-page">
        <div class="maintenance-message">
            <h1>We're currently down for maintenance.</h1>
            <p>Please check back later.</p>
            <p class="text-muted">We apologize for the inconvenience.</p>
        </div>
    </div>

    <!-- Bootstrap JS and Popper (optional for some Bootstrap components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
