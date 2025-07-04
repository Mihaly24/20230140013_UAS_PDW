<?php
require_once '../config.php';
$pageTitle = 'Kelola Mata Praktikum';
$activePage = 'praktikum';
require_once 'templates/header.php';

$result = $conn->query("SELECT * FROM mata_praktikum ORDER BY id DESC");
?>

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Daftar Mata Praktikum</h1>
    <a href="tambah_praktikum.php" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Tambah Praktikum</a>
</div>

<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Nama Praktikum</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($row['nama_praktikum']); ?></td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                    <a href="kelola_modul.php?id_praktikum=<?php echo $row['id']; ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">Modul</a>
                    <a href="edit_praktikum.php?id=<?php echo $row['id']; ?>" class="text-green-600 hover:text-green-900 mr-3">Edit</a>
                    <a href="hapus_praktikum.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Anda yakin?')" class="text-red-600 hover:text-red-900">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php require_once 'templates/footer.php'; ?>