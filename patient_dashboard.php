<?php
session_start();
require 'db.php'; // Ensure database connection is included

$patient_id = $_SESSION['id'];
$query = "SELECT * FROM patients WHERE id = '$patient_id' LIMIT 1";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $patient_data = mysqli_fetch_assoc($result);
} else {
    echo "<script>alert('Patient not found.'); window.location.href = 'patient_login.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Identify which form is submitted
    $formType = $_POST['form_type'] ?? '';

    // Process BDI Quiz
    if ($formType === 'bdi') {
        $score = 0;
        for ($i = 1; $i <= 21; $i++) {
            if (isset($_POST['q' . $i])) {
                $score += (int)$_POST['q' . $i];
            }
        }

        function getDepressionLevel($score) {
            if ($score >= 1 && $score <= 10) return "These ups and downs are considered normal";
            if ($score >= 11 && $score <= 16) return "Mild mood disturbance";
            if ($score >= 17 && $score <= 20) return "Borderline clinical depression";
            if ($score >= 21 && $score <= 30) return "Moderate depression";
            if ($score >= 31 && $score <= 40) return "Severe depression";
            return "Extreme depression";
        }

        $depressionLevel = getDepressionLevel($score);

        // Update BDI score
        $updateQuery = "UPDATE patients SET bdiScore = ? WHERE id = ?";
        $stmt = mysqli_prepare($con, $updateQuery);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'ii', $score, $patient_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
        echo "<script>
        alert('BDI score updated successfully.\\nScore: $score\\nDepression Level: $depressionLevel');
    </script>";
    

        
    }
    
    // Process Social Anxiety Quiz
    if ($formType === 'anxiety') {
        $social_anxietyScore = 0;
        $responses = $_POST['response'] ?? [];

        foreach ($responses as $response) {
            $social_anxietyScore += (int)$response;
        }
        $anxietyResult = "";
        // Update Anxiety score only if responses exist
        if (!empty($responses)) {
            $updateQuery = "UPDATE patients SET social_anxietyScore = ? WHERE id = ?";
            $stmt = mysqli_prepare($con, $updateQuery);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'ii', $social_anxietyScore, $patient_id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                echo "<script>
        alert('Social Anxiety score updated successfully.\\nScore: $social_anxietyScore');
    </script>";
            }
        }
    }

    // Process Death Anxiety Quiz
    if ($formType === 'deathanxiety') {
      $death_anxietyScore = 0;
      $responses = $_POST['response'] ?? [];

      foreach ($responses as $response) {
          $death_anxietyScore += (int)$response;
      }
      $anxietyResultd = "";
      // Update Anxiety score only if responses exist
      if (!empty($responses)) {
          $updateQuery = "UPDATE patients SET death_anxietyScore = ? WHERE id = ?";
          $stmt = mysqli_prepare($con, $updateQuery);

          if ($stmt) {
              mysqli_stmt_bind_param($stmt, 'ii', $death_anxietyScore, $patient_id);
              mysqli_stmt_execute($stmt);
              mysqli_stmt_close($stmt);

              echo "<script>alert('Death Anxiety score updated successfully.\\nScore: $death_anxietyScore');</script>";
          }
      }
  }

  // Process Self Anxiety Quiz
  if ($formType === 'selanxiety') {
    $self_anxietyScore = 0;
    $responses = $_POST['response'] ?? [];

    foreach ($responses as $response) {
        $self_anxietyScore += (int)$response;
    }
    $anxietyResultsel = "";
    // Update Anxiety score only if responses exist
    if (!empty($responses)) {
        $updateQuery = "UPDATE patients SET self_anxietyScore = ? WHERE id = ?";
        $stmt = mysqli_prepare($con, $updateQuery);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'ii', $self_anxietyScore, $patient_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            echo "<script>alert('Self Anxiety score updated successfully.\\nScore: $self_anxietyScore');</script>";
        }
    }
}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Patient Dashboard</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: Arial, sans-serif; background-color: #f4f4f9; display: flex; flex-direction: column; height: 100vh; }
    .page-header { background-color: #3498db; color: white; padding: 20px; text-align: center; font-size: 32px; }
    .logout-button {position: absolute; top: 15px; right: 15px; text-decoration: none; padding: 6px 12px; background-color: darkblue; color: white;
            border-radius: 3px; font-family: Arial, sans-serif; }
    .logout-button:hover { background-color: steelblue;}
    .container { display: flex; width: 100%; flex: 1; }
    .sidebar { background-color: #2c3e50; color: white; width: 250px; padding: 20px; }
    .sidebar ul { list-style: none; padding-left: 0; }
    .sidebar ul li { margin-bottom: 20px; }
    .sidebar ul li a { text-decoration: none; color: white; font-size: 18px; display: block; }
    .sidebar ul li a:hover { background-color: #34495e; padding-left: 10px; }
    .main-content { flex: 1; padding: 20px; }
    h2 { font-size: 24px; margin-bottom: 10px; }
    .tab-content { display: none; background-color: white; padding: 20px; border-radius: 5px; margin-left: 20px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); }
    .tab-content.active { display: block; }
    .result { background-color: #e0f7fa; padding: 15px; border-radius: 5px; margin-top: 20px; }
/*  BDI Quiz Styling */
#bdi form { max-width: 850px; margin: 30px auto; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);padding: 20px;
    border-radius: 12px; box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15); }
#bdi h2 { font-size: 28px; color: #ffffff; background: linear-gradient(90deg, #3498db, #2980b9); padding: 15px 25px; border-radius: 10px;
    text-align: center; margin-bottom: 30px; box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);text-transform: uppercase;letter-spacing: 1px; }
