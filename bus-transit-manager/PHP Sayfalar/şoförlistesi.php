<?php
require_once "tema.php";
require_once "veritabani.php";
$title = "Tema Parçalama";
head_ustkisim($title);
navbar();


// Sorgu: tüm şoförleri çek
$sql = "SELECT TCKimlikNo, Ad, Soyad, IseGirisTarihi, EhliyetTipi, Telefon FROM Soforler ORDER BY Ad, Soyad";
$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

echo '
  <div class="main-content">
    <div class="dashboard">
      <h3>👨‍✈️ Şoförler</h3>
      <table>
        <thead>
          <tr>
            <th>TC</th>
            <th>İsim</th>
            <th>Soyisim</th>
            <th>İşe Giriş Tarihi</th>
            <th>Ehliyet Tipi</th>
            <th>Telefon No</th>
          </tr>
        </thead>
        <tbody>
';

$rowFound = false;
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $rowFound = true;
    // Tarih MSSQL'den DateTime objesi olarak gelir, formatla
    $ise_giris = $row['IseGirisTarihi'] ? $row['IseGirisTarihi']->format('d.m.Y') : '';
    echo '<tr>
            <td>'.htmlspecialchars($row['TCKimlikNo']).'</td>
            <td>'.htmlspecialchars($row['Ad']).'</td>
            <td>'.htmlspecialchars($row['Soyad']).'</td>
            <td>'.$ise_giris.'</td>
            <td>'.htmlspecialchars($row['EhliyetTipi']).'</td>
            <td>'.htmlspecialchars($row['Telefon']).'</td>
          </tr>';
}

if (!$rowFound) {
    echo '<tr><td colspan="6" style="text-align:center;">Kayıt bulunamadı.</td></tr>';
}

echo '
        </tbody>
      </table>
    </div>
  </div>';

// Bağlantıyı kapat
sqlsrv_close($conn);
?>

<script>
  function openLogout() {
    document.getElementById("logout-modal").style.display = "flex";
  }

  function closeLogout() {
    document.getElementById("logout-modal").style.display = "none";
  }

  function confirmLogout() {
    alert("Çıkış yapıldı.");
    window.location.href = "girişekranı.php";
  }
</script>
