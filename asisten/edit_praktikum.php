<?php
require_once '../config.php';
$pageTitle = 'Edit Mata Praktikum';
$activePage = 'praktikum';
require_once 'templates/header.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM mata_praktikum WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$praktikum = $result->fetch_assoc();
?>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6">Form Edit Praktikum</h2>
    <form action="proses_edit_praktikum.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $praktikum['id']; ?>">
        <div class="mb-4">
            <label for="nama_praktikum" class="block text-gray-700 font-semibold mb-2">Nama Praktikum</label>
            <input type="text" id="nama_praktikum" name="nama_praktikum" class="w-full px-3 py-2 border border-gray-300 rounded-lg" value="<?php echo htmlspecialchars($praktikum['nama_praktikum']); ?>" required>
        </div>
        <div class="mb-4">
            <label for="deskripsi" class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg"><?php echo htmlspecialchars($praktikum['deskripsi']); ?></textarea>
        </div>
        <div class="flex justify-end">
            <a href="kelola_praktikum.php" class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2 hover:bg-gray-600">Batal</a>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">Update</button>
        </div>
    </form>
</div>

<?php require_once 'templates/footer.php'; ?>