#bdi ol {counter-reset: question-counter; list-style: none;padding: 0; }
#bdi ol li {
    background: white;
    border: 1px solid #e0e4e8;
    border-radius: 10px;
    padding: 25px 40px; 
    margin-bottom: 25px; 
    position: relative;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}
#bdi ol li:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    border-color: #3498db;
}
#bdi ol li:before {
    counter-increment: question-counter;
    content: "Q" counter(question-counter) ": ";
    font-weight: bold;
    color: #ffffff;
    background: #3498db;
    padding: 5px 12px;
    border-radius: 15px;
    font-size: 16px;
    position: absolute;
    left: 15px;
    top: -15px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}
#bdi label {
    display: flex;
    align-items: center;
    margin: 10px 0 10px 20px;
    color: #2c3e50;
    font-size: 16px;
    cursor: pointer;
    padding: 8px;
    border-radius: 5px;
    transition: background-color 0.2s ease;
}
#bdi label:hover {
    background-color: #eef2f7;
}
#bdi input[type="radio"] {
    margin-right: 12px;
    accent-color: #3498db;
    transform: scale(1.2);
}
#bdi input[type="radio"]:checked + span {
    font-weight: bold;
    color: #3498db;
}
#bdi button[type="submit"] {
    background: linear-gradient(90deg, #3498db, #2980b9);
    color: white;
    padding: 14px 30px;
    border: none;
    border-radius: 50px;
    font-size: 18px;
    cursor: pointer;
    display: block;
    margin: 30px auto;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(52, 152, 219, 0.4);
}
#bdi button[type="submit"]:hover {
    background: linear-gradient(90deg, #2980b9, #1b6ca8);
    transform: scale(1.05);
    box-shadow: 0 6px 20px rgba(52, 152, 219, 0.6);
}
/*  Styling for Social, Death, and Self Anxiety Quizzes */
#sanxitey form, #danxitey form, #selfanxitey form {
    max-width: 100%; 
    margin: 30px 0; 
    background: linear-gradient(to bottom, #e6f0fa, #cce4ff); 
    padding: 25px 0; 
    border-radius: 15px;
    box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
    border: 1px solid #1e90ff;
}
#sanxitey h2, #danxitey h2, #selfanxitey h2 {
    font-size: 32px;
    color: #1e90ff;
    background: transparent;
    padding: 15px 20px;
    border-left: 8px solid #1e90ff;
    border-radius: 0 10px 10px 0;
    text-align: left;
    margin: 0 0 35px 0;
    font-weight: bold;
    position: relative;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    background: linear-gradient(to right, rgba(30, 144, 255, 0.1), transparent); 
}
#sanxitey h2:before, #danxitey h2:before, #selfanxitey h2:before {
    content: '◆'; 
    color: #1e90ff;
    font-size: 24px;
    position: absolute;
    left: -25px;
    top: 50%;
    transform: translateY(-50%);
}
#sanxitey p, #danxitey p, #selfanxitey p {
    background: white;
    border-left: 6px solid #1e90ff;
    padding: 20px; 
    margin: 0 0 25px 0; 
    border-radius: 0; 
    font-size: 17px;
    color: #5d6d7e;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    width: 100%; 
    box-sizing: border-box;
    display: flex;
    flex-wrap: nowrap; 
    align-items: center;
    overflow-x: auto; 
}
#sanxitey p:hover, #danxitey p:hover, #selfanxitey p:hover {
    transform: translateX(5px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}
