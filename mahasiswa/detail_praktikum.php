<?php
require_once '../config.php';
$pageTitle = 'Detail Praktikum';
$activePage = 'praktikum_saya';
require_once 'templates/header_mahasiswa.php';

if (!isset($_GET['id'])) {
    header("Location: praktikum_saya.php");
    exit();
}
$id_praktikum = $_GET['id'];
$id_mahasiswa = $_SESSION['user_id'];

// Get praktikum name
$stmt_prak = $conn->prepare("SELECT nama_praktikum FROM mata_praktikum WHERE id = ?");
$stmt_prak->bind_param("i", $id_praktikum);
$stmt_prak->execute();
$praktikum = $stmt_prak->get_result()->fetch_assoc();

// Get modules and submission status
$sql = "SELECT m.id, m.nama_modul, m.file_materi, pt.file_laporan, pt.nilai, pt.feedback
        FROM modul m
        LEFT JOIN pengumpulan_tugas pt ON m.id = pt.id_modul AND pt.id_mahasiswa = ?
        WHERE m.id_praktikum = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_mahasiswa, $id_praktikum);
$stmt->execute();
$result = $stmt->get_result();
?>

<a href="praktikum_saya.php" class="text-blue-500 hover:underline mb-6 inline-block">&larr; Kembali ke Praktikum Saya</a>
<h1 class="text-3xl font-bold text-gray-800 mb-6"><?php echo htmlspecialchars($praktikum['nama_praktikum']); ?></h1>

<?php
if (isset($_GET['sukses'])) {
    echo '<div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">' . htmlspecialchars($_GET['sukses']) . '</div>';
}
if (isset($_GET['error'])) {
    echo '<div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">' . htmlspecialchars($_GET['error']) . '</div>';
}
?>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Daftar Modul</h2>
    <div class="space-y-6">
        <?php while ($modul = $result->fetch_assoc()): ?>
            <div class="border border-gray-200 p-4 rounded-lg">
                <h3 class="text-xl font-semibold"><?php echo htmlspecialchars($modul['nama_modul']); ?></h3>
                
                <?php if ($modul['file_materi']): ?>
                    <a href="../uploads/materi/<?php echo htmlspecialchars($modul['file_materi']); ?>" class="text-blue-500 hover:underline" download>Unduh Materi</a>
                <?php else: ?>
                    <span class="text-gray-400">Materi belum tersedia</span>
                <?php endif; ?>

                <div class="mt-4 border-t pt-4">
                    <?php if ($modul['file_laporan']): ?>
                        <h4 class="font-semibold">Laporan Anda:</h4>
                        <p>Sudah dikumpulkan.</p>
                        <div class="mt-2 p-3 bg-gray-50 rounded-md">
                            <h5 class="font-semibold">Status Penilaian:</h5>
                            <?php if ($modul['nilai'] !== null): ?>
                                <p class="text-green-600"><strong>Nilai:</strong> <?php echo $modul['nilai']; ?></p>
                                <p><strong>Feedback:</strong> <?php echo nl2br(htmlspecialchars($modul['feedback'])); ?></p>
                            <?php else: ?>
                                <p class="text-yellow-600">Menunggu penilaian dari asisten.</p>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <form action="proses_kumpul_tugas.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id_modul" value="<?php echo $modul['id']; ?>">
                            <input type="hidden" name="id_praktikum" value="<?php echo $id_praktikum; ?>">
                            <label for="file_laporan_<?php echo $modul['id']; ?>" class="block mb-2 text-sm font-medium text-gray-900">Kumpulkan Laporan:</label>
                            <div class="flex items-center">
                                <input type="file" name="file_laporan" id="file_laporan_<?php echo $modul['id']; ?>" class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer focus:outline-none" required>
                                <button type="submit" class="ml-4 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">Kumpul</button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php require_once 'templates/footer_mahasiswa.php'; ?>