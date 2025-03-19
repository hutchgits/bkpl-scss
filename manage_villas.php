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

// ดึงรายการวิลล่าทั้งหมด
$stmt = $conn->query("SELECT id, villa_code, title, bedrooms, bathrooms, price, capacity, status, location, pet_allowed, sea_proximity FROM villas ORDER BY id DESC");
$villas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ลบวิลล่า
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM villas WHERE id = :id");
    if ($stmt->execute([':id' => $id])) {
        $success = "ลบวิลล่าสำเร็จ!";
        header("Refresh:2");
    } else {
        $error = "เกิดข้อผิดพลาด: " . implode(", ", $stmt->errorInfo());
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการพูลวิลล่า - Great Pool Villa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="scss/pl_style.css">
</head>
<body>
    <header class="admin-header">
        <h1>จัดการพูลวิลล่า</h1>
        <div class="admin-info">
            <a href="admin_dashboard.php" class="back-btn"><i class="fas fa-arrow-left"></i> กลับไปที่แดชบอร์ด</a>
            <a href="add_villas.php" class="add-btn"><i class="fas fa-plus-circle"></i> เพิ่มพูลวิลล่าใหม่</a>
        </div>
    </header>

    <main class="manage-section">
        <?php if (isset($success)): ?>
            <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
        <?php elseif (isset($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <h2>รายการพูลวิลล่า</h2>
        <table class="manage-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>รหัสวิลล่า</th>
                    <th>ชื่อ</th>
                    <th>ตำแหน่ง</th>
                    <th>ห้องนอน</th>
                    <th>ห้องน้ำ</th>
                    <th>ราคา</th>
                    <th>จำนวนสูงสุดที่รองรับ</th>
                    <th>สัตว์เลี้ยง</th>
                    <th>ระยะห่างทะเล</th>
                    <th>สถานะ</th>
                    <th>การจัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($villas as $villa): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($villa['id']); ?></td>
                        <td><?php echo htmlspecialchars($villa['villa_code']); ?></td>
                        <td><?php echo htmlspecialchars($villa['title']); ?></td>
                        <td><?php echo htmlspecialchars($villa['location'] ?? 'ไม่ระบุ'); ?></td>
                        <td><?php echo htmlspecialchars($villa['bedrooms']); ?></td>
                        <td><?php echo htmlspecialchars($villa['bathrooms']); ?></td>
                        <td><?php echo number_format($villa['price'], 2); ?></td>
                        <td><?php echo htmlspecialchars($villa['capacity']); ?></td>
                        <td><?php echo $villa['pet_allowed'] ? 'รับ' : 'ไม่รับ'; ?></td>
                        <td><?php echo $villa['sea_proximity'] === 'beachfront' ? 'ติดทะเล' : ($villa['sea_proximity'] === 'near_sea' ? 'ใกล้ทะเล' : 'ห่างทะเล'); ?></td>
                        <td><?php echo $villa['status'] === 'available' ? 'ว่าง' : 'ถูกจอง'; ?></td>
                        <td>
                            <a href="edit_villas.php?id=<?php echo $villa['id']; ?>" class="edit-btn"><i class="fas fa-edit"></i> แก้ไข</a>
                            <a href="?delete=<?php echo $villa['id']; ?>" class="delete-btn" onclick="return confirm('แน่ใจหรือไม่ว่าต้องการลบ?')"><i class="fas fa-trash"></i> ลบ</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>