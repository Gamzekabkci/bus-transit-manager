<?php
require_once "tema.php";
require_once "veritabani.php";

$title = "Yeni Sefer Ekle";
head_ustkisim($title);
navbar();

$errors = [];
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $guzergahId = (int)$_POST['guzergahId'];
    $soforId = (int)$_POST['soforId'];
    $aracId = (int)$_POST['aracId'];
    $seferTarihi = $_POST['seferTarihi'];
    $kalkisSaati = $_POST['kalkisSaati'];
    $varisSaati = $_POST['varisSaati'];

    if ($guzergahId <= 0) $errors[] = "Lütfen geçerli bir güzergah seçin.";
    if ($soforId <= 0) $errors[] = "Lütfen geçerli bir şoför seçin.";
    if ($aracId <= 0) $errors[] = "Lütfen geçerli bir araç seçin.";
    if (empty($seferTarihi)) $errors[] = "Sefer tarihi giriniz.";
    if (empty($kalkisSaati)) $errors[] = "Kalkış saati giriniz.";
    if (empty($varisSaati)) $errors[] = "Varış saati giriniz.";

    if (count($errors) === 0) {
        $sql = "INSERT INTO Seferler (GuzergahID, SoforID, AracID, SeferTarihi, KalkisSaati, VarisSaati)
                VALUES (?, ?, ?, ?, ?, ?)";
        $params = [$guzergahId, $soforId, $aracId, $seferTarihi, $kalkisSaati, $varisSaati];

        $stmt = sqlsrv_query($conn, $sql, $params);
        if ($stmt === false) {
            $errors[] = "Sefer eklenirken hata oluştu: " . print_r(sqlsrv_errors(), true);
        } else {
            $success = "Sefer başarıyla eklendi.";
        }
    }
}

$sqlGuzergahlar = "SELECT GuzergahID, GuzergahAdi FROM Guzergahlar ORDER BY GuzergahAdi";
$stmtGuzergahlar = sqlsrv_query($conn, $sqlGuzergahlar);
$guzergahlar = [];
if ($stmtGuzergahlar !== false) {
    while ($row = sqlsrv_fetch_array($stmtGuzergahlar, SQLSRV_FETCH_ASSOC)) {
        $guzergahlar[] = $row;
    }
}

$sqlSoforlar = "SELECT SoforID, Ad, Soyad FROM Soforler ORDER BY Ad, Soyad";
$stmtSoforlar = sqlsrv_query($conn, $sqlSoforlar);
$soforlar = [];
if ($stmtSoforlar !== false) {
    while ($row = sqlsrv_fetch_array($stmtSoforlar, SQLSRV_FETCH_ASSOC)) {
        $soforlar[] = $row;
    }
}

$sqlAraclar = "SELECT AracID, PlakaNumarasi FROM Araclar ORDER BY PlakaNumarasi";
$stmtAraclar = sqlsrv_query($conn, $sqlAraclar);
$araclar = [];
if ($stmtAraclar !== false) {
    while ($row = sqlsrv_fetch_array($stmtAraclar, SQLSRV_FETCH_ASSOC)) {
        $araclar[] = $row;
    }
}
?>

<div class="form-section">
    <h2>Yeni Sefer Ekle</h2>

    <?php if (!empty($errors)): ?>
        <div style="color:red;">
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <p style="color:green;"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <form method="post">
        <label for="guzergahId">Güzergah:</label><br>
        <select name="guzergahId" id="guzergahId" required>
            <option value="">Seçiniz</option>
            <?php foreach ($guzergahlar as $g): ?>
                <option value="<?= $g['GuzergahID'] ?>"><?= htmlspecialchars($g['GuzergahAdi']) ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="soforId">Şoför:</label><br>
        <select name="soforId" id="soforId" required>
            <option value="">Seçiniz</option>
            <?php foreach ($soforlar as $s): ?>
                <option value="<?= $s['SoforID'] ?>">
                    <?= htmlspecialchars($s['Ad'] . ' ' . $s['Soyad']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="aracId">Araç (Plaka):</label><br>
        <select name="aracId" id="aracId" required>
            <option value="">Seçiniz</option>
            <?php foreach ($araclar as $a): ?>
                <option value="<?= $a['AracID'] ?>"><?= htmlspecialchars($a['PlakaNumarasi']) ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="seferTarihi">Sefer Tarihi:</label><br>
        <input type="date" name="seferTarihi" id="seferTarihi" required><br><br>

        <label for="kalkisSaati">Kalkış Saati:</label><br>
        <input type="time" name="kalkisSaati" id="kalkisSaati" required><br><br>

        <label for="varisSaati">Varış Saati:</label><br>
        <input type="time" name="varisSaati" id="varisSaati" required><br><br>

        <button type="submit">Sefer Ekle</button>
    </form>
</div>


<script>
  function openLogout() {
    document.getElementById('logout-modal').style.display = 'flex';
  }

  function closeLogout() {
    document.getElementById('logout-modal').style.display = 'none';
  }

  function confirmLogout() {
    alert('Çıkış yapıldı.');
    window.location.href = 'girişekranı.php';
  }
</script>
