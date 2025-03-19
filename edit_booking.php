<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ad_pl_login.php");
    exit();
}

require_once '../haah/config.php';

if (!isset($conn)) {
    die("ข้อผิดพลาด: ไม่สามารถเชื่อมต่อฐานข้อมูลได้");
}

// ตรวจสอบว่าได้รับ id หรือไม่
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: manage_bookings.php");
    exit();
}

$booking_id = intval($_GET['id']);

// ดึงข้อมูลการจองที่ต้องการแก้ไข
$stmt = $conn->prepare("SELECT b.*, v.name AS villa_name, v.villa_code FROM bookings b LEFT JOIN villas v ON b.villa_id = v.id WHERE b.id = ?");
$stmt->execute([$booking_id]);
$booking = $stmt->fetch();

if (!$booking) {
    header("Location: manage_bookings.php");
    exit();
}

// ดึงรายการวิลล่าทั้งหมดสำหรับ dropdown
$stmt = $conn->query("SELECT id, villa_code, name FROM villas ORDER BY villa_code");
$villas = $stmt->fetchAll();

// อัปเดตข้อมูลการจอง
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_booking'])) {
    $villa_id = intval($_POST['villa_id']);
    $checkin_date = $_POST['checkin_date'];
    $checkout_date = $_POST['checkout_date'];
    $status = $_POST['status'];

    // ตรวจสอบวันที่ให้แน่ใจว่า checkout_date > checkin_date
    if (strtotime($checkout_date) <= strtotime($checkin_date)) {
        $error = "วันที่เช็คเอาท์ต้องมากกว่าวันที่เช็คอิน";
    } else {
        $stmt = $conn->prepare("UPDATE bookings SET villa_id = ?, checkin_date = ?, checkout_date = ?, status = ? WHERE id = ?");
        if ($stmt->execute([$villa_id, $checkin_date, $checkout_date, $status, $booking_id])) {
            $success = "อัปเดตการจองสำเร็จ!";
            header("Refresh:2; url=manage_bookings.php"); // กลับไปหน้า manage_bookings.php หลัง 2 วินาที
        } else {
            $error = "เกิดข้อผิดพลาด: " . implode(", ", $stmt->errorInfo());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขการจอง - Great Pool Villa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="scss/pl_style.css">
</head>
<body>
    <header class="admin-header">
        <h1>แก้ไขการจอง</h1>
        <a href="manage_bookings.php" class="back-btn"><i class="fas fa-arrow-left"></i> กลับไปที่จัดการการจอง</a>
    </header>

    <main class="manage-section">
        <?php if (isset($success)): ?>
            <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
        <?php elseif (isset($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <h2>แก้ไขข้อมูลการจอง (ID: <?php echo htmlspecialchars($booking['id']); ?>)</h2>
        <form class="manage-form" method="POST">
            <div class="form-group">
                <label for="villa_id">วิลล่า</label>
                <select id="villa_id" name="villa_id" required>
                    <?php foreach ($villas as $villa): ?>
                        <option value="<?php echo $villa['id']; ?>" <?php echo $villa['id'] == $booking['villa_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($villa['villa_code'] . ' - ' . $villa['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="checkin_date">วันที่เช็คอิน</label>
                <input type="date" id="checkin_date" name="checkin_date" value="<?php echo htmlspecialchars($booking['checkin_date']); ?>" required>
            </div>
            <div class="form-group">
                <label for="checkout_date">วันที่เช็คเอาท์</label>
                <input type="date" id="checkout_date" name="checkout_date" value="<?php echo htmlspecialchars($booking['checkout_date']); ?>" required>
            </div>
            <div class="form-group">
                <label for="status">สถานะ</label>
                <select id="status" name="status">
                    <option value="pending" <?php echo $booking['status'] === 'pending' ? 'selected' : ''; ?>>รอ確認</option>
                    <option value="confirmed" <?php echo $booking['status'] === 'confirmed' ? 'selected' : ''; ?>>ยืนยันแล้ว</option>
                    <option value="cancelled" <?php echo $booking['status'] === 'cancelled' ? 'selected' : ''; ?>>ยกเลิก</option>
                </select>
            </div>
            <button type="submit" name="update_booking" class="submit-btn"><i class="fas fa-save"></i> บันทึกการเปลี่ยนแปลง</button>
        </form>
    </main>
</body>
</html>