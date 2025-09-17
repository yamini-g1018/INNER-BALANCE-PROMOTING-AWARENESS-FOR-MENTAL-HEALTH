<?php

session_start();
include("db.php");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // Hardcoded Admin Credentials
    if ($name === "admin" && $password === "admin@1234") {
        $_SESSION['user_id'] = "admin"; // Store session for admin
        echo "<script>alert('Login successful! Redirecting...'); window.location='admin_dashboard.php';</script>";
        exit();
    } else {
        echo "<script>alert('Invalid username or password. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login</title>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.login-container {
    background-color: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 300px;
    text-align: center;
}
.login-container h2 {
    margin-bottom: 20px;
    font-size: 24px;
}
.login-container label {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
    text-align: left;
}
.login-container input {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}
.login-container button {
    width: 100%;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
}
.login-container button:hover {
    background-color: #45a049;
}
</style>
</head>
<body>
<div class="login-container">
    <h2>Admin Login</h2>
    <form method="POST">
        <label for="name">Username:</label>
        <input type="text" id="name" name="name" required placeholder="Enter username">
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required placeholder="Enter password">
        
        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>
