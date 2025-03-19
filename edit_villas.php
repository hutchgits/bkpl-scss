<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['admin_id'])) {
    header("Location: ad_pl_login.php");
    exit();
}

require_once '../haah/config.php';

try {
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        throw new Exception("ไม่พบรหัสวิลล่า");
    }

    $villa_id = (int)$_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM villas WHERE id = :id");
    $stmt->execute([':id' => $villa_id]);
    $villa = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$villa) {
        throw new Exception("ไม่พบวิลล่านี้ในระบบ");
    }

    // ดึงรูปภาพจากตาราง villas_images
    $stmt_images = $conn->prepare("SELECT id, image, caption, type FROM villas_images WHERE villa_id = :villa_id");
    $stmt_images->execute([':villa_id' => $villa_id]);
    $images = $stmt_images->fetchAll(PDO::FETCH_ASSOC);

    $interior_images = array_filter($images, fn($img) => $img['type'] === 'interior');
    $exterior_images = array_filter($images, fn($img) => $img['type'] === 'exterior');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $villa_code = $_POST['villa_code'];
        $title = htmlspecialchars($_POST['title']);
        $description = htmlspecialchars($_POST['description']);
        $bedrooms = (int)$_POST['bedrooms'];
        $bathrooms = (int)$_POST['bathrooms'];
        $amenities = htmlspecialchars($_POST['amenities']);
        $house_rules = htmlspecialchars($_POST['house_rules']);
        $extra_services = htmlspecialchars($_POST['extra_services']);
        $bedroom_details = htmlspecialchars($_POST['bedroom_details']);
        $booking_details = htmlspecialchars($_POST['booking_details']);
        $check_in_time = $_POST['check_in_time'];
        $check_out_time = $_POST['check_out_time'];
        $contact_info = htmlspecialchars($_POST['contact_info']);
        $price = (float)$_POST['price'];
        $price_details = htmlspecialchars($_POST['price_details']);
        $capacity = (int)$_POST['capacity'];
        $location = htmlspecialchars($_POST['location']);
        $pet_allowed = isset($_POST['pet_allowed']) ? 1 : 0;
        $sea_proximity = $_POST['sea_proximity'];

        if ($villa_code !== strtoupper($villa_code)) {
            throw new Exception("รหัสบ้านพักต้องใช้ภาษาอังกฤษตัวใหญ่เท่านั้น (เช่น VH001, VCS02)");
        }
        $villa_code = preg_replace('/[^A-Z0-9-_]/', '', $villa_code);

        // ตรวจสอบรหัสวิลล่าซ้ำ (ยกเว้นของตัวเอง)
        $checkStmt = $conn->prepare("SELECT COUNT(*) FROM villas WHERE villa_code = :villa_code AND id != :id");
        $checkStmt->execute([':villa_code' => $villa_code, ':id' => $villa_id]);
        if ($checkStmt->fetchColumn() > 0) {
            throw new Exception("รหัสบ้านพัก '$villa_code' มีอยู่ในระบบแล้ว กรุณาใช้รหัสอื่น");
        }

        // อัพโหลดรูปภาพหลักใหม่ (ถ้ามี)
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxFileSize = 5 * 1024 * 1024;
        $image = $villa['image'];
        if (!empty($_FILES['main_image']['name'])) {
            $fileType = mime_content_type($_FILES['main_image']['tmp_name']);
            if (in_array($fileType, $allowedTypes) && $_FILES['main_image']['size'] <= $maxFileSize) {
                $baseUploadDir = __DIR__ . '/images/' . $villa_code . '/';
                if (!is_dir($baseUploadDir) && !mkdir($baseUploadDir, 0777, true)) {
                    throw new Exception("ไม่สามารถสร้างโฟลเดอร์หลักได้");
                }
                $mainFileName = basename($_FILES['main_image']['name']);
                $image = '/images/' . $villa_code . '/' . $mainFileName;
                if (!move_uploaded_file($_FILES['main_image']['tmp_name'], $baseUploadDir . $mainFileName)) {
                    throw new Exception("ไม่สามารถอัปโหลดไฟล์หลักได้");
                }
            } else {
                throw new Exception("ไฟล์รูปภาพหลักไม่ถูกต้อง (ต้องเป็น JPG, PNG, GIF, WebP และไม่เกิน 5MB)");
            }
        }

        // อัพเดทข้อมูลวิลล่า
        $stmt = $conn->prepare("UPDATE villas SET 
            villa_code = :villa_code, 
            title = :title, 
            description = :description, 
            bedrooms = :bedrooms, 
            bathrooms = :bathrooms, 
            amenities = :amenities, 
            house_rules = :house_rules, 
            extra_services = :extra_services, 
            bedroom_details = :bedroom_details, 
            booking_details = :booking_details, 
            check_in_time = :check_in_time, 
            check_out_time = :check_out_time, 
            contact_info = :contact_info, 
            price = :price, 
            price_details = :price_details, 
            image = :image, 
            capacity = :capacity, 
            location = :location, 
            pet_allowed = :pet_allowed, 
            sea_proximity = :sea_proximity 
            WHERE id = :id");
        $stmt->execute([
            ':villa_code' => $villa_code,
            ':title' => $title,
            ':description' => $description,
            ':bedrooms' => $bedrooms,
            ':bathrooms' => $bathrooms,
            ':amenities' => $amenities,
            ':house_rules' => $house_rules,
            ':extra_services' => $extra_services,
            ':bedroom_details' => $bedroom_details,
            ':booking_details' => $booking_details,
            ':check_in_time' => $check_in_time ?: null,
            ':check_out_time' => $check_out_time ?: null,
            ':contact_info' => $contact_info,
            ':price' => $price,
            ':price_details' => $price_details,
            ':image' => $image,
            ':capacity' => $capacity,
            ':location' => $location,
            ':pet_allowed' => $pet_allowed,
            ':sea_proximity' => $sea_proximity,
            ':id' => $villa_id
        ]);

        // ลบรูปภาพที่เลือก
        if (!empty($_POST['delete_images'])) {
            $delete_ids = array_map('intval', $_POST['delete_images']);
            $stmt = $conn->prepare("DELETE FROM villas_images WHERE id IN (" . implode(',', array_fill(0, count($delete_ids), '?')) . ") AND villa_id = ?");
            $stmt->execute(array_merge($delete_ids, [$villa_id]));
        }

        // อัพโหลดรูปภาพภายในใหม่
        $interiorDir = __DIR__ . '/images/' . $villa_code . '/interior/';
        if (!is_dir($interiorDir) && !mkdir($interiorDir, 0777, true)) throw new Exception("ไม่สามารถสร้างโฟลเดอร์ interior ได้");
        if (!empty($_FILES['interior_images']['name'][0])) {
            foreach ($_FILES['interior_images']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['interior_images']['size'][$key] > 0) {
                    $fileType = mime_content_type($tmp_name);
                    if (in_array($fileType, $allowedTypes) && $_FILES['interior_images']['size'][$key] <= $maxFileSize) {
                        $fileName = basename($_FILES['interior_images']['name'][$key]);
                        $filePath = '/images/' . $villa_code . '/interior/' . $fileName;
                        $caption = htmlspecialchars($_POST['interior_captions'][$key] ?? '');
                        if (move_uploaded_file($tmp_name, $interiorDir . $fileName)) {
                            $stmt = $conn->prepare("INSERT INTO villas_images (villa_id, image, caption, type) 
                                                    VALUES (:villa_id, :image, :caption, 'interior')");
                            $stmt->execute([
                                ':villa_id' => $villa_id,
                                ':image' => $filePath,
                                ':caption' => $caption
                            ]);
                        }
                    }
                }
            }
        }

        // อัพโหลดรูปภาพภายนอกใหม่
        $exteriorDir = __DIR__ . '/images/' . $villa_code . '/exterior/';
        if (!is_dir($exteriorDir) && !mkdir($exteriorDir, 0777, true)) throw new Exception("ไม่สามารถสร้างโฟลเดอร์ exterior ได้");
        if (!empty($_FILES['exterior_images']['name'][0])) {
            foreach ($_FILES['exterior_images']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['exterior_images']['size'][$key] > 0) {
                    $fileType = mime_content_type($tmp_name);
                    if (in_array($fileType, $allowedTypes) && $_FILES['exterior_images']['size'][$key] <= $maxFileSize) {
                        $fileName = basename($_FILES['exterior_images']['name'][$key]);
                        $filePath = '/images/' . $villa_code . '/exterior/' . $fileName;
                        $caption = htmlspecialchars($_POST['exterior_captions'][$key] ?? '');
                        if (move_uploaded_file($tmp_name, $exteriorDir . $fileName)) {
                            $stmt = $conn->prepare("INSERT INTO villas_images (villa_id, image, caption, type) 
                                                    VALUES (:villa_id, :image, :caption, 'exterior')");
                            $stmt->execute([
                                ':villa_id' => $villa_id,
                                ':image' => $filePath,
                                ':caption' => $caption
                            ]);
                        }
                    }
                }
            }
        }

        $success = "แก้ไขวิลล่า $title (รหัส: $villa_code) เรียบร้อยแล้ว!";
        header("Refresh:2;url=manage_villas.php");
    }
} catch(Exception $e) {
    $error = "เกิดข้อผิดพลาด: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="แก้ไขข้อมูลวิลล่าในระบบ Great Pool Villa หัวหิน (สำหรับแอดมินเท่านั้น)">
    <meta name="robots" content="noindex, nofollow">
    <title>แก้ไขวิลล่า - Great Pool Villa หัวหิน</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="scss/pl_style.css">
    <style>
        .image-preview { margin: 10px 0; }
        .image-preview img { max-width: 150px; margin-right: 10px; }
        .image-preview label { display: inline-block; margin-right: 10px; }
    </style>
</head>
<body>
    <header class="admin-header">
        <h1>แก้ไขวิลล่า</h1>
        <div class="admin-info">
            <a href="manage_villas.php" class="back-btn"><i class="fas fa-arrow-left"></i> กลับไปที่จัดการวิลล่า</a>
            <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> ออกจากระบบ</a>
        </div>
    </header>

    <main class="manage-section">
        <h1>แก้ไขวิลล่า (สำหรับแอดมิน)</h1>
        <p>กรุณาแก้ไขข้อมูลด้านล่างเพื่ออัพเดทวิลล่าในระบบ</p>
        <?php if (isset($success)): ?>
            <div class="success-message"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data" class="villa-form">
            <div class="form-group">
                <label for="villa_code"><i class="fas fa-key"></i> รหัสบ้านพัก (ภาษาอังกฤษตัวใหญ่เท่านั้น)</label>
                <input type="text" id="villa_code" name="villa_code" required value="<?php echo htmlspecialchars($villa['villa_code']); ?>" placeholder="เช่น VH001, VCS02, PC090">
            </div>
            <div class="form-group">
                <label for="title"><i class="fas fa-home"></i> ชื่อวิลล่า</label>
                <input type="text" id="title" name="title" required value="<?php echo htmlspecialchars($villa['title']); ?>" placeholder="เช่น บ้านพักพูลวิลล่า หัวหิน ติดทะเล">
            </div>
            <div class="form-group">
                <label for="location"><i class="fas fa-map-marker-alt"></i> ตำแหน่งบ้านพัก</label>
                <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($villa['location']); ?>" placeholder="เช่น หัวหิน, ชะอำ, ปราณบุรี">
            </div>
            <div class="form-group">
                <label for="description"><i class="fas fa-info-circle"></i> คำอธิบาย</label>
                <textarea id="description" name="description" placeholder="รายละเอียดวิลล่า" rows="5"><?php echo htmlspecialchars($villa['description']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="bedrooms"><i class="fas fa-bed"></i> จำนวนห้องนอน</label>
                <input type="number" id="bedrooms" name="bedrooms" min="1" required value="<?php echo htmlspecialchars($villa['bedrooms']); ?>" placeholder="จำนวนห้องนอน">
            </div>
            <div class="form-group">
                <label for="bathrooms"><i class="fas fa-bath"></i> จำนวนห้องน้ำ</label>
                <input type="number" id="bathrooms" name="bathrooms" min="1" required value="<?php echo htmlspecialchars($villa['bathrooms']); ?>" placeholder="จำนวนห้องน้ำ">
            </div>
            <div class="form-group">
                <label for="capacity"><i class="fas fa-users"></i> จำนวนผู้เข้าพัก</label>
                <input type="number" id="capacity" name="capacity" min="1" required value="<?php echo htmlspecialchars($villa['capacity']); ?>" placeholder="จำนวนผู้เข้าพักสูงสุด">
            </div>
            <div class="form-group">
                <label for="price"><i class="fas fa-tag"></i> ราคา (บาท/คืน)</label>
                <input type="number" id="price" name="price" step="0.01" required value="<?php echo htmlspecialchars($villa['price']); ?>" placeholder="ราคาต่อคืน">
            </div>
            <div class="form-group">
                <label for="price_details"><i class="fas fa-list"></i> รายละเอียดราคา</label>
                <textarea id="price_details" name="price_details" placeholder="เช่น ราคานี้รวมอาหารเช้า" rows="3"><?php echo htmlspecialchars($villa['price_details']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="amenities"><i class="fas fa-concierge-bell"></i> สิ่งอำนวยความสะดวก</label>
                <textarea id="amenities" name="amenities" placeholder="เช่น Wi-Fi, สระว่ายน้ำ" rows="3"><?php echo htmlspecialchars($villa['amenities']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="house_rules"><i class="fas fa-book"></i> กฎระเบียบ</label>
                <textarea id="house_rules" name="house_rules" placeholder="เช่น ห้ามสูบบุหรี่" rows="3"><?php echo htmlspecialchars($villa['house_rules']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="extra_services"><i class="fas fa-plus-circle"></i> บริการเสริม</label>
                <textarea id="extra_services" name="extra_services" placeholder="เช่น บริการรถรับส่ง" rows="3"><?php echo htmlspecialchars($villa['extra_services']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="bedroom_details"><i class="fas fa-bed"></i> รายละเอียดห้องนอน</label>
                <textarea id="bedroom_details" name="bedroom_details" placeholder="เช่น ห้องนอน 1: เตียงคิงไซส์" rows="3"><?php echo htmlspecialchars($villa['bedroom_details']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="booking_details"><i class="fas fa-calendar-check"></i> รายละเอียดการจอง</label>
                <textarea id="booking_details" name="booking_details" placeholder="เช่น ต้องจองล่วงหน้า 7 วัน" rows="3"><?php echo htmlspecialchars($villa['booking_details']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="check_in_time"><i class="fas fa-clock"></i> เวลาเช็คอิน</label>
                <input type="time" id="check_in_time" name="check_in_time" value="<?php echo htmlspecialchars($villa['check_in_time']); ?>">
            </div>
            <div class="form-group">
                <label for="check_out_time"><i class="fas fa-clock"></i> เวลาเช็คเอาท์</label>
                <input type="time" id="check_out_time" name="check_out_time" value="<?php echo htmlspecialchars($villa['check_out_time']); ?>">
            </div>
            <div class="form-group">
                <label for="contact_info"><i class="fas fa-phone"></i> ข้อมูลติดต่อ</label>
                <input type="text" id="contact_info" name="contact_info" value="<?php echo htmlspecialchars($villa['contact_info']); ?>" placeholder="เช่น โทร 089-123-4567">
            </div>
            <div class="form-group">
                <label for="pet_allowed"><i class="fas fa-paw"></i> รับสัตว์เลี้ยง</label>
                <input type="checkbox" id="pet_allowed" name="pet_allowed" value="1" <?php echo $villa['pet_allowed'] ? 'checked' : ''; ?>>
            </div>
            <div class="form-group">
                <label for="sea_proximity"><i class="fas fa-water"></i> ระยะห่างจากทะเล</label>
                <select id="sea_proximity" name="sea_proximity" required>
                    <option value="beachfront" <?php echo $villa['sea_proximity'] === 'beachfront' ? 'selected' : ''; ?>>ติดทะเล</option>
                    <option value="near_sea" <?php echo $villa['sea_proximity'] === 'near_sea' ? 'selected' : ''; ?>>ใกล้ทะเล</option>
                    <option value="far_from_sea" <?php echo $villa['sea_proximity'] === 'far_from_sea' ? 'selected' : ''; ?>>ห่างทะเล</option>
                </select>
            </div>
            <div class="form-group">
                <label for="main_image"><i class="fas fa-image"></i> รูปภาพหลัก (ปัจจุบัน: <?php echo htmlspecialchars($villa['image'] ?? 'ไม่มี'); ?>)</label>
                <?php if ($villa['image']): ?>
                    <div class="image-preview">
                        <img src="<?php echo htmlspecialchars($villa['image']); ?>" alt="รูปภาพหลักปัจจุบัน">
                    </div>
                <?php endif; ?>
                <input type="file" id="main_image" name="main_image" accept="image/*">
            </div>
            <div class="form-group">
                <label><i class="fas fa-images"></i> รูปภาพภายใน (Interior) ปัจจุบัน</label>
                <?php if (!empty($interior_images)): ?>
                    <div class="image-preview">
                        <?php foreach ($interior_images as $image): ?>
                            <div>
                                <img src="<?php echo htmlspecialchars($image['image']); ?>" alt="<?php echo htmlspecialchars($image['caption']); ?>">
                                <label><input type="checkbox" name="delete_images[]" value="<?php echo $image['id']; ?>"> ลบรูปนี้</label>
                                <p><?php echo htmlspecialchars($image['caption'] ?? 'ไม่มีคำบรรยาย'); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>ยังไม่มีรูปภาพภายใน</p>
                <?php endif; ?>
                <label for="interior_images">เพิ่มรูปภาพภายในใหม่</label>
                <input type="file" id="interior_images" name="interior_images[]" multiple accept="image/*">
                <div id="interior-caption-container"></div>
            </div>
            <div class="form-group">
                <label><i class="fas fa-images"></i> รูปภาพภายนอก (Exterior) ปัจจุบัน</label>
                <?php if (!empty($exterior_images)): ?>
                    <div class="image-preview">
                        <?php foreach ($exterior_images as $image): ?>
                            <div>
                                <img src="<?php echo htmlspecialchars($image['image']); ?>" alt="<?php echo htmlspecialchars($image['caption']); ?>">
                                <label><input type="checkbox" name="delete_images[]" value="<?php echo $image['id']; ?>"> ลบรูปนี้</label>
                                <p><?php echo htmlspecialchars($image['caption'] ?? 'ไม่มีคำบรรยาย'); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>ยังไม่มีรูปภาพภายนอก</p>
                <?php endif; ?>
                <label for="exterior_images">เพิ่มรูปภาพภายนอกใหม่</label>
                <input type="file" id="exterior_images" name="exterior_images[]" multiple accept="image/*">
                <div id="exterior-caption-container"></div>
            </div>
            <div class="form-buttons">
                <button type="submit" class="submit-btn"><i class="fas fa-save"></i> บันทึกการแก้ไข</button>
                <a href="manage_villas.php" class="reset-btn"><i class="fas fa-times"></i> ยกเลิก</a>
            </div>
        </form>
    </main>

    <footer class="admin-footer">
        <div class="footer-content">
            <p>© 2025 Great Pool Villa. สงวนลิขสิทธิ์.</p>
            <p>ติดต่อเรา: <a href="mailto:info@greatpoolvilla.com">info@greatpoolvilla.com</a> | โทร. <a href="tel:0899422914">089-9422914</a></p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('interior_images').addEventListener('change', function(e) {
                const container = document.getElementById('interior-caption-container');
                container.innerHTML = '';
                const files = e.target.files;
                for (let i = 0; i < files.length; i++) {
                    const div = document.createElement('div');
                    div.className = 'form-group caption-group';
                    div.innerHTML = `
                        <label for="interior_caption-${i}"><i class="fas fa-comment"></i> คำบรรยายภาพ ${files[i].name}</label>
                        <input type="text" id="interior_caption-${i}" name="interior_captions[]" placeholder="คำบรรยายสำหรับภาพนี้">
                    `;
                    container.appendChild(div);
                }
            });

            document.getElementById('exterior_images').addEventListener('change', function(e) {
                const container = document.getElementById('exterior-caption-container');
                container.innerHTML = '';
                const files = e.target.files;
                for (let i = 0; i < files.length; i++) {
                    const div = document.createElement('div');
                    div.className = 'form-group caption-group';
                    div.innerHTML = `
                        <label for="exterior_caption-${i}"><i class="fas fa-comment"></i> คำบรรยายภาพ ${files[i].name}</label>
                        <input type="text" id="exterior_caption-${i}" name="exterior_captions[]" placeholder="คำบรรยายสำหรับภาพนี้">
                    `;
                    container.appendChild(div);
                }
            });
        });
    </script>
</body>
</html>