#sanxitey p strong, #danxitey p strong, #selfanxitey p strong {
    color: #1e90ff;
    font-weight: bold;
    font-size: 18px;
    margin-right: 5px; 
    flex-shrink: 0; 
}
#sanxitey p, #danxitey p, #selfanxitey p {
    justify-content: flex-start; 
}
#sanxitey p > *:not(strong), #danxitey p > *:not(strong), #selfanxitey p > *:not(strong) {
    margin-left: 0; 
}
#sanxitey label, #danxitey label, #selfanxitey label {
    display: inline-flex;
    align-items: center;
    margin: 8px 10px 8px 0; 
    padding: 8px 12px;
    background: #e6f0fa; 
    border-radius: 20px;
    font-size: 15px;
    color: #2c3e50;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    white-space: nowrap; 
    margin-left: auto; 
}
#sanxitey label:hover, #danxitey label:hover, #selfanxitey label:hover {
    background: #cce4ff;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}
#sanxitey input[type="radio"], #danxitey input[type="radio"], #selfanxitey input[type="radio"] {
    margin-right: 8px;
    accent-color: #1e90ff;
    transform: scale(1.1);
}
#sanxitey input[type="radio"]:checked + span, 
#danxitey input[type="radio"]:checked + span, 
#selfanxitey input[type="radio"]:checked + span {
    color: #1e90ff;
    font-weight: bold;
}
#sanxitey button[type="submit"], #danxitey button[type="submit"], #selfanxitey button[type="submit"] {
    background: linear-gradient(90deg, #1e90ff, #1873cc); /* Distinct blue gradient */
    color: white;
    padding: 12px 30px;
    border: none;
    border-radius: 30px;
    font-size: 17px;
    cursor: pointer;
    display: block;
    margin: 30px auto;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(30, 144, 255, 0.4);
}
#sanxitey button[type="submit"]:hover, #danxitey button[type="submit"]:hover, #selfanxitey button[type="submit"]:hover {
    background: linear-gradient(90deg, #1873cc, #105aa6);
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(30, 144, 255, 0.6);
}
#personal-info {
    max-width: 100%; 
    margin: 0; 
    padding: 20px; 
    background: linear-gradient(135deg, #e6f0fa 0%, #cce4ff 100%); 
    border-radius: 15px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    border: 1px solid #1e90ff;
}
#personal-info h2 {
    font-size: 28px;
    margin-bottom: 10px; 
}
#personal-info hr {
    border: none;
    height: 2px;
    background: #1e90ff;
    margin: 10px 0; 
    opacity: 0.7;
}


#personal-info .user-details {
    background: white;
    padding: 15px; 
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    transition: transform 0.3s ease;
}

#personal-info .user-details:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
}

#personal-info .user-details p {
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

#personal-info .user-details p strong {
    color: #1e90ff;
    font-weight: bold;
    margin-right: 0; 
}
#medical-records {
    max-width: 100%; 
    margin: 0; 
    padding: 30px; 
    background: linear-gradient(to bottom, #e6f0fa, #cce4ff); 
    border-radius: 15px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    border: 1px solid #1e90ff;
}
#medical-records h2 {
    font-size: 28px;
    color: white;
    background: linear-gradient(90deg, #1e90ff, #1873cc); 
    padding: 12px 20px;
    border-radius: 10px 10px 0 0;
    margin-bottom: 25px; 
    text-align: center;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 1px;
    box-shadow: 0 4px 15px rgba(30, 144, 255, 0.3);
}
#medical-records .records-container {
    background: white;
    padding: 25px; 
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

#medical-records .records-container:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}
#medical-records .record-item {
    font-size: 16px;
    color: #2c3e50;
    padding: 20px; 
    margin: 15px 0; 
    background: #f8f9fa;
    border-radius: 5px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    min-height: 80px; 
    line-height: 1.5; 
}
#medical-records .record-item strong {
    color: #1e90ff;
    font-weight: bold;
    min-width: 250px; 
}

  </style>
