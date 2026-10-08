<?php
require_once "tema.php";
require_once "veritabani.php";
$title = "Tema Parçalama";
head_ustkisim($title);
navbar();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $plaka = $_POST["plaka"] ?? '';

    if (!empty($plaka)) {
        $sql = "DELETE FROM Araclar WHERE PlakaNumarasi = ?";
        $params = [$plaka];
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt) {
            echo "<p style='color: green;'>Araç başarıyla silindi: $plaka</p>";
        } else {
            echo "<p style='color: red;'>Hata oluştu: " . print_r(sqlsrv_errors(), true) . "</p>";
        }
    }
}
?>
<div class="content">
  <div id="arac-sil" class="form-section">
    <h3>Araç Sil</h3>
    <form method="post" action="">
      <input type="text" name="plaka" placeholder="Plaka Numarası" required>
      <button type="submit">Araç Sil</button>
    </form>
  </div>
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