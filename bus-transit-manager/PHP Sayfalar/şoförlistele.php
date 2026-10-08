<?php
require_once "tema.php";
require_once "veritabani.php";
$title = "Şoför Listesi";
head_ustkisim($title);
navbar();
echo'
<div class="form-section">
  <h3>Şoför Listeleme Kriterleri</h3>
  <form method="get" action="şoförlistesi1.php">
    <input type="text" id="tc" name="TCKimlikNo" placeholder="TC Kimlik No" pattern="[0-9]{11}" maxlength="11">
    <input type="text" name="isim" placeholder="İsim">
    <input type="text" name="soyisim" placeholder="Soyisim">
    
    <label for="date">İşe Giriş Tarihi:</label>
    <input type="date" id="date" name="date">

    <label for="ehliyet">Ehliyet Tipi:</label>
    <select id="ehliyet" name="ehliyet">
      <option value="">Seçiniz</option>
      <option value="A">A</option>
      <option value="B">B</option>
      <option value="C">C</option>
      <option value="D">D</option>
      <option value="E">E</option>
      <option value="F">F</option>
    </select>

    <input type="tel" id="telefon" name="telefon" placeholder="05XXXXXXXXX" pattern="05[0-9]{9}">

    <button type="submit">Şoförleri Listele</button>
  </form>

  <form action="şoförlistesi.php" method="get" style="margin-top: 10px;">
    <button type="submit">Tüm Şoförleri Listele</button>
  </form>
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
