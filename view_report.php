<?php
include('db_connect.php');

if (isset($_GET['id'])) {
    $report_id = $_GET['id'];

    $sql = "SELECT report_file FROM medical_reports WHERE id = $report_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $file_path = $row['report_file'];

        // عرض التقرير
        header("Content-type: application/pdf");
        readfile($file_path);
        exit();
    } else {
        echo "Report not found.";
    }
}
?>
