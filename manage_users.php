<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include('db_connect.php');

// جلب المستخدمين
$sql = "SELECT id, name, email, role FROM users";
$users = $conn->query($sql);

// حذف مستخدم
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_user_id'])) {
    $user_id = $_POST['delete_user_id'];
    $sql = "DELETE FROM users WHERE id = $user_id";

    if ($conn->query($sql) === TRUE) {
        echo "User deleted successfully!";
        header("Refresh: 0");
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
    <title>Manage Users</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Manage Users</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $users->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['role']; ?></td>
                <td>
                    <form action="" method="POST">
                        <input type="hidden" name="delete_user_id" value="<?php echo $row['id']; ?>">
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
