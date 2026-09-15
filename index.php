<?php
require_once __DIR__ . '/auth.php';
requireLogin();
require_once __DIR__ . '/config.php';

$photos = $pdo->query("SELECT * FROM media WHERE type='photo' AND status='approved' ORDER BY created_at DESC")->fetchAll();
$videos = $pdo->query("SELECT * FROM media WHERE type='video' AND status='approved' ORDER BY created_at DESC")->fetchAll();
$jurusanLabels = [
  'PPLDG26' => 'PPLDG 26',
  'OTOMOTIF26' => 'OTOMOTIF 26',
  'ATPH26' => 'ATPH 26',
  'BUSANA26' => 'BUSANA 26',
  'LAINNYA' => 'Lainnya'
];
$photoCount = count($photos);
$videoCount = count($videos);
$totalMemory = $photoCount + $videoCount;
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>VORTEXUS 26 — SMK Negeri 1 Patokbeusi</title>
<link rel="stylesheet" href="assets/css/style.css?v=20260916">
</head>
<body>
<header class="navbar">
  <a class="brand" href="#">
    <img src="assets/images/logo-vortexus.png" alt="VORTEXUS">
    <div><b>VORTEXUS 26</b><span>SMK NEGERI 1 PATOKBEUSI</span></div>
  </a>
  <nav>
    <a href="#home">Beranda</a>
    <a href="#foto">Foto</a>
    <a href="#video">Video</a>
    <a href="#tentang">Tentang</a>
  </nav>
  <div class="social-mini"><span class="account-pill">🔐 <?= htmlspecialchars($_SESSION['vortexus_class'] ?? '', ENT_QUOTES, 'UTF-8') ?></span><a class="logout-btn" href="logout.php">🚪 Keluar</a>
    <a href="https://www.tiktok.com/@vortexus15" target="_blank">TikTok</a>
    <a href="https://www.instagram.com/vortexusxv/" target="_blank">Instagram</a>
  </div>
</header>

<main>
<section id="home" class="hero">
  <div class="hero-bg"></div>
  <div class="hero-content">
    <div class="hero-logos">
      <img src="assets/images/logo-vortexus.png" alt="Logo VORTEXUS">
      <img src="assets/images/logo-smkn1.png" alt="Logo SMK Negeri 1 Patokbeusi">
    </div>
    <p class="eyebrow">ANGKATAN 2023 — 2026</p>
    <h1>VORTEXUS <strong>26</strong></h1>
    <h2>SMK NEGERI 1 PATOKBEUSI</h2>
    <p class="tagline">Satu Angkatan, Sejuta Cerita.</p>
    <div class="hero-actions">
      <a class="btn primary" href="#foto">Lihat Kenangan</a>
      <a class="btn ghost" href="#upload">Tambah Foto / Video</a>
    </div>
  </div>
</section>

<section class="intro">
  <div>
    <span class="eyebrow">MEMORY ARCHIVE</span>
    <h2>Abadikan momen, jangan lupa ceritanya.</h2>
    <p>Website kenangan VORTEXUS 26 untuk menyimpan foto, video, kegiatan, dan cerita satu angkatan. Siapa pun dari angkatan kita bisa ikut menambahkan kenangan.</p>
    <div class="memory-stats">
      <div><strong><?= $totalMemory ?></strong><span>Total Kenangan</span></div>
      <div><strong><?= $photoCount ?></strong><span>Foto</span></div>
      <div><strong><?= $videoCount ?></strong><span>Video</span></div>
    </div>
  </div>
  <div class="social-cards">
    <a href="https://www.tiktok.com/@vortexus15" target="_blank"><span>♪</span><b>@vortexus15</b><small>TikTok</small></a>
    <a href="https://www.instagram.com/vortexusxv/" target="_blank"><span>◎</span><b>@vortexusxv</b><small>Instagram</small></a>
  </div>
</section>

