<?php
require_once '../config.php';
$pageTitle = 'Detail Laporan';
$activePage = 'laporan';
require_once 'templates/header.php';

$id_laporan = $_GET['id'];
$sql = "SELECT pt.*, u.nama as nama_mahasiswa, m.nama_modul 
        FROM pengumpulan_tugas pt 
        JOIN users u ON pt.id_mahasiswa = u.id
        JOIN modul m ON pt.id_modul = m.id
        WHERE pt.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_laporan);
$stmt->execute();
$laporan = $stmt->get_result()->fetch_assoc();
?>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-2">Penilaian Laporan</h2>
    <p class="mb-1"><strong>Mahasiswa:</strong> <?php echo htmlspecialchars($laporan['nama_mahasiswa']); ?></p>
    <p class="mb-4"><strong>Modul:</strong> <?php echo htmlspecialchars($laporan['nama_modul']); ?></p>
    <a href="../uploads/laporan/<?php echo htmlspecialchars($laporan['file_laporan']); ?>" class="inline-block bg-blue-500 text-white px-4 py-2 rounded-lg mb-6" download>Unduh Laporan</a>
    
    <form action="proses_nilai.php" method="POST">
        <input type="hidden" name="id_laporan" value="<?php echo $id_laporan; ?>">
        <div class="mb-4">
            <label for="nilai" class="block text-gray-700 font-semibold mb-2">Nilai (0-100)</label>
            <input type="number" name="nilai" id="nilai" min="0" max="100" class="w-full px-3 py-2 border rounded-lg" value="<?php echo $laporan['nilai']; ?>" required>
        </div>
        <div class="mb-4">
            <label for="feedback" class="block text-gray-700 font-semibold mb-2">Feedback</label>
            <textarea name="feedback" id="feedback" rows="5" class="w-full px-3 py-2 border rounded-lg"><?php echo htmlspecialchars($laporan['feedback']); ?></textarea>
        </div>
        <div class="flex justify-end">
            <a href="laporan_masuk.php" class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2">Kembali</a>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg">Simpan Nilai</button>
        </div>
    </form>
</div>

<?php require_once 'templates/footer.php'; ?>