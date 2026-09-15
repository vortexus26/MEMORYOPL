<?php
require_once __DIR__ . '/auth.php';

if (isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$error = '';
$selectedClass = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedClass = trim((string)($_POST['class_name'] ?? ''));
    $password = (string)($_POST['class_password'] ?? '');

    if (attemptLogin($selectedClass, $password)) {
        header('Location: index.php');
        exit;
    }

    $error = 'Kelas atau password salah. Silakan coba lagi.';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<meta name="robots" content="noindex,nofollow">
<title>Login — VORTEXUS 26</title>
<link rel="stylesheet" href="assets/css/style.css?v=20260916">
</head>
<body class="login-page">
<main class="login-shell">
  <section class="login-card">
    <div class="login-logos">
      <img src="assets/images/logo-vortexus.png" alt="Logo VORTEXUS 26">
      <img src="assets/images/logo-smkn1.png" alt="Logo SMK Negeri 1 Patokbeusi">
    </div>

    <span class="eyebrow">PRIVATE MEMORY ARCHIVE</span>
    <h1>Masuk ke VORTEXUS 26</h1>
    <p class="login-subtitle">Halaman ini khusus warga VORTEXUS 26.<br>Pilih kelas dan masukkan password untuk masuk.</p>

    <?php if ($error): ?>
      <div class="notice error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <form method="POST" class="login-form" autocomplete="off">
      <label for="class_name">Kelas
        <select name="class_name" id="class_name" required>
          <option value="" disabled <?= $selectedClass === '' ? 'selected' : '' ?>>Pilih kelas kamu</option>
          <option value="PPLDG26" <?= $selectedClass === 'PPLDG26' ? 'selected' : '' ?>>PPLDG 26</option>
          <option value="OTOMOTIF26" <?= $selectedClass === 'OTOMOTIF26' ? 'selected' : '' ?>>OTOMOTIF 26</option>
          <option value="ATPH26" <?= $selectedClass === 'ATPH26' ? 'selected' : '' ?>>ATPH 26</option>
          <option value="BUSANA26" <?= $selectedClass === 'BUSANA26' ? 'selected' : '' ?>>BUSANA 26</option>
        </select>
      </label>

      <label for="class_password">Password kelas
        <div class="password-wrap">
          <input type="password" name="class_password" id="class_password" placeholder="Masukkan password kelas" required>
          <button type="button" class="password-toggle" onclick="togglePassword()" aria-label="Tampilkan password">👁</button>
        </div>
      </label>

      <button class="btn primary login-btn" type="submit">🔐 Masuk ke VORTEXUS</button>
    </form>

    <div class="class-hint">
      <span>PPLDG26</span><span>OTOMOTIF26</span><span>ATPH26</span><span>BUSANA26</span>
    </div>
    <small class="login-note">Password awal setiap kelas = nama kelas + angkatan</small>
  </section>
</main>
<script>
function togglePassword(){
  const input=document.getElementById('class_password');
  const button=document.querySelector('.password-toggle');
  if(input.type==='password'){input.type='text';button.textContent='🙈';}
  else{input.type='password';button.textContent='👁';}
}
</script>
</body>
</html>