</head>
<body>
  <header class="page-header">
    <h1>Object Dashboard</h1>
    <p>Welcome, <?php echo $patient_data['name']; ?> Your mental well-being starts here </p>
    <a href="home.php" class="logout-button">Logout</a>
  </header>

  <div class="container">
    <nav class="sidebar">
      <ul>
        <li><a href="#" onclick="openTab('personal-info')">Personal Information</a></li>
        <li><a href="#" onclick="openTab('bdi')">BDI</a></li>
        <li><a href="#" onclick="openTab('sanxitey')"> Social Anxiety</a></li>
        <li><a href="#" onclick="openTab('danxitey')">Death Anxiety</a></li>
        <li><a href="#" onclick="openTab('selfanxitey')">Self Anxiety</a></li>
        <li><a href="#" onclick="openTab('medical-records')">Recent Medical Records</a></li>
      </ul>
    </nav>

    <div class="main-content">
      <div id="personal-info" class="tab-content">
        <h2>Personal Information</h2>
        <hr style="color: red;"> <br>
        <div class="user-details">
        <p><strong>ID:</strong> <?php  echo $patient_data['id']; ?></p>
        <p><strong>Name:</strong> <?php echo  $patient_data['name']; ?></p>
        <p><strong>Mobile:</strong> <?php echo $patient_data['mobile']; ?></p>
        <p><strong>Gender:</strong> <?php echo $patient_data['gender']; ?></p>
        <p><strong>Email:</strong> <?php   echo $patient_data['email']; ?></p>
        <p><strong>Age:</strong> <?php echo  $patient_data['age']; ?></p>
    </div>
      </div>

      <div id="bdi" class="tab-content">
        <h2>Beck Depreesion Inventory Quiz</h2>
        <form action="" method="post">
        <input type="hidden" name="form_type" value="bdi">
        <ol>
            <li>
        <label><input type="radio" name="q1" value="0" required> 0 I do not feel sad.</label><br>
                <label><input type="radio" name="q1" value="1"> 1 I feel sad.</label><br>
                <label><input type="radio" name="q1" value="2"> 2 I am sad all the time and I can't snap out of it.</label><br>
                <label><input type="radio" name="q1" value="3"> 3 I am so sad and unhappy that I can't stand it.</label>
            </li>
            <li>
                <label><input type="radio" name="q2" value="0" required> 0 I am not particularly discouraged about the future.</label><br>
                <label><input type="radio" name="q2" value="1"> 1 I feel discouraged about the future.</label><br>
                <label><input type="radio" name="q2" value="2"> 2 I feel I have nothing to look forward to.</label><br>
                <label><input type="radio" name="q2" value="3"> 3 I feel the future is hopeless and that things cannot improve.</label>
            </li>
            <li>
                <label><input type="radio" name="q3" value="0" required> 0 I do not feel like a failure.</label><br>
                <label><input type="radio" name="q3" value="1"> 1 I feel I have failed more than the average person.</label><br>
                <label><input type="radio" name="q3" value="2"> 2 As I look back on my life, all I can see is a lot of failures.</label><br>
                <label><input type="radio" name="q3" value="3"> 3 I feel I am a complete failure as a person.</label>
            </li>
            <li>
                <label><input type="radio" name="q4" value="0" required> 0 I get as much satisfaction out of things as I used to.</label><br>
                <label><input type="radio" name="q4" value="1"> 1 I don't enjoy things the way I used to.</label><br>
                <label><input type="radio" name="q4" value="2"> 2 I don't get real satisfaction out of anything anymore.</label><br>
                <label><input type="radio" name="q4" value="3"> 3 I am dissatisfied or bored with everything.</label>
            </li>
            <li>
                <label><input type="radio" name="q5" value="0" required> 0 I don't feel particularly guilty.</label><br>
                <label><input type="radio" name="q5" value="1"> 1 I feel guilty a good part of the time.</label><br>
                <label><input type="radio" name="q5" value="2"> 2 I feel quite guilty most of the time.</label><br>
                <label><input type="radio" name="q5" value="3"> 3 I feel guilty all of the time.</label>
            </li>
            <li>
                <label><input type="radio" name="q6" value="0" required> 0 I don't feel I am being punished.</label><br>
                <label><input type="radio" name="q6" value="1"> 1 I feel I may be punished.</label><br>
                <label><input type="radio" name="q6" value="2"> 2 I expect to be punished.</label><br>
                <label><input type="radio" name="q6" value="3"> 3 I feel I am being punished.</label>
            </li>
            <li>
                <label><input type="radio" name="q7" value="0" required> 0 I don't feel disappointed in myself.</label><br>
                <label><input type="radio" name="q7" value="1"> 1 I am disappointed in myself.</label><br>
                <label><input type="radio" name="q7" value="2"> 2 I am disgusted with myself.</label><br>
                <label><input type="radio" name="q7" value="3"> 3 I hate myself.</label>
            </li>
            <li>
                <label><input type="radio" name="q8" value="0" required> 0 I don't feel I am any worse than anybody else.</label><br>
                <label><input type="radio" name="q8" value="1"> 1 I am critical of myself for my weaknesses or mistakes.</label><br>
                <label><input type="radio" name="q8" value="2"> 2 I blame myself all the time for my faults.</label><br>
                <label><input type="radio" name="q8" value="3"> 3 I blame myself for everything bad that happens.</label>
            </li>
            <li>
                <label><input type="radio" name="q9" value="0" required> 0 I don't have any thoughts of killing myself.</label><br>
                <label><input type="radio" name="q9" value="1"> 1 I have thoughts of killing myself, but I would not carry them out.</label><br>
                <label><input type="radio" name="q9" value="2"> 2 I would like to kill myself.</label><br>
                <label><input type="radio" name="q9" value="3"> 3 I would kill myself if I had the chance.</label>
            </li>
            <li>
              <label><input type="radio" name="q10" value="0" required> 0 I don't cry any more than usual.</label><br>
              <label><input type="radio" name="q10" value="1"> 1 I cry more now than I used to.</label><br>
              <label><input type="radio" name="q10" value="2"> 2 I cry all the time now.</label><br>
              <label><input type="radio" name="q10" value="3"> 3 I used to be able to cry, but now I can't cry even though I want to.</label>
          </li> 
          <li>
            <label><input type="radio" name="q11" value="0" required>0 I am no more irritated by things than I ever was.</label><br>
            <label><input type="radio" name="q11" value="1"> 1 I am slightly more irritated now than usual.</label><br>
            <label><input type="radio" name="q11" value="2"> 2 I am quite annoyed or irritated a good deal of the time.</label><br>
            <label><input type="radio" name="q11" value="3"> 3 I feel irritated all the time.</label>
        </li> 
        <li>
          <label><input type="radio" name="q12" value="0" required> 0 I have not lost interest in other people.</label><br>
          <label><input type="radio" name="q12" value="1"> 1 I am less interested in other people than I used to be..</label><br>
          <label><input type="radio" name="q12" value="2">2 I have lost most of my interest in other people.</label><br>
          <label><input type="radio" name="q12" value="3"> 3 I have lost all of my interest in other people.</label>
      </li> 
      <li>
        <label><input type="radio" name="q13" value="0" required> 0 I make decisions about as well as I ever could.</label><br>
        <label><input type="radio" name="q13" value="1"> 1 I put off making decisions more than I used to.</label><br>
        <label><input type="radio" name="q13" value="2"> 2 I have greater difficulty in making decisions more than I used to.</label><br>
        <label><input type="radio" name="q13" value="3"> 3 I can't make decisions at all anymore.</label>
    </li> 
    <li>
      <label><input type="radio" name="q14" value="0" required> 0 I don't feel that I look any worse than I used to.</label><br>
      <label><input type="radio" name="q14" value="1"> 1 I am worried that I am looking old or unattractive.</label><br>
      <label><input type="radio" name="q14" value="2">2 I feel there are permanent changes in my appearance that make me look
        unattractive</label><br>
      <label><input type="radio" name="q14" value="3">3 I believe that I look ugly.</label>
  </li> 
  <li>
    <label><input type="radio" name="q15" value="0" required>0 I can work about as well as before.</label><br>
    <label><input type="radio" name="q15" value="1"> 1 It takes an extra effort to get started at doing something.</label><br>
    <label><input type="radio" name="q15" value="2"> 2 I have to push myself very hard to do anything.</label><br>
    <label><input type="radio" name="q15" value="3"> 3 I can't do any work at all.</label>