<section id="foto" class="gallery-section">
  <div class="section-head">
    <div><span class="eyebrow">PHOTO ARCHIVE</span><h2>📸 Foto Kenangan</h2></div>
    <a class="btn primary small" href="#upload">＋ Unggah Foto</a>
  </div>
  <div class="gallery-tools">
    <label class="search-box">🔎 <input type="search" class="gallery-search" data-grid="photoGrid" placeholder="Cari judul atau nama pengunggah..."></label>
    <button type="button" class="btn ghost small random-btn" data-grid="photoGrid">🎲 Acak Kenangan</button>
  </div>
  <div class="filter-group">
    <span class="filter-label">Kategori</span>
    <div class="filter" data-target="photos-category">
      <button class="active" data-filter="all">Semua</button>
      <button data-filter="sekolah">Kegiatan Sekolah</button>
      <button data-filter="kebersamaan">Kebersamaan</button>
      <button data-filter="acara">Acara</button>
      <button data-filter="lainnya">Lainnya</button>
    </div>
  </div>
  <div class="filter-group">
    <span class="filter-label">Jurusan / Angkatan</span>
    <div class="filter" data-target="photos-jurusan">
      <button class="active" data-filter="all">Semua Jurusan</button>
      <button data-filter="PPLDG26">PPLDG 26</button>
      <button data-filter="OTOMOTIF26">OTOMOTIF 26</button>
      <button data-filter="ATPH26">ATPH 26</button>
      <button data-filter="BUSANA26">BUSANA 26</button>
      <button data-filter="LAINNYA">Lainnya</button>
    </div>
  </div>
  <div class="grid" id="photoGrid">
    <?php foreach ($photos as $m): ?>
      <article class="media-card" data-category="<?= htmlspecialchars($m['category']) ?>" data-jurusan="<?= htmlspecialchars($m['jurusan'] ?? 'LAINNYA') ?>" data-search="<?= htmlspecialchars(strtolower($m['title'].' '.$m['uploader'].' '.($jurusanLabels[$m['jurusan'] ?? 'LAINNYA'] ?? ''))) ?>">
        <button type="button" class="media-open" data-src="<?= htmlspecialchars($m['file_path']) ?>" data-title="<?= htmlspecialchars($m['title']) ?>" aria-label="Buka foto">
          <img src="<?= htmlspecialchars($m['file_path']) ?>" alt="<?= htmlspecialchars($m['title']) ?>" loading="lazy">
        </button>
        <div class="card-info"><div><b><?= htmlspecialchars($m['title']) ?></b><span><?= htmlspecialchars($m['uploader']) ?> · <?= htmlspecialchars(date('d M Y', strtotime($m['created_at']))) ?></span></div><em><?= htmlspecialchars($jurusanLabels[$m['jurusan'] ?? 'LAINNYA'] ?? 'Lainnya') ?></em></div>
      </article>
    <?php endforeach; ?>
    <?php if (!$photos): ?><div class="empty">Belum ada foto. Jadilah yang pertama mengunggah! 📸</div><?php endif; ?>
  </div>
</section>

<section id="video" class="gallery-section">
  <div class="section-head">
    <div><span class="eyebrow">VIDEO ARCHIVE</span><h2>🎬 Video Kenangan</h2></div>
    <a class="btn primary small" href="#upload">＋ Unggah Video</a>
  </div>
  <div class="gallery-tools">
    <label class="search-box">🔎 <input type="search" class="gallery-search" data-grid="videoGrid" placeholder="Cari judul atau nama pengunggah..."></label>
    <button type="button" class="btn ghost small random-btn" data-grid="videoGrid">🎲 Acak Video</button>
  </div>

  <div class="filter-group">
    <span class="filter-label">Kategori</span>
    <div class="filter" data-target="videos-category">
      <button class="active" data-filter="all">Semua</button>
      <button data-filter="sekolah">Kegiatan Sekolah</button>
      <button data-filter="kebersamaan">Kebersamaan</button>
      <button data-filter="acara">Acara</button>
      <button data-filter="lainnya">Lainnya</button>
    </div>
  </div>
  <div class="filter-group">
    <span class="filter-label">Jurusan / Angkatan</span>
    <div class="filter" data-target="videos-jurusan">
      <button class="active" data-filter="all">Semua Jurusan</button>
      <button data-filter="PPLDG26">PPLDG 26</button>
      <button data-filter="OTOMOTIF26">OTOMOTIF 26</button>
      <button data-filter="ATPH26">ATPH 26</button>
      <button data-filter="BUSANA26">BUSANA 26</button>
      <button data-filter="LAINNYA">Lainnya</button>
    </div>
  </div>
  <div class="grid video-grid" id="videoGrid">
    <?php foreach ($videos as $m): ?>
      <article class="media-card" data-category="<?= htmlspecialchars($m['category']) ?>" data-jurusan="<?= htmlspecialchars($m['jurusan'] ?? 'LAINNYA') ?>" data-search="<?= htmlspecialchars(strtolower($m['title'].' '.$m['uploader'].' '.($jurusanLabels[$m['jurusan'] ?? 'LAINNYA'] ?? ''))) ?>">
        <video controls preload="metadata" src="<?= htmlspecialchars($m['file_path']) ?>"></video>
        <div class="card-info"><div><b><?= htmlspecialchars($m['title']) ?></b><span><?= htmlspecialchars($m['uploader']) ?> · <?= htmlspecialchars(date('d M Y', strtotime($m['created_at']))) ?></span></div><em><?= htmlspecialchars($jurusanLabels[$m['jurusan'] ?? 'LAINNYA'] ?? 'Lainnya') ?></em></div>
      </article>
    <?php endforeach; ?>
    <?php if (!$videos): ?><div class="empty">Belum ada video. Upload momen terbaikmu! 🎬</div><?php endif; ?>
  </div>
