<?php
require_once '../config.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'asisten') {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    // Cek dulu apakah email sudah ada
    $stmt_check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        header("Location: kelola_pengguna.php?status=gagal&pesan=Email sudah terdaftar.");
        exit();
    }
    $stmt_check->close();

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $stmt_insert = $conn->prepare("INSERT INTO users (nama, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt_insert->bind_param("ssss", $nama, $email, $hashed_password, $role);
    
    if($stmt_insert->execute()){
        header("Location: kelola_pengguna.php?status=sukses&pesan=Pengguna baru berhasil ditambahkan.");
    } else {
        header("Location: kelola_pengguna.php?status=gagal&pesan=Gagal menambahkan pengguna.");
    }
    $stmt_insert->close();
    exit();
}
?>