</li>
<li>
  <label><input type="radio" name="q16" value="0" required> 0 I can sleep as well as usual.</label><br>
  <label><input type="radio" name="q16" value="1"> 1 I don't sleep as well as I used to.</label><br>
  <label><input type="radio" name="q16" value="2"> 2 I wake up 1-2 hours earlier than usual and find it hard to get back to sleep.</label><br>
  <label><input type="radio" name="q16" value="3"> 3 I wake up several hours earlier than I used to and cannot get back to sleep.</label>
</li>
<li>
  <label><input type="radio" name="q17" value="0" required> 0 I don't get more tired than usual.</label><br>
  <label><input type="radio" name="q17" value="1"> 1 I get tired more easily than I used to.</label><br>
  <label><input type="radio" name="q17" value="2"> 2 I get tired from doing almost anything.</label><br>
  <label><input type="radio" name="q17" value="3"> 3 I am too tired to do anything.</label>
</li>
<li>
  <label><input type="radio" name="q18" value="0" required> 0 My appetite is no worse than usual.</label><br>
  <label><input type="radio" name="q18" value="1"> 1 My appetite is not as good as it used to be.</label><br>
  <label><input type="radio" name="q18" value="2">2 My appetite is much worse now.</label><br>
  <label><input type="radio" name="q18" value="3"> 3 I have no appetite at all anymore.</label>
