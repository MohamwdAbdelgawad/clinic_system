<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'patient') {
    header("Location: login.php");
    exit();
}

include('db_connect.php');

$user_id = $_SESSION['user_id'];

// جلب بيانات المستخدم
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // تحديث البيانات الشخصية
    $name = $_POST['name'];
    $age = $_POST['age'];
    $mobile_number = $_POST['mobile'];
    $profile_picture = $_FILES['profile_picture']['name'];

    // حفظ الصورة
    if (!empty($profile_picture)) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($profile_picture);
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file);
        $sql = "UPDATE users SET name='$name', age=$age, mobile_number='$mobile_number', profile_picture='$target_file' WHERE id=$user_id";
    } else {
        $sql = "UPDATE users SET name='$name', age=$age, mobile_number='$mobile_number' WHERE id=$user_id";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Profile updated successfully!";
    } else {
        echo "Error updating profile: " . $conn->error;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Profile</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Patient Profile</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for=""><img src='<?php echo $user['profile_picture']; ?>' alt='User Profile Image' width="300" height="200">   </label><br>

        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo $user['name']; ?>" required><br>

        <label for="age">Age:</label>
        <input type="number" name="age" value="<?php echo $user['age']; ?>" required><br>

        <label for="mobile">Mobile:</label>
        <input type="text" name="mobile" value="<?php echo $user['mobile_number']; ?>" required><br>

        <label for="profile_picture">Profile Picture:</label>
        <input type="file" name="profile_picture"><br>

        <button type="submit">Update Profile</button>
    </form>
</body>
</html>
