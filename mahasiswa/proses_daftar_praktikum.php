<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id_praktikum = $_GET['id'];
    $id_mahasiswa = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO pendaftaran_praktikum (id_mahasiswa, id_praktikum) VALUES (?, ?)");
    $stmt->bind_param("ii", $id_mahasiswa, $id_praktikum);
    $stmt->execute();
    $stmt->close();
}
header("Location: praktikum_saya.php");
exit();
?>