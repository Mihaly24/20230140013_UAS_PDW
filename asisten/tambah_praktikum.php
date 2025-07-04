<?php
require_once '../config.php';
$pageTitle = 'Tambah Mata Praktikum';
$activePage = 'praktikum';
require_once 'templates/header.php';
?>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6">Form Tambah Praktikum</h2>
    <form action="proses_tambah_praktikum.php" method="POST">
        <div class="mb-4">
            <label for="nama_praktikum" class="block text-gray-700 font-semibold mb-2">Nama Praktikum</label>
            <input type="text" id="nama_praktikum" name="nama_praktikum" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
        </div>
        <div class="mb-4">
            <label for="deskripsi" class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></textarea>
        </div>
        <div class="flex justify-end">
            <a href="kelola_praktikum.php" class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2 hover:bg-gray-600">Batal</a>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Simpan</button>
        </div>
    </form>
</div>

<?php require_once 'templates/footer.php'; ?>