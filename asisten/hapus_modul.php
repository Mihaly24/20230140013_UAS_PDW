<?php
require_once '../config.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'asisten') {
    header("Location: ../auth/login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $id_praktikum = $_GET['id_praktikum'];
    
    // Hapus file jika ada
    $stmt_select = $conn->prepare("SELECT file_materi FROM modul WHERE id = ?");
    $stmt_select->bind_param("i", $id);
    $stmt_select->execute();
    $result = $stmt_select->get_result()->fetch_assoc();
    if($result && $result['file_materi']) {
        unlink("../uploads/materi/" . $result['file_materi']);
    }
    $stmt_select->close();

    $stmt_delete = $conn->prepare("DELETE FROM modul WHERE id = ?");
    $stmt_delete->bind_param("i", $id);
    $stmt_delete->execute();
    $stmt_delete->close();
}
header("Location: kelola_modul.php?id_praktikum=" . $id_praktikum);
exit();
?>