<?php
require_once 'config.php';

$villa_id = isset($_GET['villa_id']) ? (int)$_GET['villa_id'] : 0;

// ดึง URL ของ Google Sheets จากตาราง villas
$stmt = $conn->prepare("SELECT google_sheets_url FROM villas WHERE id = :id");
$stmt->execute([':id' => $villa_id]);
$villa = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$villa || empty($villa['google_sheets_url'])) {
    echo json_encode(['error' => 'ไม่พบ Google Sheets URL']);
    exit;
}

// ดึง Spreadsheet ID จาก URL
preg_match('/\/d\/(.+?)\//', $villa['google_sheets_url'], $matches);
$spreadsheet_id = $matches[1] ?? '';
if (empty($spreadsheet_id)) {
    echo json_encode(['error' => 'Spreadsheet ID ไม่ถูกต้อง']);
    exit;
}

// ดึงข้อมูลจาก Google Sheets API
$range = 'Sheet1!A:B'; // ปรับตามชื่อ Sheet และ Range
$url = "https://sheets.googleapis.com/v4/spreadsheets/$spreadsheet_id/values/$range?key=" . GOOGLE_API_KEY;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

if (isset($data['values'])) {
    $events = [];
    $rows = $data['values'];
    array_shift($rows); // ลบส่วนหัว

    foreach ($rows as $row) {
        if (count($row) >= 2) {
            $date = $row[0]; // วันที่
            $status = strtolower($row[1]); // สถานะ (available/booked)
            $events[] = [
                'start' => $date,
                'end' => $date,
                'title' => $status == 'booked' ? 'จองแล้ว' : 'ว่าง',
                'color' => $status == 'booked' ? '#ff0000' : '#00ff00' // แดง = จองแล้ว, เขียว = ว่าง
            ];
        }
    }
    echo json_encode($events);
} else {
    echo json_encode(['error' => 'ไม่สามารถดึงข้อมูลจาก Google Sheets ได้']);
}
?>