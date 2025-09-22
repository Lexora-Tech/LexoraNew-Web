<?php
session_start();
include("../includes/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM admins WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['admin'] = $username;
        header("Location: dashboard.php");
    } else {
        $error = "Invalid login!";
    }
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashedPassword);

    if ($stmt->execute()) {
        echo "Signup successful. <a href='login.php'>Login here</a>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head><title>Admin Login</title></head>
<body>
    <h2>Admin Login</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Login</button>
    </form>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <h2>Admin Signup</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Enter username" required><br><br>
        <input type="password" name="password" placeholder="Enter password" required><br><br>
        <button type="submit">Signup</button>
    </form>
</body>
</html>
