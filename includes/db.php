<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "e_kutubxona"; // phpMyAdmin-dagi baza nomi bilan bir xil bo'lsin

// Bazaga ulanish
$conn = new mysqli($host, $user, $pass, $dbname);

// Aloqani tekshirish
if ($conn->connect_error) {
    die("Bazaga ulanishda xatolik yoz berdi: " . $conn->connect_error);
}

// O'zbekcha harflar (sh, ch, o', g') bazada to'g'ri chiqishi uchun
$conn->set_charset("utf8mb4");
?>