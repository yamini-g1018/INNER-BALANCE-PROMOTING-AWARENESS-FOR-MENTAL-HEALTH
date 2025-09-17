<?php
session_start();

include("db.php");

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['register'])) {
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];

    if (!empty($email) && !empty($password) && !is_numeric($email)) {
        $query = "INSERT INTO patients(name, mobile, email, password, age, gender) VALUES ('$name', '$mobile', '$email', '$password', '$age', '$gender')";
        if (mysqli_query($con, $query)) {
            echo "<script>alert('Successfully registered'); window.location.href = 'patient_login.php';</script>";

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
    <title>Patient Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px 30px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        button:hover {
            background-color: #0056b3;
        }

        button:active {
            background-color: #004080;
        }

        .links {
            text-align: center;
            margin-top: 10px;
        }

        .links p {
            margin: 0;
        }

        .links button {
            margin-top: 5px;
            background-color: #28a745;
        }

        .links button:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <h2>Patient Registration</h2>
    <form action="" method="POST" onsubmit="return validatePatientForm()">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="mobile">Mobile:</label>
        <input type="text" id="mobile" name="mobile" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="">Select Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required>

        <button type="submit" name="register">Register</button>
    </form>

    <script>
        function validatePatientForm() {
            const name = document.getElementById('name').value.trim();
            const mobile = document.getElementById('mobile').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();
            const age = document.getElementById('age').value.trim();

            if (name.length < 3) {
                alert('Name must be at least 3 characters long.');
                return false;
            }

            if (!/^\d{10}$/.test(mobile)) {
                alert('Mobile number must be exactly 10 digits.');
                return false;
            }

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert('Enter a valid email address.');
                return false;
            }

            if (password.length < 6) {
                alert('Password must be at least 6 characters long.');
                return false;
            }

            if (isNaN(age) || age <= 0) {
                alert('Enter a valid age greater than 0.');
                return false;
            }

            return true;
        }
    </script>

    <div class="links">
        <p>Already have an account?</p>
        <form action="patient_login.php" method="post">
            <button type="submit">Sign In</button>
        </form>
    </div>
</body>

</html>