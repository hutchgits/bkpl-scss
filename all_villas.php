<?php
require_once '../haah/config.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); // ใช้ session ถ้ามีระบบ login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: /ad_pl_login.php");
    exit;
}

try {
    // ดึงข้อมูลวิลล่าทั้งหมด
    $stmt = $conn->prepare("SELECT * FROM villas");
    $stmt->execute();
    $villas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ดึงจำนวนรูปภาพสำหรับแต่ละวิลล่า
    foreach ($villas as &$villa) {
        $stmt_images = $conn->prepare("SELECT COUNT(*) as total, 
            SUM(CASE WHEN type = 'interior' THEN 1 ELSE 0 END) as interior,
            SUM(CASE WHEN type = 'exterior' THEN 1 ELSE 0 END) as exterior
            FROM villa_images WHERE villa_id = :villa_id");
        $stmt_images->execute([':villa_id' => $villa['id']]);
        $image_counts = $stmt_images->fetch(PDO::FETCH_ASSOC);
        $villa['image_total'] = $image_counts['total'];
        $villa['interior_count'] = $image_counts['interior'];
        $villa['exterior_count'] = $image_counts['exterior'];
    }
    unset($villa);
} catch(PDOException $e) {
    $error = "เกิดข้อผิดพลาด: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>วิลล่าทั้งหมด (Admin) - Great Pool Villa</title>
    <link rel="stylesheet" href="scss/pl_style.css">
    <style>
        .admin-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }
        .admin-container h1 {
            margin-bottom: 20px;
        }
        .villa-table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .villa-table th, .villa-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .villa-table th {
            background: #f4f4f4;
            font-weight: bold;
        }
        .villa-table tr:nth-child(even) {
            background: #f9f9f9;
        }
        .villa-table .edit-btn {
            display: inline-block;
            padding: 5px 10px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .villa-table .edit-btn:hover {
            background: #0056b3;
        }
        .villa-table .image-cell img {
            max-width: 100px;
            height: auto;
            border-radius: 5px;
        }
        .error {
            padding: 10px;
            margin-bottom: 20px;
            background: #f8d7da;
            color: #721c24;
            border-radius: 5px;
        }
        @media (max-width: 768px) {
            .villa-table, .villa-table th, .villa-table td {
                display: block;
                width: 100%;
            }
            .villa-table th, .villa-table td {
                padding: 8px;
            }
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
                <li><a href="/contactus.php">ติดต่อเรา</a></li>
                <li><a href="/add_villas.php">เพิ่มวิลล่า</a></li>
            </ul>
        </nav>
    </header>

    <div class="admin-container">
        <h1>วิลล่าทั้งหมด (Admin)</h1>

        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (empty($villas)): ?>
            <p>ไม่มีวิลล่าในระบบ</p>
        <?php else: ?>
            <table class="villa-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>รหัสวิลล่า</th>
                        <th>ชื่อ</th>
                        <th>ห้องนอน</th>
                        <th>คำอธิบาย</th>
                        <th>สถานที่</th>
                        <th>ราคา</th>
                        <th>ความจุ</th>
                        <th>สัตว์เลี้ยง</th>
                        <th>สถานะ</th>
                        <th>วันที่สร้าง</th>
                        <th>รหัสย่อ</th>
                        <th>รูปภาพหลัก</th>
                        <th>รูปภาพ (ใน/นอก)</th>
                        <th>แก้ไข</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($villas as $villa): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($villa['id']); ?></td>
                            <td><?php echo htmlspecialchars($villa['villa_code'] ?? 'ไม่ระบุ'); ?></td>
                            <td><?php echo htmlspecialchars($villa['name'] ?? 'ไม่ระบุ'); ?></td>
                            <td><?php echo htmlspecialchars($villa['bedrooms'] ?? 'ไม่ระบุ'); ?></td>
                            <td><?php echo nl2br(htmlspecialchars(substr($villa['description'] ?? 'ไม่ระบุ', 0, 50))); ?>...</td>
                            <td><?php echo htmlspecialchars($villa['location'] ?? 'ไม่ระบุ'); ?></td>
                            <td>฿<?php echo number_format($villa['price'] ?? 0, 2); ?></td>
                            <td><?php echo htmlspecialchars($villa['capacity'] ?? 'ไม่ระบุ'); ?></td>
                            <td><?php echo $villa['pet_allowed'] ? 'อนุญาต' : 'ไม่อนุญาต'; ?></td>
                            <td><?php echo $villa['status'] === 'available' ? 'ว่าง' : 'จองแล้ว'; ?></td>
                            <td><?php echo htmlspecialchars($villa['created_at'] ?? 'ไม่ระบุ'); ?></td>
                            <td><?php echo htmlspecialchars($villa['code'] ?? 'ไม่ระบุ'); ?></td>
                            <td class="image-cell">
                                <img src="<?php echo htmlspecialchars($villa['image'] ?? '/images/villa1.jpg'); ?>" 
                                     alt="<?php echo htmlspecialchars($villa['name'] ?? 'วิลล่า'); ?>" 
                                     loading="lazy">
                            </td>
                            <td><?php echo $villa['interior_count'] . ' / ' . $villa['exterior_count']; ?></td>
                            <td>
                                <a href="/edit_villas.php?id=<?php echo htmlspecialchars($villa['id']); ?>" 
                                   class="edit-btn">แก้ไข</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <footer>
        <div class="footer-content">
            <p>© 2025 Great Pool Villa. สงวนลิขสิทธิ์.</p>
            <p>ติดต่อเรา: <a href="mailto:info@greatpoolvilla.com">info@greatpoolvilla.com</a> | โทร. <a href="tel:0899422914">089-9422914</a></p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const hamburger = document.querySelector('.hamburger');
            const navMenu = document.querySelector('.nav-menu');
            if (hamburger && navMenu) {
                hamburger.addEventListener('click', () => {
                    navMenu.classList.toggle('active');
                });
                navMenu.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', () => {
                        navMenu.classList.remove('active');
                    });
                });
            }
        });
    </script>
</body>
</html>