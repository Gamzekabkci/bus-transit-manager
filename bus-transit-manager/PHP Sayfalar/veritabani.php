<?php
$serverName = "GAMZE\SQLEXPRESS";
$connectionOptions = array(
    "Database" => "UlasımYonetimSistemiVT",
    "Uid" => "Gamze",
    "PWD" => "Gizli123!",
    "CharacterSet" => "UTF-8"
);
$conn = sqlsrv_connect($serverName, $connectionOptions);
if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}
//echo "Bağlantı başarılı!";
?>


