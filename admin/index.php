<?php
session_start();
include("../includes/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $username = $_POST['username'];
    $password = md5($_POST['password']);


/*     $sql = "SELECT * FROM admins WHERE username='$username' AND password='$password'";

    // ADD THIS TEMPORARILY:
    echo "Type Username: " . $username . "<br>";
    echo "Hashed Password: " . $password . "<br>";
    echo "Running SQL: " . $sql;
    exit(); */

    $sql = "SELECT * FROM admins WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['admin'] = $username;
        header("Location: ./dashboard.php");
        exit();
    } else {
        $error = "Invalid Credentials. Access Denied.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal | Lexora Tech</title>
    <link rel="shortcut icon" type="image/x-icon" href="../img/logo/logo.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* --- Core Reset --- */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }

        body {
            background-color: #0b0b0b;
            background-image:
                radial-gradient(circle at 50% 0%, #1e1e1e 0%, transparent 70%),
                radial-gradient(circle at 80% 80%, rgba(255, 180, 0, 0.05) 0%, transparent 50%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            overflow: hidden;
        }

        /* --- Login Card --- */
        .login-wrapper {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .login-container {
            background: rgba(20, 20, 20, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 3rem 2.5rem;
            border-radius: 16px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
            text-align: center;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            animation: slideUp 0.8s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* --- Logo Area --- */
        .logo-area {
            margin-bottom: 30px;
        }

        .logo-area img {
            height: 50px;
            /* Adjust based on your logo aspect ratio */
            width: auto;
            margin-bottom: 15px;
        }

        .login-container h2 {
            font-size: 20px;
            font-weight: 500;
            color: #fff;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .login-subtitle {
            font-size: 13px;
            color: #666;
            margin-bottom: 40px;
        }

        /* --- Form Elements --- */
        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .input-group {
            position: relative;
        }

        .input-group i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            transition: 0.3s;
            font-size: 14px;
        }

        form input {
            width: 100%;
            padding: 16px 16px 16px 45px;
            /* Left padding for icon */
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            color: #fff;
            font-size: 15px;
            outline: none;
            transition: all 0.3s ease;
        }

        /* Focus Effects */
        form input:focus {
            background: rgba(255, 255, 255, 0.05);
            border-color: #ffb400;
            /* Gold Accent */
            box-shadow: 0 0 0 4px rgba(255, 180, 0, 0.1);
        }

        form input:focus+i {
            color: #ffb400;
        }

        form input::placeholder {
            color: #444;
        }

        /* --- Button --- */
        form button {
            background: #ffb400;
            /* Gold */
            color: #000;
            border: none;
            padding: 16px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            box-shadow: 0 4px 15px rgba(255, 180, 0, 0.2);
        }

        form button:hover {
            background: #e5a300;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 180, 0, 0.3);
        }

        /* --- Error Message --- */
        .error-box {
            background: rgba(220, 38, 38, 0.1);
            border: 1px solid rgba(220, 38, 38, 0.3);
            color: #ff6b6b;
            padding: 12px;
            border-radius: 6px;
            font-size: 13px;
            margin-top: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        /* --- Footer --- */
        .footer-text {
            margin-top: 30px;
            font-size: 12px;
            color: #444;
        }

        .footer-text a {
            color: #666;
            text-decoration: none;
            transition: 0.3s;
        }

        .footer-text a:hover {
            color: #ffb400;
        }
    </style>
</head>

<body>

    <div class="login-wrapper">
        <div class="login-container">

            <div class="logo-area">
                <img src="../img/logo/logo.png" alt="Lexora Tech Logo">
                <h2>Admin Portal</h2>
                <div class="login-subtitle">Secure Access Required</div>
            </div>

            <form method="POST">

                <div class="input-group">
                    <input type="text" name="username" placeholder="Username" required autocomplete="off">
                    <i class="fas fa-user"></i>
                </div>

                <div class="input-group">
                    <input type="password" name="password" placeholder="Password" required>
                    <i class="fas fa-lock"></i>
                </div>

                <button type="submit">
                    Sign In <i class="fas fa-arrow-right" style="margin-left: 8px;"></i>
                </button>
            </form>

            <?php if (isset($error)): ?>
                <div class="error-box">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <div class="footer-text">
                &copy; <?php echo date("Y"); ?> Lexora Tech (Pvt) Ltd<br>
                <a href="../index.php">Return To Website</a>
            </div>

        </div>
    </div>

</body>

</html>