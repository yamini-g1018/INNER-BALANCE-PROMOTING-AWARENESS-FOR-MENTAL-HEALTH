<?php
session_start();
include("db.php");

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['register'])) {
    $name = $_POST['name'];
    $psychologist_id = $_POST['psychologist_id'];
    $license_no = $_POST['license_no'];
    $spec = $_POST['spec'];
    $password = $_POST['password'];

    if (!empty($psychologist_id) && !empty($password) && !is_numeric($psychologist_id)) {
        $query = "INSERT INTO doctor(name, psychologist_id, license_no, spec, password) VALUES ('$name', '$psychologist_id', '$license_no', '$spec', '$password')";
        if (mysqli_query($con, $query)) {
            echo "<script>alert('Successfully registered'); window.location.href = 'doctor_login.php';</script>";
        } else {
            echo "<script>alert('Registration failed: " . mysqli_error($con) . "');</script>";
        }
    } else {
        echo "<script>alert('Please enter valid information');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Psychologist Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .registration-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }

        .registration-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        .registration-container label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            text-align: left;
        }

        .registration-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .registration-container button {
            width: 100%;
            padding: 10px;
            background-color: blue;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .registration-container button:hover {
            background-color: skyblue;
        }

        .links button {
            background-color: grey;
        }
    </style>
</head>

<body>
    <div class="registration-container">
        <h2>Psychologist Registration</h2>
        <form action="" method="POST">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" required placeholder="Enter your full name">

            <label for="psychologist_id">Psychologist ID:</label>
            <input type="text" id="psychologist_id" name="psychologist_id" required placeholder="Enter your Psychologist ID">

            <label for="license_no">License Number:</label>
            <input type="text" id="license_no" name="license_no" required placeholder="Enter your License Number">

            <label for="spec">Specialization:</label>
            <input type="text" id="spec" name="spec" required placeholder="Enter Specialization">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required placeholder="Enter your password">

            <button type="submit" name="register">Register</button>
        </form>
        <script>
    function validateForm() {
        const name = document.getElementById('name').value.trim();
        const psychologistId = document.getElementById('psychologist_id').value.trim();
        const licenseNo = document.getElementById('license_no').value.trim();
        const specialization = document.getElementById('spec').value.trim();
        const password = document.getElementById('password').value.trim();

        if (name.length < 3) {
            alert('Full Name must be at least 3 characters long.');
            return false;
        }

        if (!/^[a-zA-Z0-9]+$/.test(psychologistId)) {
            alert('Psychologist ID must be alphanumeric.');
            return false;
        }

        if (!/^[a-zA-Z0-9]+$/.test(licenseNo)) {
            alert('License Number must be alphanumeric.');
            return false;
        }
        if (specialization.length < 3) {
            alert('Specialization must be at least 3 characters long.');
            return false;
        }

        if (password.length < 6) {
            alert('Password must be at least 6 characters long.');
            return false;
        }

        return true;
    }
</script>


        <form action="doctor_login.php" method="POST">
            <div class="links">
                <p>Already have an account?</p>
                <button type="submit">Sign In</button>
            </div>
        </form>
    </div>
</body>

</html>
