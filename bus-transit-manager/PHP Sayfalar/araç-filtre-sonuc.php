<?php
require_once "tema.php";
require_once "veritabani.php";
$title = "Araç Listeleme Sonuçları";
head_ustkisim($title);
navbar();

// Filtreler
$plaka = $_GET['plaka'] ?? '';
$markaModel = $_GET['marka_model'] ?? '';
$modelYili = $_GET['model_yili'] ?? '';
$aracTuru = $_GET['arac_turu'] ?? '';
$kapasite = $_GET['kapasite'] ?? '';

// SQL Sorgusu
$query = "SELECT * FROM Araclar WHERE 1=1";
$params = [];

if (!empty($plaka)) {
    $query .= " AND PlakaNumarasi LIKE ?";
    $params[] = "%$plaka%";
}
if (!empty($markaModel)) {
    $query .= " AND MarkaModel LIKE ?";
    $params[] = "%$markaModel%";
}
if (!empty($modelYili)) {
    $query .= " AND ModelYili = ?";
    $params[] = (int)$modelYili;
}
if (!empty($aracTuru)) {
    $query .= " AND AracTuru LIKE ?";
    $params[] = "%$aracTuru%";
}
if (!empty($kapasite)) {
    $query .= " AND Kapasite >= ?";
    $params[] = (int)$kapasite;
}

$stmt = sqlsrv_query($conn, $query, $params);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Sonuçlar
echo '
<div class="main-content">
  <div class="dashboard">
    <h3>🚌 Filtrelenmiş Araçlar</h3>
    <table>
      <thead>
        <tr>
          <th>Plaka Numarası</th>
          <th>Marka / Model</th>
          <th>Model Yılı</th>
          <th>Araç Türü</th>
          <th>Kapasite</th>
        </tr>
      </thead>
      <tbody>';

$rowFound = false;
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $rowFound = true;
    echo "<tr>
        <td>".htmlspecialchars($row['PlakaNumarasi'])."</td>
        <td>".htmlspecialchars($row['MarkaModel'])."</td>
        <td>".htmlspecialchars($row['ModelYili'])."</td>
        <td>".htmlspecialchars($row['AracTuru'])."</td>
        <td>".htmlspecialchars($row['Kapasite'])."</td>
    </tr>";
}

if (!$rowFound) {
    echo '<tr><td colspan="5" style="text-align:center;">Kayıt bulunamadı.</td></tr>';
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