</section>

<section id="upload" class="upload-section">
  <div class="upload-box">
    <span class="eyebrow">SHARE YOUR MEMORY</span>
    <h2>Tambah kenangan VORTEXUS 26</h2>
    <p>Foto/video yang kamu upload akan muncul di galeri setelah disetujui admin.</p>
    <?php if(isset($_GET['success'])): ?><div class="notice success">Upload berhasil! 🎉</div><?php endif; ?>
    <?php if(isset($_GET['error'])): ?><div class="notice error"><?= htmlspecialchars($_GET['error']) ?></div><?php endif; ?>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
      <div class="form-grid">
        <label>Nama kamu<input type="text" name="uploader" maxlength="80" required placeholder="Contoh: Jali"></label>
        <label>Judul kenangan<input type="text" name="title" maxlength="120" required placeholder="Contoh: Foto Bareng Setelah Kelulusan"></label>
        <label>Kategori
          <select name="category">
            <option value="sekolah">Kegiatan Sekolah</option>
            <option value="kebersamaan">Kebersamaan</option>
            <option value="acara">Acara</option>
            <option value="lainnya">Lainnya</option>
          </select>
        </label>
        <label>Jenis file
          <select name="type" id="typeSelect">
            <option value="photo">Foto</option>
            <option value="video">Video</option>
          </select>
        </label>
        <label>Jurusan / Angkatan
          <select name="jurusan" id="jurusanSelect" required>
            <?php foreach ($jurusanLabels as $code => $label): ?>
              <option value="<?= htmlspecialchars($code) ?>" <?= (($_SESSION['vortexus_class'] ?? '') === $code) ? 'selected' : '' ?>><?= htmlspecialchars($label) ?></option>
            <?php endforeach; ?>
          </select>
          <small class="hint">Pilih jurusan yang sesuai dengan kenangan yang kamu upload.</small>
        </label>
      </div>
      <label class="file-label">Pilih file
        <input type="file" name="media" id="mediaInput" accept="image/jpeg,image/png,image/webp" required>
      </label>
      <div id="preview" class="preview"></div>
      <button class="btn primary upload-btn" type="submit">🚀 Upload Kenangan</button>
      <small class="hint">Foto: JPG/PNG/WEBP maksimal 10 MB. Video: MP4/MOV/WEBM maksimal 100 MB.</small>
    </form>
  </div>
</section>

<section id="tentang" class="about">
  <img src="assets/images/logo-smkn1.png" alt="SMK Negeri 1 Patokbeusi">
  <div><span class="eyebrow">VORTEXUS 26</span><h2>Dari Patokbeusi, untuk masa depan.</h2><p>Tempat kita menyimpan momen sebelum semuanya menjadi cerita. FOTO • VIDEO • KENANGAN • SELAMANYA.</p></div>
</section>
</main>

<div class="lightbox" id="lightbox" aria-hidden="true">
  <button class="lightbox-close" type="button" aria-label="Tutup">×</button>
  <img id="lightboxImage" src="" alt="">
  <div id="lightboxTitle"></div>
</div>

<footer>© 2026 VORTEXUS 26 — SMK NEGERI 1 PATOKBEUSI · <a href="admin/" style="color:inherit">Panel Admin</a></footer>
<script src="assets/js/script.js?v=20260916"></script>
</body>
</html>
