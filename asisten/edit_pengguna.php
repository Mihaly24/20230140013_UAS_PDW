<?php
require_once '../config.php';
$pageTitle = 'Edit Pengguna';
$activePage = 'pengguna';
require_once 'templates/header.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT nama, email, role FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6">Form Edit Pengguna</h2>
    <form action="proses_edit_pengguna.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="mb-4">
            <label for="nama" class="block text-gray-700 font-semibold mb-2">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" class="w-full px-3 py-2 border rounded-lg" value="<?php echo htmlspecialchars($user['nama']); ?>" required>
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
            <input type="email" id="email" name="email" class="w-full px-3 py-2 border rounded-lg" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        <div class="mb-4">
            <label for="password" class="block text-gray-700 font-semibold mb-2">Password Baru</label>
            <input type="password" id="password" name="password" class="w-full px-3 py-2 border rounded-lg" placeholder="Kosongkan jika tidak ingin diubah">
        </div>
        <div class="mb-4">
            <label for="role" class="block text-gray-700 font-semibold mb-2">Role</label>
            <select id="role" name="role" class="w-full px-3 py-2 border rounded-lg" required>
                <option value="mahasiswa" <?php echo ($user['role'] == 'mahasiswa') ? 'selected' : ''; ?>>Mahasiswa</option>
                <option value="asisten" <?php echo ($user['role'] == 'asisten') ? 'selected' : ''; ?>>Asisten</option>
            </select>
        </div>
        <div class="flex justify-end">
            <a href="kelola_pengguna.php" class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2 hover:bg-gray-600">Batal</a>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">Update</button>
        </div>
    </form>
</div>

<?php require_once 'templates/footer.php'; ?>