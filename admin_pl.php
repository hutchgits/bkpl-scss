<?php
require_once '../haah/config.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: /all_villas.php");
    exit;
}

$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "กรุณากรอกข้อมูลให้ครบทุกช่อง";
    } elseif ($password !== $confirm_password) {
        $error = "รหัสผ่านไม่ตรงกัน";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "รูปแบบอีเมลไม่ถูกต้อง";
    } else {
        try {
            $stmt = $conn->prepare("SELECT id FROM admins WHERE username = :username OR email = :email");
            $stmt->execute([':username' => $username, ':email' => $email]);
            if ($stmt->fetch()) {
                $error = "ชื่อผู้ใช้หรืออีเมลนี้มีอยู่ในระบบแล้ว";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO admins (username, email, password) 
                    VALUES (:username, :email, :password)");
                $stmt->execute([
                    ':username' => $username,
                    ':email' => $email,
                    ':password' => $hashed_password
                ]);
                $success = "ลงทะเบียนสำเร็จ กรุณาเข้าสู่ระบบ";
            }
        } catch(PDOException $e) {
            $error = "เกิดข้อผิดพลาด: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ลงทะเบียน Admin - Great Pool Villa</title>
    <link rel="stylesheet" href="scss/pl_style.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'TH Sarabun', Arial, sans-serif;
            background: linear-gradient(135deg, #007EBA, #005D8A);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #333;
        }
        .register-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 126, 186, 0.3);
            width: 100%;
            max-width: 450px;
            text-align: center;
            animation: slideIn 0.6s ease-out;
            position: relative;
            overflow: hidden;
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .register-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(102, 196, 232, 0.2), transparent);
            transform: rotate(30deg);
            pointer-events: none;
        }
        .register-container h1 {
            margin-bottom: 25px;
            color: #007EBA;
            font-size: 36px;
            font-weight: bold;
            position: relative;
            z-index: 1;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
            position: relative;
        }
        .form-group label {
            font-size: 20px;
            color: #333;
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
        }
        .form-group input {
            width: 100%;
            padding: 12px 40px 12px 15px; /* ปรับ padding ขวาให้สมดุล */
            font-size: 22px;
            border: 1px solid #66C4E8;
            border-radius: 8px;
            background: #FFFFFF;
            color: #007EBA;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.05);
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        .form-group input:focus {
            border-color: #007EBA;
            box-shadow: 0 0 10px rgba(0, 126, 186, 0.5);
            outline: none;
        }
        .form-group i {
            position: absolute;
            right: 10px; /* ลดระยะจากขอบขวา */
            top: 50%;
            transform: translateY(-50%);
            color: #66C4E8;
            font-size: 20px; /* ลดขนาดไอคอน */
            cursor: pointer;
        }
        .register-btn {
            width: 100%;
            padding: 12px;
            background-color: #007EBA;
            color: #FFFFFF;
            border: none;
            border-radius: 8px;
            font-size: 22px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            box-shadow: 0 5px 15px rgba(0, 126, 186, 0.4);
        }
        .register-btn:hover {
            background-color: #66C4E8;
            transform: translateY(-2px);
        }
        .error {
            background: #FF4444;
            color: #FFFFFF;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 18px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .success {
            background: #28A745;
            color: #FFFFFF;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 18px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .footer-text {
            margin-top: 20px;
            font-size: 18px;
            color: #555;
        }
        .footer-text a {
            color: #66C4E8;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }
        .footer-text a:hover {
            color: #007EBA;
        }
        @media (max-width: 480px) {
            .register-container {
                padding: 25px;
                margin: 15px;
            }
            .register-container h1 {
                font-size: 28px;
            }
            .form-group input {
                font-size: 18px;
                padding: 10px 35px 10px 12px;
            }
            .form-group i {
                font-size: 16px;
                right: 8px;
            }
            .register-btn {
                font-size: 18px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h1>ลงทะเบียน Admin</h1>

        <?php if (!empty($success)): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label>ชื่อผู้ใช้</label>
                <input type="text" name="username" placeholder="กรอกชื่อผู้ใช้" required>
                <i class="fas fa-user"></i>
            </div>
            <div class="form-group">
                <label>อีเมล</label>
                <input type="email" name="email" placeholder="กรอกอีเมล" required>
                <i class="fas fa-envelope"></i>
            </div>
            <div class="form-group">
                <label>รหัสผ่าน</label>
                <input type="password" name="password" id="password" placeholder="กรอกรหัสผ่าน" required>
                <i class="fas fa-eye toggle-password" data-target="password"></i>
            </div>
            <div class="form-group">
                <label>ยืนยันรหัสผ่าน</label>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="ยืนยันรหัสผ่าน" required>
                <i class="fas fa-eye toggle-password" data-target="confirm_password"></i>
            </div>
            <button type="submit" class="register-btn">ลงทะเบียน</button>
        </form>

        <div class="footer-text">
            มีบัญชีแล้ว? <a href="/ad_pl_login.php">เข้าสู่ระบบ</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggles = document.querySelectorAll('.toggle-password');
            toggles.forEach(toggle => {
                toggle.addEventListener('click', () => {
                    const targetId = toggle.getAttribute('data-target');
                    const input = document.getElementById(targetId);
                    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                    input.setAttribute('type', type);
                    toggle.classList.toggle('fa-eye');
                    toggle.classList.toggle('fa-eye-slash');
                });
            });
        });
    </script>
</body>
</html>