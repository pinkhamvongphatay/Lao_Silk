<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lao+Looped:wght@100..900&family=Noto+Sans+Lao:wght@100..900&display=swap" rel="stylesheet">
    <style>
        
      body {
            font-family: "Noto Sans Lao", sans-serif;
            display: flex;
            height: 100vh;
        }
        .sidebar {
            width: 250px;
            background-color: #ff69b4; /* Pink */
            color: white;
            padding: 20px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 5px;
        }
        .sidebar a:hover {
            background-color: #ff1493; /* Darker Pink */
        }
        .content {
            flex-grow: 1;
            padding: 20px;
            background-color: #f8f9fa; /* Light Gray */
        }
        .logo {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="logo">🌸 Laosilk Admin</div>
    <a href="index.php">Home</a>
    <a href="customer.php">Customer</a>
    <a href="employees.php">Employee</a>
    <a href="dress.php">Dress</a>
    <a href="dress_type.php">Dress Type</a>
    <a href="rental.php">Rental</a>
</div>

<!-- Main Content -->
<div class="content">
    <!-- other page will be loaded here -->