</li>
<li>
  <label><input type="radio" name="q19" value="0" required>0 I haven't lost much weight, if any, lately. </label><br>
  <label><input type="radio" name="q19" value="1">1 I have lost more than five pounds.</label><br>
  <label><input type="radio" name="q19" value="2"> 2 I have lost more than ten pounds.</label><br>
  <label><input type="radio" name="q19" value="3"> 3 I have lost more than fifteen pounds.</label>
</li>
<li>
  <label><input type="radio" name="q20" value="0" required> 0 I am no more worried about my health than usual.</label><br>
  <label><input type="radio" name="q20"value="1">  I am worried about physical problems like aches, pains, upset stomach, or
    constipation.</label><br>
  <label><input type="radio" name="q20" value="2"> 2 I am very worried about physical problems and it's hard to think of much else.<label><br>
  <label><input type="radio" name="q20" value="3"> 3 I am so worried about my physical problems that I cannot think of anything else.</label>
</li>
<li>
  <label><input type="radio" name="q21" value="0" required>0 I have not noticed any recent change in my interest in sex. </label><br>
  <label><input type="radio" name="q21" value="1"> 1 I am less interested in sex than I used to be.</label><br>
  <label><input type="radio" name="q21" value="2"> 2 I have almost no interest in sex.</label><br>
  <label><input type="radio" name="q21" value="3"> 3 I have lost interest in sex completely.</label>
</li>
        </ol>
          <button type="submit">Submit</button>
        </form>
        
        <?php if (isset($depressionLevel)): ?>
    <div class="result">
      <h3>Assessment Result</h3>
      <p>Total Score: <?php echo $score; ?></p>
      <p>Depression Level: <?php echo $depressionLevel; ?></p>
    </div>
    
  <?php endif; ?>
      </div>

      <div id="sanxitey" class="tab-content">
        <h2>Social Anxiety Assessment Questionnaire</h2>
        <form method="POST" action="">
        <input type="hidden" name="form_type" value="anxiety">
          <h3>Answer the following statements:</h3>
          <!--  anxiety-related questions -->
          <?php
$statements = [
        "I feel uncomfortable in talking to a stranger.",
        "I feel embarrassed when an unknown person calls me.",
        "It often worries me that what people think about me.",
        "I feel free of all tensions with my friends.",
        "I feel embarrassed in attending social functions like marriage.",
        "I do not feel afraid of working in a group.",
        "I feel afraid of adjusting myself in a new and unfamiliar situation.",
        "I feel afraid of expressing my views in front of other persons in society.",
        "I am afraid of traveling alone in a bus.",
        "I feel afraid of expressing my views in front of my family members.",
        "I feel afraid of visiting fairs and festivals.",
        "I feel afraid of roaming in a lonely place.",
        "I feel afraid of getting lost in the crowd.",
        "I get anxious when people talk something wrong about me.",
        "I get aggressive if others do not agree with me.",
        "I feel afraid of participating in school competitions.",
        "I hesitate in getting the opinion of others for solving my problems.",
        "I feel afraid of making a speech in front of many audiences.",
        "I feel uncomfortable in taking my meals within a group.",
        "I feel frightened in those social situations in which others make a judgment of my personality.",
        "I become anxious due to the thought that others are watching my different actions like laughing, talking, etc.",
        "I feel difficulty in talking to people in a face-to-face manner.",
        "My relations with family members can get worse due to my anxious nature.",
        "I am unable to show my qualities to others due to lack of confidence in me.",
        "I feel frustrated because I am unable to meet the expectations of others.",
        "I feel ashamed because of my physical appearance and outfit.",
        "I feel uncomfortable in talking on a mobile phone in front of others.",
    ];
    
    foreach ($statements as $index => $statement) {
        echo "<p><strong>Q" . ($index + 1) . ":</strong> $statement</p>";
        
        // For reverse-scored statements
        if ($statement == "I feel free of all tensions with my friends." || $statement == "I do not feel afraid of working in a group.") {
            echo "<label><input type='radio' name='response[$index]' value='1' required> Completely True</label> ";
            echo "<label><input type='radio' name='response[$index]' value='2'> True to a Large Extent</label> ";
            echo "<label><input type='radio' name='response[$index]' value='3'> True to Some Extent</label> ";
            echo "<label><input type='radio' name='response[$index]' value='4'> False to a Large Extent</label> ";
            echo "<label><input type='radio' name='response[$index]' value='5'> Completely False</label> ";
        } else {
            // For normal statements
            echo "<label><input type='radio' name='response[$index]' value='5' required> Completely True</label> ";
            echo "<label><input type='radio' name='response[$index]' value='4'> True to a Large Extent</label> ";
            echo "<label><input type='radio' name='response[$index]' value='3'> True to Some Extent</label> ";
            echo "<label><input type='radio' name='response[$index]' value='2'> False to a Large Extent</label> ";
            echo "<label><input type='radio' name='response[$index]' value='1'> Completely False</label> ";
        }
    }
    
