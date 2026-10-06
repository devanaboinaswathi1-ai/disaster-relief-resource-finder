<?php
session_start();

// Simple hardcoded credentials (in production, use hashed passwords in DB)
define('ADMIN_USER', 'admin');
define('ADMIN_PASS', 'admin123'); // Change this!

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($username === ADMIN_USER && $password === ADMIN_PASS) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Invalid credentials';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Disaster Relief</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            display: flex;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
        }

        /* Animated Background */
        .bg-animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .bg-animation span {
            position: absolute;
            display: block;
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.1);
            animation: move 25s infinite linear;
            bottom: -150px;
            border-radius: 50%;
        }

        .bg-animation span:nth-child(1) {
            left: 25%;
            width: 80px;
            height: 80px;
            animation-delay: 0s;
            animation-duration: 20s;
        }

        .bg-animation span:nth-child(2) {
            left: 10%;
            width: 20px;
            height: 20px;
            animation-delay: 2s;
            animation-duration: 15s;
        }

        .bg-animation span:nth-child(3) {
            left: 70%;
            width: 40px;
            height: 40px;
            animation-delay: 4s;
        }

        .bg-animation span:nth-child(4) {
            left: 40%;
            width: 60px;
            height: 60px;
            animation-delay: 0s;
            animation-duration: 18s;
        }

        .bg-animation span:nth-child(5) {
            left: 65%;
            width: 20px;
            height: 20px;
            animation-delay: 0s;
        }

        .bg-animation span:nth-child(6) {
            left: 75%;
            width: 110px;
            height: 110px;
            animation-delay: 3s;
        }

        .bg-animation span:nth-child(7) {
            left: 35%;
            width: 150px;
            height: 150px;
            animation-delay: 7s;
        }

        .bg-animation span:nth-child(8) {
            left: 50%;
            width: 25px;
            height: 25px;
            animation-delay: 15s;
            animation-duration: 45s;
        }

        .bg-animation span:nth-child(9) {
            left: 20%;
            width: 15px;
            height: 15px;
            animation-delay: 2s;
            animation-duration: 35s;
        }

        .bg-animation span:nth-child(10) {
            left: 85%;
            width: 150px;
            height: 150px;
            animation-delay: 0s;
            animation-duration: 11s;
        }

        @keyframes move {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(-1000px) rotate(720deg);
                opacity: 0;
            }
        }

        .container {
            display: flex;
            width: 100%;
            max-width: 1400px;
            margin: auto;
            position: relative;
            z-index: 1;
            padding: 2rem;
            gap: 2rem;
        }

        .login-sidebar {
            flex: 1;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 30px;
            padding: 4rem 3rem;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: slideInLeft 0.8s ease-out;
            position: relative;
            overflow: hidden;
        }

        .login-sidebar::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .sidebar-content {
            position: relative;
            z-index: 1;
        }

        .login-sidebar .icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
            font-size: 2.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .login-sidebar h1 {
            font-size: 3rem;
            margin-bottom: 1.5rem;
            font-weight: 800;
            background: linear-gradient(to right, #fff, #f0f0f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.2;
        }

        .login-sidebar p {
            font-size: 1.2rem;
            opacity: 0.95;
            line-height: 1.8;
            font-weight: 300;
            letter-spacing: 0.3px;
        }

        .features {
            margin-top: 3rem;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(10px);
        }

        .feature-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .login-form-container {
            width: 100%;
            max-width: 550px;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: slideInRight 0.8s ease-out;
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .login-form {
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            padding: 3.5rem 3rem;
            border-radius: 30px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .form-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .form-header .lock-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            animation: bounceIn 0.6s ease-out;
        }

        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.3);
            }
            50% {
                opacity: 1;
                transform: scale(1.05);
            }
            70% { transform: scale(0.9); }
            100% { transform: scale(1); }
        }

        .login-form h2 {
            color: #1a1a2e;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .login-form .subtitle {
            color: #6c757d;
            font-size: 0.95rem;
            font-weight: 400;
        }

        .form-group {
            margin-bottom: 1.8rem;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.7rem;
            color: #1a1a2e;
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1.2rem;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .form-control {
            width: 100%;
            padding: 1rem 1rem 1rem 3.5rem;
            border: 2px solid #e8ecef;
            border-radius: 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
            font-weight: 500;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        .form-control:focus + .input-icon {
            color: #764ba2;
            transform: translateY(-50%) scale(1.1);
        }

        .btn-login {
            width: 100%;
            padding: 1.1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 15px;
            font-size: 1.05rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.4s ease;
            margin-top: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.5);
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        .error {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
            color: white;
            padding: 1rem 1.2rem;
            border-radius: 15px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            font-weight: 500;
            box-shadow: 0 5px 20px rgba(255, 107, 107, 0.3);
            animation: shake 0.5s ease-in-out;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .error::before {
            content: '⚠️';
            font-size: 1.2rem;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        .hint {
            text-align: center;
            margin-top: 2rem;
            padding: 1rem;
            background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
            border-radius: 12px;
            border-left: 4px solid #667eea;
        }

        .hint-title {
            color: #667eea;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.4rem;
        }

        .hint-content {
            color: #6c757d;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 2rem 0 1.5rem;
            color: #adb5bd;
            font-size: 0.85rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(to right, transparent, #dee2e6, transparent);
        }

        .divider span {
            padding: 0 1rem;
            font-weight: 500;
        }

        @media (max-width: 1200px) {
            .container {
                flex-direction: column;
                max-width: 600px;
            }

            .login-sidebar {
                text-align: center;
            }

            .login-sidebar .icon {
                margin: 0 auto 2rem;
            }

            .features {
                margin-top: 2rem;
            }

            .feature-item:hover {
                transform: translateY(-5px);
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .login-sidebar {
                padding: 2.5rem 2rem;
                border-radius: 20px;
            }

            .login-sidebar h1 {
                font-size: 2rem;
            }

            .login-sidebar p {
                font-size: 1rem;
            }

            .login-form {
                padding: 2.5rem 2rem;
                border-radius: 20px;
            }

            .login-form h2 {
                font-size: 1.6rem;
            }

            .features {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="bg-animation">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>

    <div class="container">
        <div class="login-sidebar">
            <div class="sidebar-content">
                <div class="icon">🛡️</div>
                <h1>Welcome Back</h1>
                <p>Access your admin dashboard to manage disaster relief efforts and resources effectively. Monitor operations in real-time and coordinate relief activities.</p>
                
                <div class="features">
                    <div class="feature-item">
                        <div class="feature-icon">📊</div>
                        <div>
                            <strong>Real-time Analytics</strong><br>
                            <small style="opacity: 0.8;">Track and monitor all relief operations</small>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">🔒</div>
                        <div>
                            <strong>Secure Access</strong><br>
                            <small style="opacity: 0.8;">Protected with enterprise-grade security</small>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">⚡</div>
                        <div>
                            <strong>Quick Response</strong><br>
                            <small style="opacity: 0.8;">Manage resources efficiently</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="login-form-container">
            <div class="login-form">
                <div class="form-header">
                    <div class="lock-icon">🔐</div>
                    <h2>Admin Login</h2>
                    <p class="subtitle">Enter your credentials to continue</p>
                </div>
                
                <?php if (isset($error)): ?>
                    <div class="error">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <div class="input-wrapper">
                            <input type="text" id="username" name="username" class="form-control" placeholder="Enter your username" required autofocus>
                            <span class="input-icon">👤</span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-wrapper">
                            <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                            <span class="input-icon">🔑</span>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-login">Sign In</button>
                </form>
                
                <div class="divider">
                    <span>Development Mode</span>
                </div>
                
                <div class="hint">
                    <div class="hint-title">Default Credentials</div>
                    <div class="hint-content">Username: admin • Password: admin123</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>