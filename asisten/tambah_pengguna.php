<?php
$pageTitle = 'Tambah Pengguna';
$activePage = 'pengguna';
require_once 'templates/header.php';
?>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6">Form Tambah Pengguna Baru</h2>
    <form action="proses_tambah_pengguna.php" method="POST">
        <div class="mb-4">
            <label for="nama" class="block text-gray-700 font-semibold mb-2">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" class="w-full px-3 py-2 border rounded-lg" required>
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
            <input type="email" id="email" name="email" class="w-full px-3 py-2 border rounded-lg" required>
        </div>
        <div class="mb-4">
            <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
            <input type="password" id="password" name="password" class="w-full px-3 py-2 border rounded-lg" required>
        </div>
        <div class="mb-4">
            <label for="role" class="block text-gray-700 font-semibold mb-2">Role</label>
            <select id="role" name="role" class="w-full px-3 py-2 border rounded-lg" required>
                <option value="mahasiswa">Mahasiswa</option>
                <option value="asisten">Asisten</option>
            </select>
        </div>
        <div class="flex justify-end">
            <a href="kelola_pengguna.php" class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2 hover:bg-gray-600">Batal</a>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Simpan</button>
        </div>
    </form>
</div>

<?php require_once 'templates/footer.php'; ?>