?>
     <br><br>
          <button type="submit">Submit</button>
          <?php if (isset($anxietyResult)): ?>
            <div class="result">
              <h3>Anxiety Assessment Result</h3>
              <p>Total Score: <?php echo $social_anxietyScore; ?></p>
            </div>
          <?php endif; ?>
        </form>
      </div>


      <div id="danxitey" class="tab-content">
        <h2>Death Anxiety Assessment Questionnaire</h2>
        <form method="POST" action="">
        <input type="hidden" name="form_type" value="deathanxiety">
          <h3>Answer the following statements:</h3>
          <!--  anxiety-related questions -->
          <?php
$statements = [
            "I am afraid of being died",
            "The idea of death does not entry my mind",
            "I feel afraid when people talk about death",
            "I get tensed when I think that time is passing very fast",
            "Iam afraid of horrible and painful death.",
            "I feel afraid of dying with heart attack.",
            "I often think that life is very short",
            "I feel embrrassed when I see a dead body",
            "I will feel uncomfortable if I have to work as a merciless person(butcher).",
            "It makes me afraid when I come to know that some relative has died suddenly.",
            "It makes me worried when I think that doctor will come to me and say that I am going to die soon.",
            "It will be very uncomfortable if I will return with the person performing the tasks of a furneal director.",
            "I get worried when I come to know about death of some person of my age.",
            "The thought of dying at an early age worries me.",
            "I am afraid of watching movies depicting massacre.",
            "I am not afraid of dying in an accident.",
            "In my nightmares, I witness that I am drowning.",
            "What will happen to me after death.This thought worries me.",
            "It makes me uncomfortable at the time of talking about death.",
            "Death is dredful and horrible truth.",
            "I feel afraid of dying withj dreadful diseases.",
            "I feel afraid of dying due to fire or burning.",
            "I get frieghtened due to nightmares related to death.",
            "At the time of going outside my home ,it makes me afraid that I will return.",
            "I am afraid of sleeping alone.",
            "I am afraid of dying during sleep.",
            "I sweat a lot due to fear when  I see a person suffering from some incurable disease.",
    ];
    foreach ($statements as $index => $statement) {
      echo "<p><strong>Q" . ($index + 1) . ":</strong> $statement</p>";
      
      // For reverse-scored statements
      if ($statement == "The idea of death does not entry my mind" || $statement == "Iam not afraid of dying in an accident.") {
          echo "<label><input type='radio' name='response[$index]' value='1' required> Completely True</label> ";
          echo "<label><input type='radio' name='response[$index]' value='2'> True to a Large Extent</label> ";
          echo "<label><input type='radio' name='response[$index]' value='3'> True to Some Extent</label> ";
          echo "<label><input type='radio' name='response[$index]' value='4'> False to a Large Extent</label> ";
          echo "<label><input type='radio' name='response[$index]' value='5'> Completely False</label> ";
      } else {
          // For normal statements
          echo "<label><input type='radio' name='response[$index]' value='5' required> Completely True</label> ";
          echo "<label><input type='radio' name='response[$index]' value='4'> True to a Large Extent</label> ";
          echo "<label><input type='radio' name='response[$index]' value='3'> True to Some Extent</label> ";
          echo "<label><input type='radio' name='response[$index]' value='2'> False to a Large Extent</label> ";
          echo "<label><input type='radio' name='response[$index]' value='1'> Completely False</label> ";
      }
  }
  
