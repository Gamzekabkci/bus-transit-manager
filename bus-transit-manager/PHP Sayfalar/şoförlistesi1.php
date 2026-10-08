<?php
require_once "tema.php";
require_once "veritabani.php";
$title = "Tema Parçalama";
head_ustkisim($title);
navbar(); 

// Filtre değerlerini al
$tc     = $_GET['TCKimlikNo'] ?? '';
$isim   = $_GET['isim'] ?? '';
$soyisim= $_GET['soyisim'] ?? '';
$tarih  = $_GET['date'] ?? '';
$ehliyet= $_GET['ehliyet'] ?? '';
$telefon= $_GET['telefon'] ?? '';

// Temel SQL
$sql = "SELECT TCKimlikNo, Ad, Soyad, IseGirisTarihi, EhliyetTipi, Telefon FROM Soforler WHERE 1=1";
$params = [];

// Dinamik filtre ekle
if (!empty($tc)) {
    $sql .= " AND TCKimlikNo = ?";
    $params[] = $tc;
}
if (!empty($isim)) {
    $sql .= " AND Ad LIKE ?";
    $params[] = "%$isim%";
}
if (!empty($soyisim)) {
    $sql .= " AND Soyad LIKE ?";
    $params[] = "%$soyisim%";
}
if (!empty($tarih)) {
    $sql .= " AND CONVERT(DATE, IseGirisTarihi) = ?";
    $params[] = $tarih;
}
if (!empty($ehliyet)) {
    $sql .= " AND EhliyetTipi = ?";
    $params[] = $ehliyet;
}
if (!empty($telefon)) {
    $sql .= " AND Telefon LIKE ?";
    $params[] = "%$telefon%";
}

// Sorguyu çalıştır
$stmt = sqlsrv_query($conn, $sql, $params);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Sonuçları listele (buraya tablo yazımı eklenebilir)

echo '
<div class="main-content">
  <div class="dashboard">
    <h3>🧾 Şoför Listeleme Sonuçları</h3>
    <table >
      <thead>
        <tr>
          <th>TC</th>
          <th>İsim</th>
          <th>Soyisim</th>
          <th>İşe Giriş Tarihi</th>
          <th>Ehliyet Tipi</th>
          <th>Telefon</th>
        </tr>
      </thead>
      <tbody>';
      
$rowFound = false;
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $rowFound = true;
    $iseGiris = $row['IseGirisTarihi'] ? $row['IseGirisTarihi']->format('d.m.Y') : '';
    echo '<tr>
            <td>' . htmlspecialchars($row['TCKimlikNo']) . '</td>
            <td>' . htmlspecialchars($row['Ad']) . '</td>
            <td>' . htmlspecialchars($row['Soyad']) . '</td>
            <td>' . $iseGiris . '</td>
            <td>' . htmlspecialchars($row['EhliyetTipi']) . '</td>
            <td>' . htmlspecialchars($row['Telefon']) . '</td>
          </tr>';
}
if (!$rowFound) {
    echo '<tr><td colspan="6" style="text-align:center;">Kayıt bulunamadı.</td></tr>';
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

<?php
sqlsrv_close($conn);
?>
