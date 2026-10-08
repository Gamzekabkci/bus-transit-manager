<?php
require_once "tema.php";
require_once "veritabani.php";
$title = "Tema Parçalama";
head_ustkisim($title);
navbar();

$sql = "SELECT
    s.SeferID,
    s.SeferTarihi,
    FORMAT(s.KalkisSaati, 'HH:mm') AS KalkisSaati,
    a.PlakaNumarasi,
    so.Ad + ' ' + so.Soyad AS SoforAdi,
    g.GuzergahAdi,
    d.DurakAdi,
    FORMAT(sd.VarisSaati, 'HH:mm') AS VarisSaati,
    FORMAT(sd.KalkisSaati, 'HH:mm') AS KalkisSaatiDurak
FROM Seferler s
JOIN Araclar a ON s.AracID = a.AracID
JOIN Soforler so ON s.SoforID = so.SoforID
JOIN Guzergahlar g ON s.GuzergahID = g.GuzergahID
JOIN SeferDuraklari sd ON s.SeferID = sd.SeferID
JOIN Duraklar d ON sd.DurakID = d.DurakID
WHERE s.SeferTarihi >= CAST(GETDATE() AS DATE)
ORDER BY s.SeferID, sd.VarisSaati;
";

$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$oncekiSeferID = null;

echo '<div class="main-content">
    <div class="dashboard">
      <h3>Yaklaşan Seferler</h3>
      <table >
        <thead>
          <tr>
            <th>Sefer No</th>
            <th>Plaka</th>
            <th>Şoför</th>
            <th>Güzergah Adı</th>
            <th>Sefer Tarihi</th>
            <th>Kalkış Saati</th>
            <th>Duraklar</th>
          </tr>
        </thead>
        <tbody>';

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    if ($oncekiSeferID !== $row['SeferID']) {
        if ($oncekiSeferID !== null) {
            echo '</ol></td></tr>';
        }
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['SeferID']) . '</td>';
        echo '<td>' . htmlspecialchars($row['PlakaNumarasi']) . '</td>';
        echo '<td>' . htmlspecialchars($row['SoforAdi']) . '</td>';
        echo '<td>' . htmlspecialchars($row['GuzergahAdi']) . '</td>';
        echo '<td>' . $row['SeferTarihi']->format('Y-m-d') . '</td>';
        echo '<td>' . htmlspecialchars($row['KalkisSaati']) . '</td>';
        echo '<td><ol>';
        echo '<li>' . htmlspecialchars($row['DurakAdi']) . ' - Varış: ' . htmlspecialchars($row['VarisSaati']) . ' - Kalkış: ' . htmlspecialchars($row['KalkisSaatiDurak']) . '</li>';

        $oncekiSeferID = $row['SeferID'];
    } else {
        echo '<li>' . htmlspecialchars($row['DurakAdi']) . ' - Varış: ' . htmlspecialchars($row['VarisSaati']) . ' - Kalkış: ' . htmlspecialchars($row['KalkisSaatiDurak']) . '</li>';
    }
}

if ($oncekiSeferID !== null) {
    echo '</ol></td></tr>';
}

echo '</tbody></table></div></div>';

sqlsrv_close($conn);
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