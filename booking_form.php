<?php
require_once '../haah/config.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$villa_id = isset($_GET['villa_id']) ? (int)$_GET['villa_id'] : 0;
$check_in_date = isset($_GET['check_in']) ? htmlspecialchars($_GET['check_in']) : '';
$check_out_date = isset($_GET['check_out']) ? htmlspecialchars($_GET['check_out']) : '';

$villa = [];
if ($villa_id > 0) {
    $stmt = $conn->prepare("SELECT villa_code, title, price, capacity, max_guests FROM villas WHERE id = :id");
    $stmt->execute([':id' => $villa_id]);
    $villa = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $check_in_date = htmlspecialchars($_POST['check_in_date']);
    $check_out_date = htmlspecialchars($_POST['check_out_date']);
    $number_of_guests = (int)$_POST['number_of_guests'];
    $message = htmlspecialchars($_POST['message']);

    $success = "ทดสอบสำเร็จ! ชื่อ: $name, อีเมล: $email, วันที่เช็คอิน: $check_in_date";
}

?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แบบฟอร์มจอง - <?php echo htmlspecialchars($villa['title'] ?? 'Great Pool Villa'); ?></title>
    <link rel="stylesheet" href="../scss/pl_style.css">
    <style>
        .booking-form {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .booking-form h2 {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }
        .booking-form label {
            display: block;
            font-size: 1.2rem;
            margin: 10px 0 5px;
            color: #555;
        }
        .booking-form input, .booking-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }
        .booking-form button {
            display: block;
            width: 100%;
            padding: 12px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1.2rem;
            cursor: pointer;
            transition: background 0.3s;
        }
        .booking-form button:hover {
            background: #0056b3;
        }
        .message {
            text-align: center;
            margin-top: 20px;
            color: #28a745;
        }
        .error {
            text-align: center;
            margin-top: 20px;
            color: #dc3545;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo"><a href="/index.php">Greatpoolvilla.com</a></div>
        <nav>
            <div class="hamburger"><i class="fas fa-bars"></i></div>
            <ul class="nav-menu">
                <li><a href="/index.php">หน้าแรก</a></li>
                <li><a href="/villas.php">วิลล่าทั้งหมด</a></li>
                <li><a href="/reviews.php">รีวิวจากลูกค้า</a></li>
                <li><a href="/contactus.php">ติดต่อเรา</a></li>
            </ul>
        </nav>
    </header>
<br>
<div class="booking-form">
        <h2>แบบฟอร์มจองวิลล่า</h2>
        <?php if (isset($success)): ?>
            <p class="message"><?php echo $success; ?></p>
        <?php elseif (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php else: ?>
            <form method="POST" action="">
                <input type="hidden" name="villa_id" value="<?php echo $villa_id; ?>">
                <label>วันที่เช็คอิน:</label>
                <input type="date" name="check_in_date" value="<?php echo $check_in_date; ?>" required>
                <label>วันที่เช็คเอาท์:</label>
                <input type="date" name="check_out_date" value="<?php echo $check_out_date; ?>" required>
                <label>จำนวนผู้ใหญ่:</label>
                <input type="number" name="adults" min="1" max="<?php echo $villa['max_guests'] ?? 50; ?>" required>
                <label>จำนวนเด็ก:</label>
                <input type="number" name="children" min="0" max="<?php echo $villa['max_guests'] ?? 20; ?>" required>
                <label>มีสัตว์เลี้ยงไหม:</label>
                <select name="has_pets" required>
                    <option value="No" <?php echo $has_pets === 'No' ? 'selected' : ''; ?>>ไม่</option>
                    <option value="Yes" <?php echo $has_pets === 'Yes' ? 'selected' : ''; ?>>ใช่</option>
                </select>
                <label>ชื่อ-นามสกุล:</label>
                <input type="text" name="name" required>
                <label>อีเมล:</label>
                <input type="email" name="email" required>
                <label>เบอร์โทร:</label>
                <input type="text" name="phone" required>
                <label>ข้อความเพิ่มเติม:</label>
                <textarea name="message" rows="4"></textarea>
                <button type="submit">ส่งคำขอจอง</button>
            </form>
        <?php endif; ?>
    </div>

    <footer>
        <div class="footer-content">
            <p>© 2025 Great Pool Villa. สงวนลิขสิทธิ์.</p>
            <p>ติดต่อเรา: <a href="mailto:info@greatpoolvilla.com">info@greatpoolvilla.com</a> | โทร. <a href="tel:0899422914">089-9422914</a></p>
        </footer>
    </body>
</html>