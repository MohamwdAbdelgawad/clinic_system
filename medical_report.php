<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'patient') {
    header("Location: login.php");
    exit();
}

include('db_connect.php');

$user_id = $_SESSION['user_id'];

// جلب التقارير الطبية
$sql = "SELECT * FROM medical_reports WHERE patient_id = $user_id";
$reports = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Reports</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Your Medical Reports</h2>
    <ul>
        <?php while ($row = $reports->fetch_assoc()): ?>
            <li>
                <a href="#" onclick="toggleMessage()" >
                    <?php echo $row['report_name']; ?> - <?php echo $row['report_date']; ?>
                </a>
                <div id="message"><?php echo $row['report_content']; ?></div>
            </li>
        <?php endwhile; ?>
    </ul>
</body>
<script>
 function toggleMessage() { 
    var messageDiv = document.getElementById("message");
     var toggleLink = document.getElementById("toggleLink");
      if (messageDiv.style.display === "none") 
      { messageDiv.style.display = "block"; toggleLink.textContent = "Hide Message"; }
       else { messageDiv.style.display = "none"; toggleLink.textContent = "Show Message"; }
        }
</script>
</html>
