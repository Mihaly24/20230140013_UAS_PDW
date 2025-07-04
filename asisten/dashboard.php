<?php
require_once '../config.php';
$pageTitle = 'Dashboard';
$activePage = 'dashboard';
require_once 'templates/header.php';

// Total Praktikum
$total_praktikum = $conn->query("SELECT COUNT(*) as total FROM mata_praktikum")->fetch_assoc()['total'];
// Total Modul
$total_modul = $conn->query("SELECT COUNT(*) as total FROM modul")->fetch_assoc()['total'];
// Laporan Masuk
$laporan_masuk = $conn->query("SELECT COUNT(*) as total FROM pengumpulan_tugas")->fetch_assoc()['total'];
// Laporan Belum Dinilai
$laporan_pending = $conn->query("SELECT COUNT(*) as total FROM pengumpulan_tugas WHERE nilai IS NULL")->fetch_assoc()['total'];
?>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-gray-600">Total Praktikum</h3>
        <p class="text-3xl font-bold text-blue-600"><?php echo $total_praktikum; ?></p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-gray-600">Total Modul</h3>
        <p class="text-3xl font-bold text-indigo-600"><?php echo $total_modul; ?></p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-gray-600">Total Laporan Masuk</h3>
        <p class="text-3xl font-bold text-green-600"><?php echo $laporan_masuk; ?></p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-gray-600">Laporan Belum Dinilai</h3>
        <p class="text-3xl font-bold text-yellow-600"><?php echo $laporan_pending; ?></p>
    </div>
</div>

<?php require_once 'templates/footer.php'; ?>