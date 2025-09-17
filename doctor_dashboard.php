<?php
session_start();
include("db.php");
if (!isset($_SESSION['id'])) {
  header("Location: doctor_login.php");
  exit();
}

$doctor_id = $_SESSION['id'];
$query = "SELECT * FROM doctor WHERE id = '$doctor_id' LIMIT 1";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
  $doctor_data = mysqli_fetch_assoc($result);
} else {
  echo "<script>alert('Doctor not found.'); window.location.href = 'doctor_login.php';</script>";
  exit();
}

// Handling report data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_report'])) {
  $patient_id = $_POST['patient_id'];
  
  if (!empty($_POST['social_report'])) {
    $report = $_POST['social_report'];
    $column = "social_report";
  } elseif (!empty($_POST['death_report'])) {
    $report = $_POST['death_report'];
    $column = "death_report";
  } elseif (!empty($_POST['self_report'])) {
    $report = $_POST['self_report'];
    $column = "self_report";
  }

  if (isset($report) && isset($column)) {
    $update_sql = "UPDATE patients SET $column = ? WHERE id = ?";
    $stmt = $con->prepare($update_sql);
    $stmt->bind_param("si", $report, $patient_id);
    
    if ($stmt->execute()) {
      echo "<script>alert('Report updated successfully.'); window.location.href = 'doctor_dashboard.php';</script>";
    } else {
      echo "<script>alert('Error updating report.');</script>";
    }
    
    $stmt->close();
  }
}

// Fetch patient details (first patient for demo)
$sql = "SELECT id, name, gender, age, social_anxietyScore, death_anxietyScore, self_anxietyscore, social_report, death_report, self_report FROM patients LIMIT 1";
$result1 = $con->query($sql);
if ($result1 && $result1->num_rows > 0) {
  $patient_data = $result1->fetch_assoc();
} else {
  $patient_data = ['id' => 'N/A', 'name' => 'N/A', 'gender' => 'N/A', 'age' => 'N/A'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Doctor Dashboard</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f9;
      display: flex;
      flex-direction: column;
      height: 100vh;
    }
    .page-header {
      background-color: #3498db;
      color: white;
      padding: 20px;
      text-align: center;
      font-size: 32px;
    }
    .logout-button {
      position: absolute;
      top: 15px;
      right: 15px;
      text-decoration: none;
      padding: 6px 12px;
      background-color: darkblue;
      color: white;
      border-radius: 3px;
      font-family: Arial, sans-serif;
    }
    .logout-button:hover {
      background-color: steelblue;
    }
    .container {
      display: flex;
      width: 100%;
      flex: 1;
    }
    .sidebar {
      background-color: #2c3e50;
      color: white;
      width: 250px;
      padding: 20px;
    }
    .sidebar ul {
      list-style: none;
      padding-left: 0;
    }
    .sidebar ul li {
      margin-bottom: 20px;
    }
    .sidebar ul li a {
      text-decoration: none;
      color: white;
      font-size: 18px;
      display: block;
    }
    .sidebar ul li a:hover {
      background-color: #34495e;
      padding-left: 10px;
    }
    .main-content {
      flex: 1;
      padding: 20px;
    }
    .tab-content {
      display: none;
      background-color: white;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    .tab-content.active {
      display: block;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      margin-top: 20px;
      border-radius: 5px;
      overflow: hidden;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: left;
    }
    th {
      background-color: #007bff;
      color: white;
    }
    tr:hover {
      background-color: #f1f1f1;
    }
    .report-form {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    textarea {
      width: 100%;
      height: 50px;
      resize: none;
    }
    button {
      background-color: #28a745;
      color: white;
      padding: 5px 10px;
      border: none;
      cursor: pointer;
    }
    button:hover {
      background-color: #218838;
    }
    #psychologist-info {
      max-width: 100%;
      margin: 0;
      padding: 20px;
      background: linear-gradient(135deg, #e6f0fa 0%, #cce4ff 100%);
      border-radius: 15px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
      border: 1px solid #1e90ff;
    }
    #psychologist-info h2 {
      font-size: 28px;
      color: #1e90ff;
      margin-bottom: 10px;
    }
    #psychologist-info hr {
      border: none;
      height: 2px;
      background: #1e90ff;
      margin: 10px 0;
      opacity: 0.7;
    }
    #psychologist-info .user-details {
      background: white;
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
      transition: transform 0.3s ease;
    }
    #psychologist-info .user-details:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }
    #psychologist-info .user-details p {
      font-size: 16px;
      color: #2c3e50;
      margin: 5px 0;
      padding: 8px;
      background: #f8f9fa;
      border-radius: 5px;
      display: flex;
      align-items: center;
      justify-content: flex-start;
      gap: 5px;
    }
    #psychologist-info .user-details p strong {
      color: #1e90ff;
      font-weight: bold;
      margin-right: 0;
    }
    #patient-details {
  max-width: 100%;
  margin: 0;
  padding: 20px;
  background: linear-gradient(135deg, #f0f8ff 0%, #d6eaff 100%);
  border-radius: 15px;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
  border: 1px solid #1e90ff;
}

