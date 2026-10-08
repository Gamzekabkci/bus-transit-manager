<?php
require_once "tema.php";
require_once "veritabani.php"; 

$title = "Güzergahlar";
head_ustkisim($title);
navbar();

// Silme işlemi
if (isset($_GET['sil'])) {
    $silID = (int) $_GET['sil'];

    // Önce silmek istediğin güzergahın duraklarını sil
    $sqlSilDurak = "DELETE FROM Duraklar WHERE GuzergahID = ?";
    $stmtDurak = sqlsrv_query($conn, $sqlSilDurak, [$silID]);

    // Ardından güzergahı sil
    $sqlSilGuzergah = "DELETE FROM Guzergahlar WHERE GuzergahID = ?";
    $stmtGuzergah = sqlsrv_query($conn, $sqlSilGuzergah, [$silID]);

    if ($stmtGuzergah) {
        echo "<p style='color:green;'>Güzergah ve ilgili duraklar başarıyla silindi.</p>";
    } else {
        echo "<p style='color:red;'>Silme işlemi başarısız: " . htmlspecialchars(print_r(sqlsrv_errors(), true)) . "</p>";
    }
}

// Güzergahları listele
echo '<div class="main-content">
  <div class="dashboard">
    <h3>🗺️ Güzergahlar</h3>
    <table >
      <thead>
        <tr>
          <th>Güzergah ID</th>
          <th>Adı</th>
          <th>Başlangıç</th>
          <th>Bitiş</th>
          <th>İşlem</th>
        </tr>
      </thead>
      <tbody>';

$sql = "SELECT * FROM Guzergahlar ORDER BY GuzergahID DESC";
$result = sqlsrv_query($conn, $sql);

if ($result === false) {
    echo "<tr><td colspan='5'>Hata: " . htmlspecialchars(print_r(sqlsrv_errors(), true)) . "</td></tr>";
} elseif (sqlsrv_has_rows($result)) {
    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        echo "<tr>
                <td>" . htmlspecialchars($row['GuzergahID']) . "</td>
                <td>" . htmlspecialchars($row['GuzergahAdi']) . "</td>
                <td>" . htmlspecialchars($row['BaslangicNoktasi']) . "</td>
                <td>" . htmlspecialchars($row['BitisNoktasi']) . "</td>
                <td>
                  <a href='?sil=" . urlencode($row['GuzergahID']) . "' onclick='return confirm(\"Silmek istediğinize emin misiniz?\")'>Sil</a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>Güzergah bulunamadı.</td></tr>";
}

echo '</tbody>
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



