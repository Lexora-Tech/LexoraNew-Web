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
        $error = "Invalid credentials. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head><base href="https://lexoratech.com/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal | Lexora Tech</title>
    <link rel="shortcut icon" type="image/x-icon" href="../img/logo/logo.png" />
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* --- RESET & VARIABLES --- */
        :root {
            --primary: #ffb400;
            --primary-hover: #e6a200;
            --glass-bg: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.08);
            --glass-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
            --text-main: #ffffff;
            --text-muted: #94a3b8;
            --error-bg: rgba(239, 68, 68, 0.2);
            --error-text: #fca5a5;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }

        body {
            min-height: 100vh;
            width: 100%;
            background-color: #050505;
            background-image: 
                radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), 
                radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(339,49%,30%,1) 0, transparent 50%);
            color: var(--text-main);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* --- ANIMATED BACKGROUND ORBS --- */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: 0;
            animation: float 10s infinite ease-in-out;
        }
        .orb-1 { width: 400px; height: 400px; background: rgba(255, 180, 0, 0.15); top: -100px; left: -100px; animation-delay: 0s; }
        .orb-2 { width: 500px; height: 500px; background: rgba(37, 99, 235, 0.15); bottom: -150px; right: -100px; animation-delay: -2s; }
        .orb-3 { width: 300px; height: 300px; background: rgba(139, 92, 246, 0.1); top: 40%; left: 40%; animation-delay: -4s; }

        @keyframes float {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(30px, 50px); }
        }

        /* --- GLASS CARD CONTAINER --- */
        .glass-container {
            position: relative;
            z-index: 10;
            display: flex;
            width: 90%;
            max-width: 1000px;
            height: 600px;
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            box-shadow: var(--glass-shadow);
            overflow: hidden;
        }

        /* --- LEFT SIDE (VISUAL) --- */
        .visual-side {
            flex: 1;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: linear-gradient(135deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0) 100%);
            border-right: 1px solid var(--glass-border);
            position: relative;
        }

        .visual-content h1 {
            font-size: 3rem;
            font-weight: 700;
            background: linear-gradient(to right, #fff, #cbd5e1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 20px;
            line-height: 1.1;
        }
        
        .visual-content p {
            color: var(--text-muted);
            font-size: 1.1rem;
            line-height: 1.6;
            max-width: 90%;
        }

        .glass-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: rgba(255, 180, 0, 0.15);
            border: 1px solid rgba(255, 180, 0, 0.3);
            border-radius: 50px;
            color: var(--primary);
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 25px;
            width: fit-content;
        }

        /* --- RIGHT SIDE (LOGIN) --- */
        .login-side {
            flex: 1;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .login-header { margin-bottom: 40px; }
        .login-header h2 { font-size: 2rem; font-weight: 600; color: #fff; margin-bottom: 10px; }
        .login-header p { color: var(--text-muted); }

        /* Form Styling */
        .form-group { margin-bottom: 24px; }
        .form-label { display: block; color: var(--text-muted); font-size: 0.9rem; margin-bottom: 8px; margin-left: 4px; }
        
        .input-group { position: relative; }
        
        .input-field {
            width: 100%;
            padding: 16px 16px 16px 50px;
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            color: #fff;
            font-size: 1rem;
            transition: 0.3s ease;
            outline: none;
        }

        .input-field:focus {
            border-color: var(--primary);
            background: rgba(0, 0, 0, 0.4);
            box-shadow: 0 0 0 4px rgba(255, 180, 0, 0.1);
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            transition: 0.3s;
            font-size: 1.1rem;
        }
        
        .input-field:focus + .input-icon { color: var(--primary); }

        /* Button */
        .btn-submit {
            width: 100%;
            padding: 16px;
            background: var(--primary);
            color: #000;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 20px rgba(255, 180, 0, 0.2);
        }

        .btn-submit:hover {
            background: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.2);
        }

        /* Error & Links */
        .error-msg {
            background: var(--error-bg);
            color: var(--error-text);
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 0.9rem;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .back-home {
            text-align: center;
            margin-top: 25px;
            display: block;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            transition: 0.3s;
        }
        .back-home:hover { color: #fff; }

        /* --- RESPONSIVE --- */
        @media (max-width: 900px) {
            .glass-container { flex-direction: column; height: auto; width: 95%; }
            .visual-side { display: none; }
            .login-side { padding: 40px 30px; }
        }
    </style>
</head>

<body>

    <!-- Background Orbs -->
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <div class="glass-container">
        
        <!-- Left Side: Brand Visuals -->
        <div class="visual-side">
            <div class="visual-content">
                <div class="glass-badge">
                    <i class="fas fa-shield-alt"></i> Admin Portal
                </div>
                <img src="../img/logo/logoWhite.png" alt="Lexora" style="height: 100px; margin-bottom: 30px; opacity: 0.9;">
                 <h1>Administration Center</h1>
                <p>Experience Unparalleled Control Over Your Complex Digital Ecosystem Through Our Robust, Enterprise-Grade, And Fully Secure Administrative Interface.</p>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="login-side">
            <div class="login-header">
                <h2>Welcome Back</h2>
                <p>Please Enter Your Details To Sign In</p>
            </div>

            <?php if (isset($error)): ?>
                <div class="error-msg">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label class="form-label">Username</label>
                    <div class="input-group">
                        <input type="text" name="username" class="input-field" placeholder="Enter username" required autocomplete="off">
                        <i class="fas fa-user input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" class="input-field" placeholder="Enter password" required>
                        <i class="fas fa-lock-open input-icon"></i>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    Sign In <i class="fas fa-arrow-right"></i>
                </button>

                <a href="../index.php" class="back-home">
                    Return To Website
                </a>
            </form>
        </div>

    </div>

</body>
</html>