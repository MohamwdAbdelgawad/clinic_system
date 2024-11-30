<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'nurse') {
    header("Location: login.php");
    exit();
}

include('db_connect.php');

// جلب قائمة المرضى
$sql = "SELECT id, name FROM users WHERE role = 'patient'";
$patients = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_id = $_POST['patient_id'];
    $report_name = $_POST['report_name'];
    $report_content = $_POST['report_content'];
    
    // Insert new report into database
    $sql = "INSERT INTO medical_reports (patient_id, report_name, report_content, report_date) VALUES ($patient_id, '$report_name', '$report_content', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "Report created successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Patient Report</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Create Patient Report</h2>
    <form action="" method="POST">
        <label for="patient">Choose Patient:</label>
        <select name="patient_id" id="patient" required>
            <?php while ($row = $patients->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>">
                    <?php echo $row['name']; ?>
                </option>
            <?php endwhile; ?>
        </select><br>

        <label for="report_name">Report Name:</label>
        <input type="text" name="report_name" id="report_name" required><br>

        <label for="report_content">Report Content:</label>
        <textarea name="report_content" id="report_content" required></textarea><br>

        <button type="submit">Create Report</button>
    </form>
</body>
</html>
