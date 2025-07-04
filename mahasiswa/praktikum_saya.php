<?php
require_once '../config.php';
$pageTitle = 'Praktikum Saya';
$activePage = 'praktikum_saya';
require_once 'templates/header_mahasiswa.php';

$id_mahasiswa = $_SESSION['user_id'];
$sql = "SELECT mp.id, mp.nama_praktikum, mp.deskripsi 
        FROM mata_praktikum mp
        JOIN pendaftaran_praktikum pp ON mp.id = pp.id_praktikum
        WHERE pp.id_mahasiswa = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_mahasiswa);
$stmt->execute();
$result = $stmt->get_result();
?>

<h1 class="text-3xl font-bold text-gray-800 mb-6">Praktikum yang Saya Ikuti</h1>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
        <div class="bg-white p-6 rounded-lg shadow-md flex flex-col">
            <h2 class="text-xl font-bold mb-2 text-gray-800"><?php echo htmlspecialchars($row['nama_praktikum']); ?></h2>
            <p class="text-gray-600 mb-4 flex-grow"><?php echo htmlspecialchars($row['deskripsi']); ?></p>
            <a href="detail_praktikum.php?id=<?php echo $row['id']; ?>" class="w-full text-center bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Lihat Detail</a>
        </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="col-span-3 text-gray-600">Anda belum mendaftar di praktikum manapun. Silakan <a href="katalog_praktikum.php" class="text-blue-500 hover:underline">cari praktikum</a>.</p>
    <?php endif; ?>
</div>

<?php require_once 'templates/footer_mahasiswa.php'; ?>