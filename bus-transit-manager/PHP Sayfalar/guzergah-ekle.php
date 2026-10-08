<?php
require_once "tema.php";
require_once "veritabani.php";
$title = "Güzergah Ekle";
head_ustkisim($title);
navbar();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $guzergahAdi = $_POST["GuzergahAdi"];
    $baslangic = $_POST["BaslangicNoktasi"];
    $bitis = $_POST["BitisNoktasi"];
    $mesafe = (int)$_POST["MesafeKm"];
    $sure = (int)$_POST["TahminiSure"];
    
    $saat = floor($sureDakika / 60);
    $dakika = $sureDakika % 60;
    $sure = sprintf("%02d:%02d:00.0000000", $saat, $dakika);

    $duraklar = json_decode($_POST["duraklarJSON"], true);

    $sqlG = "INSERT INTO Guzergahlar (GuzergahAdi, BaslangicNoktasi, BitisNoktasi, MesafeKm, TahminiSure)
             VALUES (?, ?, ?, ?, ?)";
    $paramsG = [$guzergahAdi, $baslangic, $bitis, $mesafe, $sure];
    $stmtG = sqlsrv_query($conn, $sqlG, $paramsG);

    if ($stmtG) {
        $result = sqlsrv_query($conn, "SELECT SCOPE_IDENTITY() AS GuzergahID");
        $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
        $guzergahID = $row["GuzergahID"];

        foreach ($duraklar as $sira => $durakAdi) {
            $sqlD = "INSERT INTO Duraklar (GuzergahID, DurakAdi, SiraNo) VALUES (?, ?, ?)";
            $paramsD = [$guzergahID, $durakAdi, $sira + 1];
            sqlsrv_query($conn, $sqlD, $paramsD);
        }

        echo "<p style='color:green;'>✅ Güzergah ve duraklar kaydedildi.</p>";
    } else {
        echo "<p style='color:red;'>❌ Kayıt sırasında hata oluştu: " . print_r(sqlsrv_errors(), true) . "</p>";
    }
}
?>

<div class="form-section">
  <h2>Güzergah Ekle</h2>
  <form id="guzergahForm" method="post" action="" onsubmit="return formGonder();">
    <label>Güzergah Adı:</label>
    <input type="text" name="GuzergahAdi" required>

    <label>Başlangıç Noktası:</label>
    <input type="text" name="BaslangicNoktasi" required>

    <label>Bitiş Noktası:</label>
    <input type="text" name="BitisNoktasi" required>

    <label>Mesafe (km):</label>
    <input type="number" name="MesafeKm" required min="1">

    <label>Tahmini Süre (dk):</label>
    <input type="number" name="Süre" required min="1">

    <label>Duraklar:</label>
    <input type="text" id="durakInput" placeholder="Durak adı yaz ve ekle">
    <button type="button" onclick="durakEkle()">Durak Ekle</button>

    <div class="durak-listesi" id="durakListesi"></div>

    <input type="hidden" name="duraklarJSON" id="duraklarJSON">
    <button type="submit">Kaydet</button>
  </form>
</div>

<script>
  const duraklar = [];

  function durakEkle() {
    const durakInput = document.getElementById("durakInput");
    const durakAdi = durakInput.value.trim();
    if (durakAdi !== "") {
      duraklar.push(durakAdi);
      guncelleDurakListesi();
      durakInput.value = "";
    }
  }

  function guncelleDurakListesi() {
    const liste = document.getElementById("durakListesi");
    liste.innerHTML = "";
    duraklar.forEach((durak, index) => {
      const item = document.createElement("div");
      item.innerHTML = `<span>${durak}</span> <button type="button" onclick="durakSil(${index})">Sil</button>`;
      liste.appendChild(item);
    });
  }

  function durakSil(index) {
    duraklar.splice(index, 1);
    guncelleDurakListesi();
  }

  function formGonder() {
    document.getElementById("duraklarJSON").value = JSON.stringify(duraklar);
    return true;
  }
</script>

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
