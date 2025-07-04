<?php
require_once '../config.php';
$pageTitle = 'Dashboard';
$activePage = 'dashboard';
require_once 'templates/header_mahasiswa.php'; 

$id_mahasiswa = $_SESSION['user_id'];

// Praktikum diikuti
$stmt_prak = $conn->prepare("SELECT COUNT(*) as total FROM pendaftaran_praktikum WHERE id_mahasiswa = ?");
$stmt_prak->bind_param("i", $id_mahasiswa);
$stmt_prak->execute();
$total_prak = $stmt_prak->get_result()->fetch_assoc()['total'];

// Tugas selesai (ada nilai)
$stmt_selesai = $conn->prepare("SELECT COUNT(*) as total FROM pengumpulan_tugas WHERE id_mahasiswa = ? AND nilai IS NOT NULL");
$stmt_selesai->bind_param("i", $id_mahasiswa);
$stmt_selesai->execute();
$total_selesai = $stmt_selesai->get_result()->fetch_assoc()['total'];

// Tugas menunggu (sudah kumpul, belum dinilai)
$stmt_tunggu = $conn->prepare("SELECT COUNT(*) as total FROM pengumpulan_tugas WHERE id_mahasiswa = ? AND nilai IS NULL");
$stmt_tunggu->bind_param("i", $id_mahasiswa);
$stmt_tunggu->execute();
$total_tunggu = $stmt_tunggu->get_result()->fetch_assoc()['total'];

?>

<div class="bg-gradient-to-r from-blue-500 to-cyan-400 text-white p-8 rounded-xl shadow-lg mb-8">
    <h1 class="text-3xl font-bold">Selamat Datang Kembali, <?php echo htmlspecialchars($_SESSION['nama']); ?>!</h1>
    <p class="mt-2 opacity-90">Terus semangat dalam menyelesaikan semua modul praktikummu.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-md flex flex-col items-center justify-center">
        <div class="text-5xl font-extrabold text-blue-600"><?php echo $total_prak; ?></div>
        <div class="mt-2 text-lg text-gray-600">Praktikum Diikuti</div>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-md flex flex-col items-center justify-center">
        <div class="text-5xl font-extrabold text-green-500"><?php echo $total_selesai; ?></div>
        <div class="mt-2 text-lg text-gray-600">Tugas Dinilai</div>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-md flex flex-col items-center justify-center">
        <div class="text-5xl font-extrabold text-yellow-500"><?php echo $total_tunggu; ?></div>
        <div class="mt-2 text-lg text-gray-600">Tugas Menunggu</div>
    </div>
</div>

<?php require_once 'templates/footer_mahasiswa.php'; ?>