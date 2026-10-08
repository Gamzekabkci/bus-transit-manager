<?php
require_once "tema.php";
require_once "veritabani.php";
$title = "Tema Parçalama";
head_ustkisim($title);
navbar();

$query = "SELECT PlakaNumarasi, MarkaModel, ModelYili, AracTuru, Kapasite FROM Araclar";
$stmt = sqlsrv_query($conn, $query);

echo '
  <div class="main-content">
    <div class="dashboard">
      <h3>🚌 Araçlar</h3>
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
        <tbody>
';

if ($stmt) {
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        echo " <tr>
          <td>{$row['PlakaNumarasi']}</td>
          <td>{$row['MarkaModel']}</td>
          <td>{$row['ModelYili']}</td>
          <td>{$row['AracTuru']}</td>
          <td>{$row['Kapasite']}</td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='5'>Veri çekme hatası!</td></tr>";
}

echo '
        </tbody>
      </table>
    </div>
  </div>';
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