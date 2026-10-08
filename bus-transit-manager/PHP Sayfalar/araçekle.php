<?php
require_once "tema.php";
require_once "veritabani.php";
$title = "Tema Parçalama";
head_ustkisim($title);
navbar();

 if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $plaka = $_POST['plaka'];
    $marka_model = $_POST['marka_model'];
    $model_yili = $_POST['model_yili'];
    $arac_turu = $_POST['arac_turu'];
    $kapasite = $_POST['kapasite'];

    $sql = "INSERT INTO Araclar (PlakaNumarasi, MarkaModel, ModelYili, AracTuru, Kapasite)
            VALUES (?, ?, ?, ?, ?)";

    $params = [$plaka, $marka_model, $model_yili, $arac_turu, $kapasite];
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt) {
        echo "<p style='color:green;'>Araç başarıyla eklendi.</p>";
    } else {
        echo "<p style='color:red;'>Hata oluştu: " . print_r(sqlsrv_errors(), true) . "</p>";
    }
}
?>


<div class="content">
  <div id="arac-ekle" class="form-section">
    <h3>Araç Ekle</h3>
    <form method="post" action="">
      <input type="text" name="plaka" placeholder="Plaka Numarası" required>
      <input type="text" name="marka_model" placeholder="Marka / Model" required>
      <input type="number" name="model_yili" placeholder="Model Yılı" required min="1900" max="2100">
      <input type="text" name="arac_turu" placeholder="Araç Türü" required>
      <input type="number" name="kapasite" placeholder="Kapasite" required min="1">
      <button type="submit">Araç Ekle</button>
    </form>
    <a href="araçlistesi.php"><button type="submit">Araç Listesi</button></a>
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