<?php
require_once '../config.php';
$pageTitle = 'Katalog Praktikum';
$activePage = 'katalog';
require_once 'templates/header_mahasiswa.php';

$id_mahasiswa = $_SESSION['user_id'];
// Query untuk cek apakah mahasiswa sudah terdaftar di praktikum tsb
$sql = "SELECT mp.*, (SELECT COUNT(*) FROM pendaftaran_praktikum pp WHERE pp.id_praktikum = mp.id AND pp.id_mahasiswa = ?) as terdaftar 
        FROM mata_praktikum mp";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_mahasiswa);
$stmt->execute();
$result = $stmt->get_result();
?>

<h1 class="text-3xl font-bold text-gray-800 mb-6">Katalog Mata Praktikum</h1>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php while ($row = $result->fetch_assoc()): ?>
    <div class="bg-white p-6 rounded-lg shadow-md flex flex-col">
        <h2 class="text-xl font-bold mb-2 text-gray-800"><?php echo htmlspecialchars($row['nama_praktikum']); ?></h2>
        <p class="text-gray-600 mb-4 flex-grow"><?php echo htmlspecialchars($row['deskripsi']); ?></p>
        <?php if ($row['terdaftar'] > 0): ?>
            <button class="w-full bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed">Sudah Terdaftar</button>
        <?php else: ?>
            <a href="proses_daftar_praktikum.php?id=<?php echo $row['id']; ?>" class="w-full text-center bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Daftar</a>
        <?php endif; ?>
    </div>
    <?php endwhile; ?>
</div>

<?php require_once 'templates/footer_mahasiswa.php'; ?>