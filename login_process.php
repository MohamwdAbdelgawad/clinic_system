<?php
include('db_connect.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // تحقق من وجود المستخدم
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // تحقق من كلمة المرور
        if (password_verify($password, $row['password'])) {
            // تحديث وقت آخر تسجيل دخول
            $last_login = date("Y-m-d H:i:s");
            $update_sql = "UPDATE users SET last_login = '$last_login' WHERE email = '$email'";
            $conn->query($update_sql);

            // تخزين بيانات المستخدم في الجلسة
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['name'] = $row['name'];

            // إعادة التوجيه بناءً على دور المستخدم
            switch ($row['role']) {
                case 'doctor':
                    header("Location: doctor_dashboard.php");
                    break;
                case 'patient':
                    header("Location: patient_dashboard.php");
                    break;
                case 'nurse':
                    header("Location: nurse_dashboard.php");
                    break;
                case 'admin':
                    header("Location: admin_dashboard.php");
                    break;
            }
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with this email.";
    }
}

$conn->close();
?>
