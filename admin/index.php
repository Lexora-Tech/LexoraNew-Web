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
        header("Location: ./dashboard.php");
        exit();
    } else {
        $error = "Invalid Login! Please Try Again";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Lexora Tech</title>
    <link rel="shortcut icon" type="image/x-icon" href="../img/logo/logo.png" />
    <style>
        /* Reset for consistency */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(-45deg, #0f172a, #1e293b, #334155, #1e3a8a);
            background-size: 400% 400%;
            animation: gradientMove 12s ease infinite;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #e2e8f0;
        }

        @keyframes gradientMove {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .login-container {
            background: rgba(30, 41, 59, 0.9);
            padding: 2rem;
            border-radius: 14px;
            box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 360px;
            text-align: center;
            backdrop-filter: blur(10px);
            animation: fadeIn 1.2s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-container h2 {
            margin-bottom: 1.5rem;
            color: #f8fafc;
            font-weight: 600;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        form input,
        form button {
            width: 100%;
            padding: 12px;
            margin-bottom: 1rem;
            border-radius: 8px;
            font-size: 15px;
        }

        form input {
            border: 1px solid #475569;
            background: #1e293b;
            color: #f1f5f9;
            outline: none;
            transition: border 0.3s;
        }

        form input:focus {
            border: 1px solid #3b82f6;
        }

        form button {
            background: #2563eb;
            color: #fff;
            border: none;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
        }

        form button:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
        }

        .error {
            color: #f87171;
            margin-top: 0.5rem;
            font-size: 14px;
        }

        .footer-text {
            margin-top: 1rem;
            font-size: 13px;
            color: #94a3b8;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Enter Username" required>
            <input type="password" name="password" placeholder="Enter Password" required>
            <button type="submit">Login</button>
        </form>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <p class="footer-text">© <?php echo date("Y"); ?> Lexora Tech(Pvt)Ltd</p>
    </div>
</body>

</html>