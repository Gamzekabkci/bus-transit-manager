<?php
require_once "tema.php";
require_once "veritabani.php";
$title = "Araç Filtreleme Formu";
head_ustkisim($title);
navbar();

echo '
<div class="content">
  <div id="arac-listele" class="form-section">
    <h3>Araç Listeleme Kriterleri</h3>
    <form method="get" action="araç-filtre-sonuc.php">
      <input type="text" name="plaka" placeholder="Plaka Numarası">
      <input type="text" name="marka_model" placeholder="Marka / Model">
      <input type="number" name="model_yili" placeholder="Model Yılı" min="1900" max="2100">
      <input type="text" name="arac_turu" placeholder="Araç Türü">
      <input type="number" name="kapasite" placeholder="Minimum Kapasite" min="1">
      <button type="submit">Araçları Listele</button>
    </form>
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