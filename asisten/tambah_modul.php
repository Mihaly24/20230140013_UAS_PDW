<?php
require_once '../config.php';
$pageTitle = 'Tambah Modul';
$activePage = 'praktikum';
require_once 'templates/header.php';
$id_praktikum = $_GET['id_praktikum'];
?>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6">Form Tambah Modul</h2>
    <form action="proses_tambah_modul.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_praktikum" value="<?php echo $id_praktikum; ?>">
        <div class="mb-4">
            <label for="nama_modul" class="block text-gray-700 font-semibold mb-2">Nama Modul</label>
            <input type="text" id="nama_modul" name="nama_modul" class="w-full px-3 py-2 border rounded-lg" required>
        </div>
        <div class="mb-4">
            <label for="file_materi" class="block text-gray-700 font-semibold mb-2">File Materi (Opsional)</label>
            <input type="file" id="file_materi" name="file_materi" class="w-full px-3 py-2 border rounded-lg">
        </div>
        <div class="flex justify-end">
            <a href="kelola_modul.php?id_praktikum=<?php echo $id_praktikum; ?>" class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2">Batal</a>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Simpan</button>
        </div>
    </form>
</div>

<?php require_once 'templates/footer.php'; ?>