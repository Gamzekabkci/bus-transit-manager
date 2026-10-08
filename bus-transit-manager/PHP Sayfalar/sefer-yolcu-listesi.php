<?php
require_once "tema.php";
require_once "veritabani.php";
$title = "Sefer Yolcu Listesi";
head_ustkisim($title);
navbar();

$seferId = $_POST['seferId'] ?? null;
$yolcular = [];
$bosKoltukSayisi = null;

if ($seferId) {
    // Yolcu bilgilerini çekiyoruz, binis ve iniş durakları ile birlikte
    $sqlYolcu = "SELECT
        y.TCKimlikNo,
        y.Ad,
        y.Soyad,
        y.Cinsiyet,
        g.GuzergahAdi,
        sy.KoltukNo,
        y.Telefon,
        bd.DurakAdi AS BinisDurak,
        id.DurakAdi AS InisDurak
    FROM SeferYolcular sy
    INNER JOIN Yolcular y ON sy.YolcuID = y.YolcuID
    INNER JOIN Seferler s ON sy.SeferID = s.SeferID
    INNER JOIN Guzergahlar g ON s.GuzergahID = g.GuzergahID
    LEFT JOIN Duraklar bd ON sy.BinisDurakID = bd.DurakID
    LEFT JOIN Duraklar id ON sy.InisDurakID = id.DurakID
    WHERE sy.SeferID = ?
    GROUP BY y.TCKimlikNo, y.Ad, y.Soyad, y.Cinsiyet, g.GuzergahAdi, sy.KoltukNo, y.Telefon, bd.DurakAdi, id.DurakAdi
    ";

    $params = [$seferId];
    $stmt = sqlsrv_query($conn, $sqlYolcu, $params);

    if ($stmt === false) {
        echo "Sorgu hatası:";
        die(print_r(sqlsrv_errors(), true));
    }

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $yolcular[] = $row;
    }

    // Araç kapasitesini çekiyoruz
    $sqlKapasite = "SELECT a.Kapasite 
    FROM Araclar a
    INNER JOIN Seferler s ON s.AracID = a.AracID
    WHERE s.SeferID = ?
    ";
    $stmtKap = sqlsrv_query($conn, $sqlKapasite, $params);
    $kapasite = 0;
    if ($rowKap = sqlsrv_fetch_array($stmtKap, SQLSRV_FETCH_ASSOC)) {
        $kapasite = $rowKap['Kapasite'];
    }

    $doluKoltukSayisi = count($yolcular);
    $bosKoltukSayisi = $kapasite - $doluKoltukSayisi;
}
?>

<div class="main-content" style="margin-left: 20px;">
  <h2>Sefer Yolcu Listesi</h2>

  <form method="post">
    <label for="seferId">Sefer ID:</label>
    <input type="text" name="seferId" id="seferId" value="<?= htmlspecialchars($seferId) ?>" required>
    <button type="submit">Göster</button>
  </form>

  <?php if ($seferId !== null): ?>
    <div class="bos" id="bosKoltuk" style="margin-top: 10px;">
      <strong>Boş Koltuk Sayısı: </strong> <?= htmlspecialchars($bosKoltukSayisi) ?>
    </div>

    <table style="margin-top:15px; width: 100%; border-collapse: collapse;">
      <thead style="background-color: #f2f2f2;">
        <tr>
          <th>TC</th>
          <th>Ad</th>
          <th>Soyad</th>
          <th>Cinsiyet</th>
          <th>Güzergah</th>
          <th>Koltuk No</th>
          <th>Biniş Durağı</th>
          <th>İniş Durağı</th>
          <th>Telefon</th>
        </tr>
      </thead>
      <tbody>
        <?php if (count($yolcular) > 0): ?>
          <?php foreach ($yolcular as $y): ?>
          <tr>
            <td><?= htmlspecialchars($y['TCKimlikNo']) ?></td>
            <td><?= htmlspecialchars($y['Ad']) ?></td>
            <td><?= htmlspecialchars($y['Soyad']) ?></td>
            <td><?= htmlspecialchars($y['Cinsiyet']) ?></td>
            <td><?= htmlspecialchars($y['GuzergahAdi']) ?></td>
            <td><?= htmlspecialchars($y['KoltukNo']) ?></td>
            <td><?= htmlspecialchars($y['BinisDurak'] ?? 'Belirtilmedi') ?></td>
            <td><?= htmlspecialchars($y['InisDurak'] ?? 'Belirtilmedi') ?></td>
            <td><?= htmlspecialchars($y['Telefon']) ?></td>
          </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="10" style="text-align:center;">Sefer ID için kayıtlı yolcu bulunamadı.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  <?php endif; ?>
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

