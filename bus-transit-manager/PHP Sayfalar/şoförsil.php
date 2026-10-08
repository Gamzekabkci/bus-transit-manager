<?php
require_once "tema.php";
require_once "veritabani.php";
$title = "Tema Parçalama";
head_ustkisim($title);
navbar();


$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['TCKimlikNo'])) {
    $tc = $_POST['TCKimlikNo'];

    // TC doğrulama (11 rakam)
    if (preg_match('/^[0-9]{11}$/', $tc)) {
        // Silme sorgusu
        $sql = "DELETE FROM Soforler WHERE TCKimlikNo = ?";
        $params = [$tc];
        $stmt = sqlsrv_query($conn, $sql, $params);
        if ($stmt === false) {
            $message = "Silme işlemi sırasında hata oluştu: " . print_r(sqlsrv_errors(), true);
        } else {
            if (sqlsrv_rows_affected($stmt) > 0) {
                $message = "TC numarası $tc olan şoför başarıyla silindi.";
            } else {
                $message = "TC numarası $tc olan şoför bulunamadı.";
            }
        }
    } else {
        $message = "Geçerli bir 11 haneli TC numarası girin.";
    }
}
?>

<div class="form-section">
    <h3>Şoför Sil</h3>
    <?php if($message): ?>
        <p style="color:<?= strpos($message, 'hata') !== false ? 'red' : 'green' ?>"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <form method="post" action="">
        <input type="text" id="tc" name="TCKimlikNo" placeholder="TC" pattern="[0-9]{11}" maxlength="11" required>
        <button type="submit">Şoför Sil</button>
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

<?php
sqlsrv_close($conn);
?>