?>
   <br><br>
          <button type="submit">Submit</button>
          <?php if (isset($anxietyResultd)): ?>
            <div class="result">
              <h3>Anxiety Assessment Result</h3>
              <p>Total Score: <?php echo $death_anxietyScore; ?></p>
            </div>
          <?php endif; ?>
        </form>
  </div> 

  <div id="selfanxitey" class="tab-content">
        <h2>Self Anxiety Assessment Questionnaire</h2>
        <form method="POST" action="">
        <input type="hidden" name="form_type" value="selanxiety">
          <h3>Answer the following statements:</h3>
          <!-- anxiety-related questions  -->
          <?php
$statements = [
  "Sometimes I get frightened because of no reason.",
  "I get frustrated very easily.",
  "I start shivering when iam tensed.",
  "I got tired very soon and feel physically week.",
  "I can feel my heartbeats.",
  "I become giddy and confused due to hypertension.",
  "I am unable to breathe when I am tensed.",
  "My face gets red when Iam in tension.",
  "During sleep I witness horrible dreams(nightmare).",
  "I feel embarrassed in the crowd.",
  "I get afraid when I think someone will be hurt by me.",
  "I feel embarrassed when barbed remarks(sarcism) take between me and my classmates.",
  "I feel worried regarding my carrier.",
  "I frequently think over those events which create tension in my life.",
  "My mouth gets dried at the time of the tension.",
  "I start thinking continuosly when someone clicked my photograph.",
  "I get affraid of being trapped in the traffic jam.",
  "I am involved in thinking about those things which  I have never attained in my life.",
  " I cannot sleep well due to worries and tension.",
  "I think about irrelavant things and issues.",
  "I feel that everything is all right nothing wrong in my life.",
  "I face difficulty in remembering different facts.",
  "I feel worried about my physical health.",
  "Often Iam involved in thinking about a problem for a long time and still I feel that this problem could not be solved.",
  "My hands start sweating when I am worried.",
  "I do not like to depend on others.",
];
    
foreach ($statements as $index => $statement) {
    echo "<p><strong>Q" . ($index + 1) . ":</strong> $statement</p>";
    
    // For reverse-scored statements
    if ($statement == "I do not like to depend on others."|| $statement == "I feel that everything is all right nothing wrong in my life.") {
        echo "<label><input type='radio' name='response[$index]' value='1' required> Completely True</label> ";
        echo "<label><input type='radio' name='response[$index]' value='2'> True to a Large Extent</label> ";
        echo "<label><input type='radio' name='response[$index]' value='3'> True to Some Extent</label> ";
        echo "<label><input type='radio' name='response[$index]' value='4'> False to a Large Extent</label> ";
        echo "<label><input type='radio' name='response[$index]' value='5'> Completely False</label> ";
    } else {
        // For normal statements
        echo "<label><input type='radio' name='response[$index]' value='5' required> Completely True</label> ";
        echo "<label><input type='radio' name='response[$index]' value='4'> True to a Large Extent</label> ";
        echo "<label><input type='radio' name='response[$index]' value='3'> True to Some Extent</label> ";
        echo "<label><input type='radio' name='response[$index]' value='2'> False to a Large Extent</label> ";
        echo "<label><input type='radio' name='response[$index]' value='1'> Completely False</label> ";
    }
}
?>
   <br><br>
          <button type="submit">Submit</button>
          <?php if (isset($anxietyResultsel)): ?>
            <div class="result">
              <h3>Anxiety Assessment Result</h3>
              <p>Total Score: <?php echo $self_anxietyScore; ?></p>
            </div>
          <?php endif; ?>
        </form>
  </div> 


      <div id="medical-records" class="tab-content">
        <h2>Recent Medical Records</h2><br>
        <h3>Social Anxiety Assessment Result</h3>
              <p>Total Score: <?php echo $patient_data['social_anxietyScore']; ?></p>
              <p>Doctor's Report on social anxiety: <strong><?php echo $patient_data['social_report']; ?></strong></p><br>
        <h3>Death Anxiety Assessment Result</h3>
              <p>Total Score: <?php echo $patient_data['death_anxietyScore']; ?></p>
              <p>Doctor's Report on death anxiety: <strong><?php echo $patient_data['death_report']; ?></strong></p><br>
        <h3>Self Anxiety Assessment Result</h3>
              <p>Total Score: <?php echo $patient_data['self_anxietyscore']; ?></p>
              <p>Doctor's Report on self anxiety: <strong><?php echo $patient_data['self_report']; ?></strong></p><br>
      
  </div>

  <script>
    function openTab(tabId) {
      document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
      document.getElementById(tabId).classList.add('active');
    }
    window.onload = function() { openTab('personal-info'); };
  </script>

</body>
</html>
