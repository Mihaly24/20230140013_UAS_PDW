<?php
session_start();
require_once '../config.php';

$id_praktikum = $_POST['id_praktikum'] ?? 0; // Default value untuk mencegah error
$status_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file_laporan'])) {
    if ($_FILES['file_laporan']['error'] === UPLOAD_ERR_OK) {
        $id_modul = $_POST['id_modul'];
        $id_mahasiswa = $_SESSION['user_id'];
        $target_dir = "../uploads/laporan/";

        // Cek apakah direktori ada, jika tidak, buat.
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0775, true);
        }

        $original_filename = basename($_FILES["file_laporan"]["name"]);
        $file_extension = strtolower(pathinfo($original_filename, PATHINFO_EXTENSION));
        
        // Nama file unik
        $new_filename = $id_mahasiswa . "_" . $id_modul . "_" . time() . "." . $file_extension;
        $target_file = $target_dir . $new_filename;

        // Coba pindahkan file
        if (move_uploaded_file($_FILES["file_laporan"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO pengumpulan_tugas (id_modul, id_mahasiswa, file_laporan) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $id_modul, $id_mahasiswa, $new_filename);
            
            if ($stmt->execute()) {
                $status_message = "sukses=Laporan berhasil diunggah!";
            } else {
                $status_message = "error=Gagal menyimpan ke database.";
            }
            $stmt->close();
        } else {
            $status_message = "error=Gagal memindahkan file. Cek izin folder 'uploads/laporan'.";
        }
    } else {
        $status_message = "error=Terjadi kesalahan saat mengunggah file. Kode Error: " . $_FILES['file_laporan']['error'];
    }
} else {
    $status_message = "error=Request tidak valid atau tidak ada file yang dikirim.";
}

// Redirect kembali dengan pesan status
header("Location: detail_praktikum.php?id=" . $id_praktikum . "&" . $status_message);
exit();
?>