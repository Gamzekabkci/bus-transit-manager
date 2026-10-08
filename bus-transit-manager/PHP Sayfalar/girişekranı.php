<?php
session_start();
require_once "veritabani.php";

$error = "";

// Form gönderildiyse kontrol et
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    if ($conn === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Kullanıcı sorgusu
    $sql = "SELECT * FROM kullanicilar WHERE username = ?";
    $params = [$username];
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    if ($user) {
        // Şifre kontrolü - burada hash değilse direk karşılaştırma
        if ($password === $user['password']) {
            $_SESSION['user'] = $user['username'];
            sqlsrv_close($conn);
            header("Location: anasayfa.php");
            exit();
        } else {
            $error = "Hatalı şifre!";
        }
    } else {
        $error = "Kullanıcı bulunamadı!";
    }

    sqlsrv_close($conn);
}

echo '
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Yönetici Giriş</title>
    <link rel="stylesheet" href="style1.css" />
</head>
<body>
    <div class="giriş-container">
        <h2>Yönetici Giriş</h2>
        <form action="" method="POST">
          <div class="form-grup">
            <label for="username">Kullanıcı Adı</label>
            <input type="text" id="username" name="username" required />
          </div>
          <div class="form-grup">
            <label for="password">Şifre</label>
            <input type="password" id="password" name="password" required />
          </div>
          <button type="submit" class="giriş-btn">Giriş Yap</button>
        </form>

        <div class="footer">© 2025 Ulaşım Yönetimi Sistemi</div>
    </div>
</body>
</html>';

?>
