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
    $lab_result = $_POST['lab_result'];
    $result_date = date("Y-m-d");

    // إضافة نتيجة المختبر
    $sql = "INSERT INTO lab_results (patient_id, result, result_date) 
            VALUES ($patient_id, '$lab_result', '$result_date')";

    if ($conn->query($sql) === TRUE) {
        echo "Lab result added successfully!";
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
    <title>Update Lab Results</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Add Lab Results</h2>
    <form action="" method="POST">
        <label for="patient">Choose Patient:</label>
        <select name="patient_id" id="patient" required>
            <?php while ($row = $patients->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>">
                    <?php echo $row['name']; ?>
                </option>
            <?php endwhile; ?>
        </select><br>

        <label for="lab_result">Lab Result:</label>
        <textarea name="lab_result" id="lab_result" required></textarea><br>

        <button type="submit">Add Result</button>
    </form>
</body>
</html>
