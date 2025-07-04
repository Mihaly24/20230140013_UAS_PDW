<?php
require_once '../config.php';
$pageTitle = 'Kelola Modul';
$activePage = 'praktikum';
require_once 'templates/header.php';

$id_praktikum = $_GET['id_praktikum'];

$stmt_prak = $conn->prepare("SELECT nama_praktikum FROM mata_praktikum WHERE id = ?");
$stmt_prak->bind_param("i", $id_praktikum);
$stmt_prak->execute();
$praktikum = $stmt_prak->get_result()->fetch_assoc();

$stmt_modul = $conn->prepare("SELECT * FROM modul WHERE id_praktikum = ? ORDER BY id DESC");
$stmt_modul->bind_param("i", $id_praktikum);
$stmt_modul->execute();
$result = $stmt_modul->get_result();
?>

<a href="kelola_praktikum.php" class="text-blue-500 hover:underline mb-6 inline-block">&larr; Kembali ke Daftar Praktikum</a>
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Modul untuk: <?php echo htmlspecialchars($praktikum['nama_praktikum']); ?></h1>
    <a href="tambah_modul.php?id_praktikum=<?php echo $id_praktikum; ?>" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Tambah Modul</a>
</div>

<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold uppercase">Nama Modul</th>
                <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold uppercase">File Materi</th>
                <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td class="px-5 py-5 border-b bg-white text-sm"><?php echo htmlspecialchars($row['nama_modul']); ?></td>
                <td class="px-5 py-5 border-b bg-white text-sm">
                    <?php if($row['file_materi']): ?>
                        <a href="../uploads/materi/<?php echo htmlspecialchars($row['file_materi']); ?>" class="text-blue-500" download>Unduh</a>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td class="px-5 py-5 border-b bg-white text-sm">
                    <a href="hapus_modul.php?id=<?php echo $row['id']; ?>&id_praktikum=<?php echo $id_praktikum; ?>" onclick="return confirm('Anda yakin?')" class="text-red-600 hover:text-red-900">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php require_once 'templates/footer.php'; ?>