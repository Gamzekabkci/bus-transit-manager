<?php
require_once "tema.php";
require_once "veritabani.php";

$title = "Sefer Listesi";
head_ustkisim($title);
navbar();

// Sefer bilgilerini al
$sql = "SELECT 
    s.SeferID,
    a.PlakaNumarasi,
    so.Ad AS SoforAd,
    so.Soyad AS SoforSoyad,
    g.GuzergahAdi,
    s.SeferTarihi,
    s.KalkisSaati
FROM Seferler s
INNER JOIN Araclar a ON s.AracID = a.AracID
INNER JOIN Soforler so ON s.SoforID = so.SoforID
INNER JOIN Guzergahlar g ON s.GuzergahID = g.GuzergahID
ORDER BY s.SeferTarihi, s.KalkisSaati
";

$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// HTML Başlangıcı
echo '<div class="main-content">
        <div class="dashboard">
        <h3>📅 Sefer Takvimi</h3>
        <table >
          <thead>
            <tr>
              <th>Sefer No</th>
              <th>Plaka</th>
              <th>Şoför Adı</th>
              <th>Şoför Soyadı</th>
              <th>Güzergah</th>
              <th>Sefer Tarihi</th>
              <th>Kalkış Saati</th>
              <th>Duraklar</th>
            </tr>
          </thead>
          <tbody>';

// Her sefer için satırları ve durakları yaz
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $seferID = $row['SeferID'];

    // Durak bilgileri (JOIN ile DurakAdı'nı çekiyoruz)
    $sqlDuraklar = "SELECT d.DurakID, dur.DurakAdi, d.VarisSaati, d.KalkisSaati
    FROM SeferDuraklari d
    INNER JOIN Duraklar dur ON d.DurakID = dur.DurakID
    WHERE d.SeferID = ?
    ORDER BY d.DurakSiraNo
    ";
    $durakStmt = sqlsrv_query($conn, $sqlDuraklar, [$seferID]);

    $duraklarHTML = "<ol>";
    while ($durak = sqlsrv_fetch_array($durakStmt, SQLSRV_FETCH_ASSOC)) {
        $varis = $durak['VarisSaati'] ? $durak['VarisSaati']->format('H:i') : "-";
        $kalkis = $durak['KalkisSaati'] ? $durak['KalkisSaati']->format('H:i') : "-";

        $duraklarHTML .= "<li>" . htmlspecialchars($durak['DurakAdi']) . 
                         " - Varış: {$varis} - Kalkış: {$kalkis}</li>";
    }
    $duraklarHTML .= "</ol>";

    echo "<tr>
            <td>{$seferID}</td>
            <td>" . htmlspecialchars($row['PlakaNumarasi']) . "</td>
            <td>" . htmlspecialchars($row['SoforAd']) . "</td>
            <td>" . htmlspecialchars($row['SoforSoyad']) . "</td>
            <td>" . htmlspecialchars($row['GuzergahAdi']) . "</td>
            <td>" . $row['SeferTarihi']->format('Y-m-d') . "</td>
            <td>" . $row['KalkisSaati']->format('H:i') . "</td>
            <td>{$duraklarHTML}</td>
          </tr>";
}

echo '</tbody></table></div></div>';
?>



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
