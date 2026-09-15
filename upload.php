<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['media'])) {
    header('Location: index.php#upload'); exit;
}

$uploader = trim($_POST['uploader'] ?? '');
$title = trim($_POST['title'] ?? '');
$category = $_POST['category'] ?? 'lainnya';
$type = $_POST['type'] ?? 'photo';

$jurusan = strtoupper(trim((string)($_POST['jurusan'] ?? ($_SESSION['vortexus_class'] ?? 'LAINNYA'))));
$allowedJurusan = ['PPLDG26','OTOMOTIF26','ATPH26','BUSANA26','LAINNYA'];
if (!in_array($jurusan, $allowedJurusan, true)) $jurusan = 'LAINNYA';
$file = $_FILES['media'];

if ($uploader === '' || $title === '' || $file['error'] !== UPLOAD_ERR_OK) {
    header('Location: index.php?error=Data+upload+tidak+lengkap#upload'); exit;
}

$allowed = [
  'photo' => ['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'],
  'video' => ['video/mp4'=>'mp4','video/webm'=>'webm','video/quicktime'=>'mov']
];

if (!isset($allowed[$type])) $type='photo';
$max = $type === 'photo' ? 10*1024*1024 : 100*1024*1024;
if ($file['size'] > $max) {
    header('Location: index.php?error=Ukuran+file+terlalu+besar#upload'); exit;
}

$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->file($file['tmp_name']);
if (!isset($allowed[$type][$mime])) {
    header('Location: index.php?error=Format+file+tidak+didukung#upload'); exit;
}

$ext = $allowed[$type][$mime];
$name = bin2hex(random_bytes(12)) . '.' . $ext;
$dir = __DIR__ . '/uploads/' . ($type === 'photo' ? 'photos' : 'videos') . '/';
if (!is_dir($dir)) mkdir($dir, 0755, true);
$relative = 'uploads/' . ($type === 'photo' ? 'photos/' : 'videos/') . $name;

if (!move_uploaded_file($file['tmp_name'], __DIR__ . '/' . $relative)) {
    header('Location: index.php?error=Gagal+menyimpan+file#upload'); exit;
}

$stmt = $pdo->prepare("INSERT INTO media (title,uploader,category,type,jurusan,file_path) VALUES (?,?,?,?,?,?)");
$stmt->execute([$title,$uploader,$category,$type,$jurusan,$relative]);

header('Location: index.php?success=1#upload');
?>
