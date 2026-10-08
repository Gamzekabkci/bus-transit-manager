<?php
require_once "tema.php"; 
require_once "veritabani.php";
$title = "Sefer Sil";
head_ustkisim($title);
navbar();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // POST'tan gelen sefer id değerini al ve doğrula
    $sefer_id = isset($_POST["sefer_id"]) ? trim($_POST["sefer_id"]) : "";

    if ($sefer_id === "" || !is_numeric($sefer_id)) {
        echo "<p style='color:red;'>Lütfen geçerli bir Sefer No girin.</p>";
    } else {
        // Önce ilişkili SeferDuraklari varsa onları sil
        $sqlDurakSil = "DELETE FROM SeferDuraklari WHERE SeferID = ?";
        $stmtDurak = sqlsrv_query($conn, $sqlDurakSil, [$sefer_id]);

        if ($stmtDurak === false) {
            echo "<p style='color:red;'>Önce duraklar silinirken hata oluştu:</p>";
            echo "<pre>" . print_r(sqlsrv_errors(), true) . "</pre>";
        } else {
            // Sefer silme sorgusu
            $sql = "DELETE FROM Seferler WHERE SeferID = ?";
            $stmt = sqlsrv_query($conn, $sql, [$sefer_id]);

            if ($stmt === false) {
                echo "<p style='color:red;'>Sefer silinirken hata oluştu:</p>";
                echo "<pre>" . print_r(sqlsrv_errors(), true) . "</pre>";
            } else {
                echo "<p style='color:green;'>Sefer başarıyla silindi.</p>";
            }
        }
    }
}
?>

<div class="form-section" style="max-width:400px; margin:20px auto;">
    <h3>Sefer Sil</h3>
    <form method="post" action="">
        <input type="text" name="sefer_id" placeholder="Sefer No" required>
        <button type="submit">Sefer Sil</button>
    </form>
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