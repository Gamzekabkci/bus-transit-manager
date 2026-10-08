<?php
require_once "tema.php";
require_once "veritabani.php";
$title = "Tema Parçalama";
head_ustkisim($title);
navbar();

$mesaj = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // POST verilerini al
    $tc = $_POST['tc'] ?? '';
    $isim = $_POST['isim'] ?? '';
    $soyisim = $_POST['soyisim'] ?? '';
    $ise_giris = $_POST['date'] ?? '';
    $ehliyet = $_POST['ehliyet'] ?? '';
    $telefon = $_POST['telefon'] ?? '';

    if (strlen($tc) === 11 && preg_match('/^\d{11}$/', $tc) &&
        !empty($isim) && !empty($soyisim) && !empty($ise_giris) &&
        !empty($ehliyet) && !empty($telefon)
    ) {
        
        $ise_giris_date = date('Y-m-d', strtotime($ise_giris));

        $sql = "INSERT INTO Soforler (TCKimlikNo, Ad, Soyad, IseGirisTarihi, EhliyetTipi, Telefon) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $params = [$tc, $isim, $soyisim, $ise_giris_date, $ehliyet, $telefon];
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            $mesaj = "Kayıt sırasında hata oluştu: " . print_r(sqlsrv_errors(), true);
        } else {
            $mesaj = "Şoför başarıyla eklendi.";
        }
    } else {
        $mesaj = "Lütfen tüm alanları doğru doldurun.";
    }
}

echo '
<div class="content">
  <div id="şöför-ekle" class="form-section">
    <h3>Şoför Ekle</h3>';

if ($mesaj) {
    echo '<p style="color:green;">' . htmlspecialchars($mesaj) . '</p>';
}

echo '
    <form method="post" action="">
      <input type="text" id="tc" name="tc" placeholder="TC" pattern="[0-9]{11}" maxlength="11" required>
      <input type="text" name="isim" placeholder="İsim" required>
      <input type="text" name="soyisim" placeholder="Soyisim" required>
      <label for="giriş-tarihi">İşe Giriş Tarihi:</label>
      <input type="date" id="date" name="date" required>
      <label for="ehliyet">Ehliyet Tipi:</label>
      <select id="ehliyet" name="ehliyet" required>
        <option value="">Seçiniz</option>
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
        <option value="D">D</option>
        <option value="E">E</option>
        <option value="F">F</option>
      </select>
      <input type="tel" id="telefon" name="telefon" placeholder="05XXXXXXXXX" pattern="05[0-9]{9}" required>
      <button type="submit">Şoför Ekle</button>
    </form>
  </div>
</div>
';

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
