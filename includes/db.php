<?php
// Railway muhitidan ma'lumotlarni olishga harakat qilamiz
$db_url = getenv('DATABASE_URL');

if ($db_url) {
    // Agar Railway bo'lsa (Cloud muhit)
    $url = parse_url($db_url);
    $host = $url["host"];
    $user = $url["user"];
    $pass = isset($url["pass"]) ? $url["pass"] : "";
    $dbname = ltrim($url["path"], "/");
} else {
    // Agar Localhost bo'lsa (XAMPP)
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "e_kutubxona";
}

// Bazaga ulanish
$conn = new mysqli($host, $user, $pass, $dbname);

// Aloqani tekshirish
if ($conn->connect_error) {
    die("Bazaga ulanishda xatolik yoz berdi: " . $conn->connect_error);
}

// O'zbekcha harflar uchun
$conn->set_charset("utf8mb4");
?>