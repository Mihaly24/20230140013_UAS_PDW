<?php
require_once '../config.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'asisten') {
    header("Location: ../auth/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_praktikum = $_POST['id_praktikum'];
    $nama_modul = $_POST['nama_modul'];
    $nama_file = null;

    if (isset($_FILES['file_materi']) && $_FILES['file_materi']['error'] == 0) {
        $target_dir = "../uploads/materi/";
        $nama_file = time() . '_' . basename($_FILES["file_materi"]["name"]);
        $target_file = $target_dir . $nama_file;
        move_uploaded_file($_FILES["file_materi"]["tmp_name"], $target_file);
    }

    $stmt = $conn->prepare("INSERT INTO modul (id_praktikum, nama_modul, file_materi) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $id_praktikum, $nama_modul, $nama_file);
    $stmt->execute();
    $stmt->close();
}
header("Location: kelola_modul.php?id_praktikum=" . $id_praktikum);
exit();
?>