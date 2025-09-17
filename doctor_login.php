<?php
session_start();
include("db.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    
    $psychologist_id = isset($_POST['psychologist_id']) ? $_POST['psychologist_id'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (!empty($psychologist_id) && !empty($password) && !is_numeric($psychologist_id)) {
        $query = "SELECT * FROM doctor WHERE psychologist_id = '$psychologist_id' LIMIT 1";
        $result = mysqli_query($con, $query);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);

                if ($user_data['password'] === $password) {
                    $_SESSION['id'] = $user_data['id'];
                    $_SESSION['psychologist_id'] = $user_data['psychologist_id'];
                    $_SESSION['psychologist_name'] = $user_data['name'];

                    header("Location: doctor_dashboard.php");
                    exit();
                } else {
                    echo "<script>alert('Wrong password. Please try again.');</script>";
                }
            } else {
                echo "<script>alert('Invalid Psychologist ID. Please try again.');</script>";
            }
        } else {
            echo "<script>alert('Database query failed.');</script>";
        }
    } 
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Psychologist Login</title>
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

        .login-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 350px;
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
            background-color: blue;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .login-container button:hover {
            background-color: skyblue;
        }

        .login-container .error-message {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Psychologist Login</h2>
        <form action="" method="POST">
            <label for="psychologist-id">Psychologist ID:</label>
            <input type="text" id="psychologist-id" name="psychologist_id" required placeholder="Enter your Psychologist ID">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required placeholder="Enter your password">

            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>
