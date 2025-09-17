<?php
include("db.php");

function getPatients($con) {
    $sql = "SELECT * FROM patients"; 
    $result = $con->query($sql);
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

function getDoctors($con) {
    $sql = "SELECT * FROM doctor"; 
    $result = $con->query($sql);
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_patient'])) {
        $id = intval($_POST['delete_patient']);
        $con->query("DELETE FROM patients WHERE id = $id");
        header("Location: admin_dashboard.php");
        exit();
    }

    if (isset($_POST['delete_doctor'])) {
        $id = intval($_POST['delete_doctor']);
        $con->query("DELETE FROM doctor WHERE id = $id");
        header("Location: admin_dashboard.php");
        exit();
    }

    if (isset($_POST['edit_patient'])) {
        $id = intval($_POST['patient_id']);
        $name = $con->real_escape_string($_POST['name']);
        $email = $con->real_escape_string($_POST['email']);

        $con->query("UPDATE patients SET name = '$name', email = '$email' WHERE id = $id");
        header("Location: admin_dashboard.php");
        exit();
    }

    if (isset($_POST['edit_doctor'])) {
        $id = intval($_POST['doctor_id']);
        $name = $con->real_escape_string($_POST['name']);
        $spec = $con->real_escape_string($_POST['spec']);

        $con->query("UPDATE doctor SET name = '$name', spec = '$spec' WHERE id = $id");
        header("Location: admin_dashboard.php");
        exit();
    }
}

$patients = getPatients($con);
$doctors = getDoctors($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}
/*  Section Headings */
.section-heading {
  font-size: 24px;
  font-weight: bold;
  color:rgb(13, 0, 255); 
  background: linear-gradient(to right, #e3f2fd, #bbdefb); 
  padding: 12px 20px;
  border-radius: 8px;
  text-align: center;
  margin-bottom: 20px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
body {
  background-color: #f4f7fc;
  color: #333;
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}
.page-header {
  background: linear-gradient(135deg, #007bff, #00d4ff);
  color: white;
  text-align: center;
  padding: 20px;
  font-size: 26px;
  font-weight: bold;
  position: relative;
}
.logout-button {
  position: absolute;
  top: 15px;
  right: 20px;
  text-decoration: none;
  padding: 8px 15px;
  background-color: darkblue;
  color: white;
  border-radius: 5px;
  font-size: 14px;
  transition: background 0.3s ease;
}
.logout-button:hover {
  background-color: steelblue;
}
.container {
  display: flex;
  flex: 1;
}
.sidebar {
  width: 260px;
  background: #2c3e50;
  color: white;
  padding: 20px;
  min-height: 100vh;
  position: fixed;
}
.sidebar ul {
  list-style: none;
  padding-left: 0;
}
.sidebar ul li {
  margin: 15px 0;
}
.sidebar ul li a {
  display: block;
  text-decoration: none;
  color: white;
  font-size: 18px;
  padding: 12px 15px;
  border-radius: 6px;
  transition: all 0.3s ease-in-out;
}
.sidebar ul li a:hover {
  background: #34495e;
  padding-left: 18px;
}
.main-content {
  margin-left: 260px;
  flex: 1;
  padding: 30px;
}
.tab-content {
  display: none;
  background: white;
  padding: 25px;
  border-radius: 10px;
  box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
}
.tab-content.active {
  display: block;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
  background: white;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}
th, td {
  border: 1px solid #ddd;
  padding: 12px;
  text-align: left;
}
th {
  background: #007bff;
  color: white;
  font-weight: 600;
}
tr:nth-child(even) {
  background-color: #f9f9f9;
}
tr:hover {
  background-color: #f1f1f1;
}
button {
  background-color:rgb(40, 53, 167);
  color: white;
  padding: 8px 12px;
  border: none;
  cursor: pointer;
  border-radius: 5px;
  transition: background 0.3s ease-in-out;
}
button:hover {
  background-color:rgb(33, 52, 136);
}
form {
  display: flex;
  align-items: center;
  gap: 10px;
}
input[type="text"], input[type="email"] {
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 14px;
  width: 200px;
}
.action-buttons {
  display: flex;
  align-items: center;
  gap: 10px; 
}
.action-buttons form {
  display: flex;
  align-items: center;
  gap: 5px; 
}
.action-buttons input[type="text"],
.action-buttons input[type="email"] {
  width: 190px; 
  padding: 6px;
}

.action-buttons button {
  padding: 6px 10px;
  font-size: 12px;
}
@media (max-width: 768px) {
  .action-buttons {
    flex-direction: column;
    align-items: flex-start;
  }
  .action-buttons form {
    flex-direction: column;
    align-items: flex-start;
    width: 100%;
  }
  .action-buttons input[type="text"],
  .action-buttons input[type="email"] {
    width: 100%;
  }
}   
  </style>
</head>
<body>

  <header class="page-header">
    <h1>Admin Dashboard</h1>
    <a href="home.php" class="logout-button">Logout</a>
  </header>

  <div class="container">
    <nav class="sidebar">
      <ul>
        <li><a href="#" class="tab-link" onclick="openTab('patient')">Objects</a></li>
        <li><a href="#" class="tab-link" onclick="openTab('doctor')">Doctors</a></li>
      </ul>
    </nav>
    <div class="main-content">
      <div id="patient" class="tab-content active">
      <h2 class="section-heading">Object Details</h2>
      <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($patients as $patient) : ?>
              <tr>
                <td><?= htmlspecialchars($patient['id']) ?></td>
                <td><?= htmlspecialchars($patient['name']) ?></td>
                <td><?= htmlspecialchars($patient['email']) ?></td>
                <td class="action-buttons">
                  <form method="POST">
                    <input type="hidden" name="delete_patient" value="<?= $patient['id'] ?>">
                    <button type="submit">Delete</button>
                  </form>
                  <form method="POST">
                    <input type="hidden" name="patient_id" value="<?= $patient['id'] ?>">
                    <input type="text" name="name" value="<?= htmlspecialchars($patient['name']) ?>" required>
                    <input type="email" name="email" value="<?= htmlspecialchars($patient['email']) ?>" required>
                    <button type="submit" name="edit_patient">Edit</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div id="doctor" class="tab-content">
      <h2 class="section-heading">Doctor Details</h2>
      <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Specialization</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($doctors as $doctor) : ?>
              <tr>
                <td><?= htmlspecialchars($doctor['id']) ?></td>
                <td><?= htmlspecialchars($doctor['name']) ?></td>
                <td><?= htmlspecialchars($doctor['spec']) ?></td>
                <td class="action-buttons">
                  <form method="POST">
                    <input type="hidden" name="delete_doctor" value="<?= $doctor['id'] ?>">
                    <button type="submit">Delete</button>
                  </form>
                  <form method="POST">
                    <input type="hidden" name="doctor_id" value="<?= $doctor['id'] ?>">
                    <input type="text" name="name" value="<?= htmlspecialchars($doctor['name']) ?>" required>
                    <input type="text" name="spec" value="<?= htmlspecialchars($doctor['spec']) ?>" required>
                    <button type="submit" name="edit_doctor">Edit</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
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
