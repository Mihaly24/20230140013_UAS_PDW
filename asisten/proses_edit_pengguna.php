<?php
require_once '../config.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'asisten') {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    // Cek jika password diisi atau tidak
    if (!empty($password)) {
        // Jika password diisi, update semua termasuk password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("UPDATE users SET nama = ?, email = ?, password = ?, role = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $nama, $email, $hashed_password, $role, $id);
    } else {
        // Jika password kosong, update tanpa mengubah password
        $stmt = $conn->prepare("UPDATE users SET nama = ?, email = ?, role = ? WHERE id = ?");
        $stmt->bind_param("sssi", $nama, $email, $role, $id);
    }
    
    if($stmt->execute()){
        header("Location: kelola_pengguna.php?status=sukses&pesan=Data pengguna berhasil diupdate.");
    } else {
        header("Location: kelola_pengguna.php?status=gagal&pesan=Gagal mengupdate data pengguna.");
    }
    $stmt->close();
    exit();
}
?>