#patient-details h2 {
  font-size: 28px;
  color: #1e90ff;
  margin-bottom: 15px;
  text-align: center;
}

#patient-details hr {
  border: none;
  height: 2px;
  background: #1e90ff;
  margin: 10px 0;
  opacity: 0.7;
}
#patient-details table {
  width: 100%;
  border-collapse: collapse;
  background: white;
  margin-top: 20px;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
}

#patient-details th,
#patient-details td {
  padding: 12px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

#patient-details th {
  background-color: #1e90ff;
  color: white;
  font-size: 16px;
}

#patient-details tr:hover {
  background-color: #f1f9ff;
}

#patient-details form {
  display: flex;
  flex-direction: column;
  gap: 5px;
}

#patient-details textarea {
  width: 100%;
  height: 60px;
  resize: none;
  padding: 8px;
  font-size: 14px;
  border: 1px solid #ccc;
  border-radius: 5px;
  background: #f8f9fa;
}

#patient-details button {
  background-color:rgb(84, 29, 195);
  color: white;
  padding: 8px 12px;
  border: none;
  cursor: pointer;
  border-radius: 5px;
  transition: background 0.3s ease-in-out;
}

#patient-details button:hover {
  background-color:rgb(33, 72, 136);
}


  </style>
</head>
<body>
  <header class="page-header">
    <h1>Psychologist Dashboard</h1>
    <a href="home.php" class="logout-button">Logout</a>
  </header>

  <div class="container">
    <nav class="sidebar">
      <ul>
        <li><a href="#" class="tab-link" onclick="openTab('psychologist-info')">Psychologist Details</a></li>
        <li><a href="#" class="tab-link" onclick="openTab('patient-details')">Object Details View</a></li>
      </ul>
    </nav>

    <div class="main-content">
      <div id="psychologist-info" class="tab-content active">
        <h2>Personal Information</h2>
        <hr>
        <div class="user-details">
          <p><strong>ID:</strong> <?php echo $doctor_data['id']; ?></p>
          <p><strong>Name:</strong> <?php echo $doctor_data['name']; ?></p>
          <p><strong>Psychologist ID:</strong> <?php echo $doctor_data['psychologist_id']; ?></p>
          <p><strong>License Number:</strong> <?php echo $doctor_data['license_no']; ?></p>
          <p><strong>Specialization:</strong> <?php echo $doctor_data['spec']; ?></p>
        </div>
      </div>


      <div id="patient-details" class="tab-content">
        <h2>Object Details View</h2>
        <table border="1">
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Age</th>
            <th>Social Anxiety Score</th>
            <th>Report on social anxiety</th>
            <th>Death Anxiety Score</th>
            <th>Report on death anxiety</th>
            <th>Self Anxiety Score</th>
            <th>Report on self anxiety</th>
          </tr>
          <?php
          $sql = "SELECT id, name, gender, age, social_anxietyScore, death_anxietyScore, self_anxietyscore, social_report, death_report, self_report FROM patients";
          $result1 = $con->query($sql);
          if ($result1->num_rows > 0) {
            while ($row = $result1->fetch_assoc()) {
              echo "<tr>
                      <td>{$row['id']}</td>
                      <td>{$row['name']}</td>
                      <td>{$row['gender']}</td>
                      <td>{$row['age']}</td>
                      <td>{$row['social_anxietyScore']}</td>
                      <td>
                        <form method='POST'>
                          <input type='hidden' name='patient_id' value='{$row['id']}'>
                          <textarea name='social_report'>{$row['social_report']}</textarea>
                          <button type='submit' name='update_report'>Update Report</button>
                        </form>
                      </td>
                      <td>{$row['death_anxietyScore']}</td>
                      <td>
                        <form method='POST'>
                          <input type='hidden' name='patient_id' value='{$row['id']}'>
                          <textarea name='death_report'>{$row['death_report']}</textarea>
                          <button type='submit' name='update_report'>Update Report</button>
                        </form>
                      </td>
                      <td>{$row['self_anxietyscore']}</td>
                      <td>
                        <form method='POST'>
                          <input type='hidden' name='patient_id' value='{$row['id']}'>
                          <textarea name='self_report'>{$row['self_report']}</textarea>
                          <button type='submit' name='update_report'>Update Report</button>
                        </form>
                      </td>
                    </tr>";
            }
          } else {
            echo "<tr><td colspan='10'>No patients found</td></tr>";
          }
          ?>
        </table>
      </div>
    </div>
  </div>

  <script>
    function openTab(tabId) {
      document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
      document.getElementById(tabId).classList.add('active');
    }
  </script>
</body>
</html>

