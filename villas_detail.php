<?php
require_once '../haah/config.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    $villa_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    if ($villa_id <= 0) {
        throw new Exception("ไม่พบรหัสวิลล่า");
    }

    $stmt = $conn->prepare("SELECT villa_code, title, bedrooms, bathrooms, description, image, capacity, price, amenities, house_rules, check_in_time, check_out_time, location, pet_allowed, sea_proximity, extra_services, bedroom_details, price_details, booking_details, contact_info 
                            FROM villas WHERE id = :id");
    $stmt->execute([':id' => $villa_id]);
    $villa = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$villa) {
        throw new Exception("ไม่พบวิลล่านี้");
    }

    $stmt_images = $conn->prepare("SELECT image, caption, type FROM villas_images WHERE villa_id = :villa_id");
    $stmt_images->execute([':villa_id' => $villa_id]);
    $images = $stmt_images->fetchAll(PDO::FETCH_ASSOC);

    $exterior_images = array_filter($images, fn($img) => $img['type'] === 'exterior');
    $interior_images = array_filter($images, fn($img) => $img['type'] === 'interior');

    // กำหนดข้อความระยะห่างจากทะเล
    $sea_proximity_text = $villa['sea_proximity'] === 'beachfront' ? 'ติดทะเล' : ($villa['sea_proximity'] === 'near_sea' ? 'ใกล้ทะเล' : 'ห่างทะเล');
} catch(Exception $e) {
    $error = "เกิดข้อผิดพลาด: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($villa['title'] ?? 'รายละเอียดวิลล่า'); ?> - Great Pool Villa</title>
    <link rel="icon" type="image/png" href="/images/favicon.png">
    <link rel="stylesheet" href="scss/pl_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- เพิ่ม FullCalendar CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
    <style>
        /* Hero Section */
        .villa-hero {
            position: relative;
            height: 60vh;
            background-image: url('<?php echo htmlspecialchars($villa['image'] ?? '/images/villa1.jpg'); ?>');
            background-size: auto 100%; /* ปรับให้ความสูงเต็ม 60vh และกว้างตามอัตโนมัติ */
            background-position: center; /* ภาพหลักอยู่ตรงกลาง */
            background-repeat: repeat-x; /* ซ้ำแนวนอนเพื่อต่อเติมสองข้าง */
            display: flex;
            align-items: center;
            justify-content: center;
            filter: brightness(100%); /* ความสว่างเต็มที่ */
        }
        .villa-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.1); /* Overlay มืดเล็กน้อย */
            z-index: 1;
        }
        .villa-hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 20px;
        }

        /* Villa Details */
        .villa-details {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
        }
        .villa-info {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .villa-info h2 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
        }
        .villa-info p {
            font-size: 1.5rem;
            margin: 15px 0;
            color: #555;
            line-height: 1.6;
        }
        .villa-info strong {
            color: #000;
            font-weight: 600;
        }
        .villa-title {
            font-size: 2.2rem;
            color: #007bff;
            margin-bottom: 25px;
        }
        .book-btn {
            display: inline-block;
            padding: 12px 25px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            transition: background 0.3s;
        }
        .book-btn:hover {
            background: #0056b3;
        }

        /* Exterior Gallery */
        .gallery-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .gallery-container h2 {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 15px;
        }
        .main-image-container {
            position: relative;
            width: 100%;
            max-width: 800px;
            height: 400px;
            margin-bottom: 20px;
        }
        .main-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            cursor: pointer;
            border: 2px solid #f0f0f0;
            transition: opacity 0.5s ease-in-out; /* เอฟเฟกต์ fade */
        }
        .main-prev, .main-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.3s;
            z-index: 10;
        }
        .main-prev:hover, .main-next:hover {
            background: rgba(0, 0, 0, 0.8);
        }
        .main-prev {
            left: 10px;
        }
        .main-next {
            right: 10px;
        }
        .no-images {
            font-size: 1rem;
            color: #888;
            text-align: center;
            padding: 20px;
        }

        /* Expanded Image Styles */
        .expanded-image-container {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        .expanded-image-container.active {
            display: flex;
        }
        .expanded-image {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
            border: 5px solid #fff;
            transition: opacity 0.5s ease-in-out; /* เอฟเฟกต์ fade */
        }
        .expanded-prev, .expanded-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.3);
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 20px;
            z-index: 1001;
            transition: background 0.3s;
        }
        .expanded-prev:hover, .expanded-next:hover {
            background: rgba(255, 255, 255, 0.6);
        }
        .expanded-prev {
            left: 20px;
        }
        .expanded-next {
            right: 20px;
        }
        .close-expanded {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.3);
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 18px;
            transition: background 0.3s;
        }
        .close-expanded:hover {
            background: rgba(255, 255, 255, 0.6);
        }

        /* Calendar Styles */
        .calendar-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .calendar-container h2 {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }
        #calendar {
            max-width: 100%;
        }
        .fc-daygrid-day {
            border: 1px solid #ddd;
        }
        .fc-daygrid-day-number {
            font-size: 1rem;
            color: #333;
        }
        .fc-event {
            border: none !important;
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 0.9rem;
            text-align: center;
        }
        .fc-event.available {
            background-color: #00ff00;
            color: #fff;
        }
        .fc-event.booked {
            background-color: #ff0000;
            color: #fff;
        }
        .fc-button {
            background-color: #007bff !important;
            border: none !important;
            border-radius: 5px !important;
            padding: 8px 15px !important;
            font-size: 1rem !important;
            transition: background 0.3s !important;
        }
        .fc-button:hover {
            background-color: #0056b3 !important;
        }
        .fc-today-button {
            background-color: #28a745 !important;
        }
        .fc-today-button:hover {
            background-color: #218838 !important;
        }

        @media (max-width: 768px) {
            .villa-hero {
                height: 40vh;
            }
            .villa-title {
                font-size: 1.8rem;
            }
            .main-image-container {
                height: 250px;
            }
            .main-prev, .main-next {
                width: 30px;
                height: 30px;
            }
            .villa-info p {
                font-size: 1.2rem;
            }
            .expanded-image {
                max-width: 95%;
                max-height: 95%;
            }
            .calendar-container {
                padding: 10px;
            }
            .fc-daygrid-day-number {
                font-size: 0.9rem;
            }
            .fc-event {
                font-size: 0.8rem;
            }
            .fc-button {
                padding: 6px 10px !important;
                font-size: 0.9rem !important;
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
                <li><a href="/reviews.php">รีวิวจากลูกค้า</a></li>
                <li><a href="/contactus.php">ติดต่อเรา</a></li>
            </ul>
        </nav>
    </header>

    <?php if (isset($error)): ?>
        <section class="villa-hero">
            <div class="villa-hero-content">
                <h1><?php echo $error; ?></h1>
                <p>กลับไปที่ <a href="/villas.php">รายการวิลล่า</a></p>
            </div>
        </section>
    <?php else: ?>
        <section class="villa-hero" style="background-image: url('<?php echo htmlspecialchars($villa['image'] ?? '/images/villa1.jpg'); ?>');">
            <div class="villa-hero-content">
                <!-- ยังคงว่างไว้เพื่อความยืดหยุ่น -->
            </div>
        </section>

        <section class="villa-details">
            <div class="villa-info">
                <h2>รายละเอียดวิลล่า</h2>
                <p class="villa-title">
                    <strong>รหัสวิลล่า: <?php echo htmlspecialchars($villa['villa_code'] ?? 'ไม่ระบุ') . ' ' . htmlspecialchars($villa['title'] ?? 'ไม่ระบุ') . ' ' . $sea_proximity_text . ' ' . htmlspecialchars($villa['location'] ?? 'ไม่ระบุ'); ?></strong>
                </p>
                <p><strong><?php echo htmlspecialchars($villa['bedrooms'] ?? 'ไม่ระบุ'); ?> ห้องนอน <?php echo htmlspecialchars($villa['bathrooms'] ?? 'ไม่ระบุ'); ?> ห้องน้ำ
                รองรับสูงสุดจำนวน: <?php echo htmlspecialchars($villa['capacity'] ?? 'ไม่ระบุ'); ?> ท่าน  </strong> </p>
                <p><strong>ราคาเริ่มต้น: <?php echo number_format($villa['price'], 0); ?> บาท/ คืน</strong></p>
                <p><strong>คำอธิบาย:</strong> <?php echo nl2br(htmlspecialchars($villa['description'] ?? 'ไม่ระบุ')); ?></p>
                <!-- Exterior Gallery -->
                <div class="gallery-container">
                    <h2>รูปภาพภายนอก</h2>
                    <?php if (!empty($exterior_images)): ?>
                        <div class="main-image-container">
                            <img src="<?php echo htmlspecialchars($exterior_images[0]['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($exterior_images[0]['caption'] ?? 'ภาพภายนอก'); ?>" 
                                 class="main-image"
                                 data-index="0">
                            <button class="main-prev"><i class="fas fa-chevron-left"></i></button>
                            <button class="main-next"><i class="fas fa-chevron-right"></i></button>
                        </div>
                        <div class="expanded-image-container">
                            <img src="" alt="" class="expanded-image" data-index="0">
                            <button class="expanded-prev"><i class="fas fa-chevron-left"></i></button>
                            <button class="expanded-next"><i class="fas fa-chevron-right"></i></button>
                            <button class="close-expanded">×</button>
                        </div>
                    <?php else: ?>
                        <div class="no-images">ไม่มีรูปภาพภายนอก</div>
                    <?php endif; ?>
                </div>

                <p><strong>สิ่งอำนวยความสะดวก:</strong> <?php echo nl2br(htmlspecialchars($villa['amenities'] ?? 'ไม่ระบุ')); ?></p>
                <p><strong>รายละเอียดห้องนอน:</strong> <?php echo nl2br(htmlspecialchars($villa['bedroom_details'] ?? 'ไม่ระบุ')); ?></p>
                <p><strong>บริการพิเศษ:</strong> <?php echo nl2br(htmlspecialchars($villa['extra_services'] ?? 'ไม่มีบริการพิเศษ')); ?></p>
                <p><strong>รายละเอียดราคา:</strong> <?php echo nl2br(htmlspecialchars($villa['price_details'] ?? 'ไม่มีข้อมูลเพิ่มเติม')); ?></p>
                <p><strong>รายละเอียดการจอง:</strong> <?php echo nl2br(htmlspecialchars($villa['booking_details'] ?? 'ไม่มีข้อมูลเพิ่มเติม')); ?></p>
                <p><strong>รับสัตว์เลี้ยง:</strong> <?php echo $villa['pet_allowed'] ? 'รับ' : 'ไม่รับ'; ?></p>
                <p><strong>เวลาเช็คอิน-เช็คเอาท์:</strong> <?php echo htmlspecialchars($villa['check_in_time'] ?? 'ไม่ระบุ') . ' - ' . htmlspecialchars($villa['check_out_time'] ?? 'ไม่ระบุ'); ?></p>
                <!-- Interior Gallery -->
                <div class="gallery-container">
                    <h2>รูปภาพภายใน</h2>
                    <?php if (!empty($interior_images)): ?>
                        <div class="main-image-container">
                            <img src="<?php echo htmlspecialchars($interior_images[0]['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($interior_images[0]['caption'] ?? 'ภาพภายใน'); ?>" 
                                 class="main-image interior-image"
                                 data-index="0">
                            <button class="main-prev interior-prev"><i class="fas fa-chevron-left"></i></button>
                            <button class="main-next interior-next"><i class="fas fa-chevron-right"></i></button>
                        </div>
                        <div class="expanded-image-container interior-expanded">
                            <img src="" alt="" class="expanded-image interior-expanded-image" data-index="0">
                            <button class="expanded-prev interior-expanded-prev"><i class="fas fa-chevron-left"></i></button>
                            <button class="expanded-next interior-expanded-next"><i class="fas fa-chevron-right"></i></button>
                            <button class="close-expanded interior-close-expanded">×</button>
                        </div>
                    <?php else: ?>
                        <div class="no-images">ไม่มีรูปภาพภายใน</div>
                    <?php endif; ?>
                </div>

                <!-- เพิ่มส่วนปฏิทิน -->
                <div class="calendar-container">
                    <h2>ปฏิทินวันว่าง</h2>
                    <div id="calendar"></div>
                </div>

                <p><strong>กฎระเบียบบ้านพัก:</strong> <?php echo nl2br(htmlspecialchars($villa['house_rules'] ?? 'ไม่มีกฎระเบียบเพิ่มเติม')); ?></p>
                <p><h1><strong>ติดต่อสอบถาม:</strong> <?php echo htmlspecialchars($villa['contact_info'] ?? 'โทร 089-9422914 หรือ info@greatpoolvilla.com'); ?></h1></p>
                <a href="#" onclick="bookVilla('<?php echo $villa_id; ?>')" class="book-btn">จองเลย</a>
            </div>
        </section>
    <?php endif; ?>
    <footer>
        <div class="footer-content">
            <p>© 2025 Great Pool Villa. สงวนลิขสิทธิ์.</p>
            <p>ติดต่อเรา: <a href="mailto:info@greatpoolvilla.com">info@greatpoolvilla.com</a> | โทร. <a href="tel:0899422914">089-9422914</a></p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- เพิ่ม FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script>
        function bookVilla(villaId) {
            alert('ระบบจองยังอยู่ในระหว่างการพัฒนา กรุณาติดต่อ 098 462 2914 คุณเมย์');
        }

        // ฟังก์ชันสำหรับ Exterior Images
        function updateMainImage(index, callback) {
            const mainImage = document.querySelector('.main-image:not(.interior-image)');
            const exterior_images = <?php echo json_encode(array_values($exterior_images)); ?>;
            if (index >= 0 && index < exterior_images.length) {
                mainImage.style.opacity = '0'; // Fade out
                setTimeout(() => {
                    mainImage.src = exterior_images[index]['image'];
                    mainImage.alt = exterior_images[index]['caption'] ?? 'ภาพภายนอก';
                    mainImage.setAttribute('data-index', index);
                    mainImage.style.opacity = '1'; // Fade in
                    if (callback) callback();
                }, 500); // รอ 0.5 วินาทีให้ fade out เสร็จ
            } else {
                console.error('Invalid image index for exterior:', index);
            }
        }

        function updateExpandedImage(index, callback) {
            const expandedImage = document.querySelector('.expanded-image:not(.interior-expanded-image)');
            const exterior_images = <?php echo json_encode(array_values($exterior_images)); ?>;
            if (index >= 0 && index < exterior_images.length) {
                expandedImage.style.opacity = '0'; // Fade out
                setTimeout(() => {
                    expandedImage.src = exterior_images[index]['image'];
                    expandedImage.alt = exterior_images[index]['caption'] ?? 'ภาพภายนอก';
                    expandedImage.setAttribute('data-index', index);
                    expandedImage.style.opacity = '1'; // Fade in
                    if (callback) callback();
                }, 500); // รอ 0.5 วินาทีให้ fade out เสร็จ
            } else {
                console.error('Invalid image index for exterior expanded:', index);
            }
        }

        // ฟังก์ชันสำหรับ Interior Images
        function updateInteriorMainImage(index, callback) {
            const mainImage = document.querySelector('.interior-image');
            const interior_images = <?php echo json_encode(array_values($interior_images)); ?>;
            if (index >= 0 && index < interior_images.length) {
                mainImage.style.opacity = '0'; // Fade out
                setTimeout(() => {
                    mainImage.src = interior_images[index]['image'];
                    mainImage.alt = interior_images[index]['caption'] ?? 'ภาพภายใน';
                    mainImage.setAttribute('data-index', index);
                    mainImage.style.opacity = '1'; // Fade in
                    if (callback) callback();
                }, 500); // รอ 0.5 วินาทีให้ fade out เสร็จ
            } else {
                console.error('Invalid image index for interior:', index);
            }
        }

        function updateInteriorExpandedImage(index, callback) {
            const expandedImage = document.querySelector('.interior-expanded-image');
            const interior_images = <?php echo json_encode(array_values($interior_images)); ?>;
            if (index >= 0 && index < interior_images.length) {
                expandedImage.style.opacity = '0'; // Fade out
                setTimeout(() => {
                    expandedImage.src = interior_images[index]['image'];
                    expandedImage.alt = interior_images[index]['caption'] ?? 'ภาพภายใน';
                    expandedImage.setAttribute('data-index', index);
                    expandedImage.style.opacity = '1'; // Fade in
                    if (callback) callback();
                }, 500); // รอ 0.5 วินาทีให้ fade out เสร็จ
            } else {
                console.error('Invalid image index for interior expanded:', index);
            }
        }

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

            // Exterior Images
            const mainImage = document.querySelector('.main-image:not(.interior-image)');
            const mainPrev = document.querySelector('.main-prev:not(.interior-prev)');
            const mainNext = document.querySelector('.main-next:not(.interior-next)');
            const expandedContainer = document.querySelector('.expanded-image-container:not(.interior-expanded)');
            const expandedImage = document.querySelector('.expanded-image:not(.interior-expanded-image)');
            const expandedPrev = document.querySelector('.expanded-prev:not(.interior-expanded-prev)');
            const expandedNext = document.querySelector('.expanded-next:not(.interior-expanded-next)');
            const closeExpanded = document.querySelector('.close-expanded:not(.interior-close-expanded)');
            const exteriorImagesCount = <?php echo count($exterior_images); ?>;

            // ตรวจสอบและโหลดภาพเริ่มต้น (Exterior)
            if (exteriorImagesCount > 0) {
                updateMainImage(0); // โหลดภาพแรกทันที
            } else {
                console.warn('No exterior images available to display.');
                if (mainPrev) mainPrev.style.display = 'none';
                if (mainNext) mainNext.style.display = 'none';
                if (expandedContainer) expandedContainer.style.display = 'none';
            }

            // การเลื่อนด้วยลูกศรในภาพปกติ (Exterior)
            if (mainPrev && mainNext) {
                mainPrev.addEventListener('click', () => {
                    let currentIndex = parseInt(mainImage.getAttribute('data-index') || 0);
                    currentIndex = (currentIndex - 1 + exteriorImagesCount) % exteriorImagesCount;
                    updateMainImage(currentIndex);
                });

                mainNext.addEventListener('click', () => {
                    let currentIndex = parseInt(mainImage.getAttribute('data-index') || 0);
                    currentIndex = (currentIndex + 1) % exteriorImagesCount;
                    updateMainImage(currentIndex);
                });
            }

            // เปิดภาพขยายเมื่อคลิก (Exterior)
            if (mainImage) {
                mainImage.addEventListener('click', () => {
                    if (exteriorImagesCount > 0) {
                        const currentIndex = parseInt(mainImage.getAttribute('data-index') || 0);
                        updateExpandedImage(currentIndex, () => {
                            expandedContainer.classList.add('active');
                        });
                    }
                });
            }

            // เลื่อนภาพในโหมดขยาย (Exterior)
            if (expandedPrev && expandedNext) {
                expandedPrev.addEventListener('click', () => {
                    let currentIndex = parseInt(expandedImage.getAttribute('data-index') || 0);
                    currentIndex = (currentIndex - 1 + exteriorImagesCount) % exteriorImagesCount;
                    updateExpandedImage(currentIndex);
                });

                expandedNext.addEventListener('click', () => {
                    let currentIndex = parseInt(expandedImage.getAttribute('data-index') || 0);
                    currentIndex = (currentIndex + 1) % exteriorImagesCount;
                    updateExpandedImage(currentIndex);
                });
            }

            // ปิดภาพขยาย (Exterior)
            if (closeExpanded) {
                closeExpanded.addEventListener('click', () => {
                    expandedContainer.classList.remove('active');
                });
            }

            // ปิดเมื่อคลิกที่พื้นหลัง (Exterior)
            expandedContainer.addEventListener('click', (e) => {
                if (e.target === expandedContainer) {
                    expandedContainer.classList.remove('active');
                }
            });

            // Interior Images
            const interiorMainImage = document.querySelector('.interior-image');
            const interiorMainPrev = document.querySelector('.interior-prev');
            const interiorMainNext = document.querySelector('.interior-next');
            const interiorExpandedContainer = document.querySelector('.interior-expanded');
            const interiorExpandedImage = document.querySelector('.interior-expanded-image');
            const interiorExpandedPrev = document.querySelector('.interior-expanded-prev');
            const interiorExpandedNext = document.querySelector('.interior-expanded-next');
            const interiorCloseExpanded = document.querySelector('.interior-close-expanded');
            const interiorImagesCount = <?php echo count($interior_images); ?>;

            // ตรวจสอบและโหลดภาพเริ่มต้น (Interior)
            if (interiorImagesCount > 0) {
                updateInteriorMainImage(0); // โหลดภาพแรกทันที
            } else {
                console.warn('No interior images available to display.');
                if (interiorMainPrev) interiorMainPrev.style.display = 'none';
                if (interiorMainNext) interiorMainNext.style.display = 'none';
                if (interiorExpandedContainer) interiorExpandedContainer.style.display = 'none';
            }

            // การเลื่อนด้วยลูกศรในภาพปกติ (Interior)
            if (interiorMainPrev && interiorMainNext) {
                interiorMainPrev.addEventListener('click', () => {
                    let currentIndex = parseInt(interiorMainImage.getAttribute('data-index') || 0);
                    currentIndex = (currentIndex - 1 + interiorImagesCount) % interiorImagesCount;
                    updateInteriorMainImage(currentIndex);
                });

                interiorMainNext.addEventListener('click', () => {
                    let currentIndex = parseInt(interiorMainImage.getAttribute('data-index') || 0);
                    currentIndex = (currentIndex + 1) % interiorImagesCount;
                    updateInteriorMainImage(currentIndex);
                });
            }

            // เปิดภาพขยายเมื่อคลิก (Interior)
            if (interiorMainImage) {
                interiorMainImage.addEventListener('click', () => {
                    if (interiorImagesCount > 0) {
                        const currentIndex = parseInt(interiorMainImage.getAttribute('data-index') || 0);
                        updateInteriorExpandedImage(currentIndex, () => {
                            interiorExpandedContainer.classList.add('active');
                        });
                    }
                });
            }

            // เลื่อนภาพในโหมดขยาย (Interior)
            if (interiorExpandedPrev && interiorExpandedNext) {
                interiorExpandedPrev.addEventListener('click', () => {
                    let currentIndex = parseInt(interiorExpandedImage.getAttribute('data-index') || 0);
                    currentIndex = (currentIndex - 1 + interiorImagesCount) % interiorImagesCount;
                    updateInteriorExpandedImage(currentIndex);
                });

                interiorExpandedNext.addEventListener('click', () => {
                    let currentIndex = parseInt(interiorExpandedImage.getAttribute('data-index') || 0);
                    currentIndex = (currentIndex + 1) % interiorImagesCount;
                    updateInteriorExpandedImage(currentIndex);
                });
            }

            // ปิดภาพขยาย (Interior)
            if (interiorCloseExpanded) {
                interiorCloseExpanded.addEventListener('click', () => {
                    interiorExpandedContainer.classList.remove('active');
                });
            }

            // ปิดเมื่อคลิกที่พื้นหลัง (Interior)
            interiorExpandedContainer.addEventListener('click', (e) => {
                if (e.target === interiorExpandedContainer) {
                    interiorExpandedContainer.classList.remove('active');
                }
            });

            // เพิ่มการเริ่มต้นปฏิทิน
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: '/get_availability.php?villa_id=<?php echo $villa_id; ?>',
                eventClassNames: function(arg) {
                    if (arg.event.title === 'ว่าง') {
                        return ['available'];
                    } else if (arg.event.title === 'จองแล้ว') {
                        return ['booked'];
                    }
                    return [];
                },
                eventClick: function(info) {
                    alert('วันที่: ' + info.event.start.toISOString().split('T')[0] + '\nสถานะ: ' + info.event.title);
                },
                locale: 'th', // ตั้งค่าให้เป็นภาษาไทย
                firstDay: 1, // เริ่มต้นสัปดาห์ด้วยวันจันทร์
                height: 'auto',
                buttonText: {
                    today: 'วันนี้',
                    month: 'เดือน',
                    week: 'สัปดาห์',
                    day: 'วัน'
                },
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                }
            });
            calendar.render();
        });
    </script>
</body>
</html>