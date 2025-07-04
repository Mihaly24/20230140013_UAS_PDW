<?php
require_once '../config.php';
$pageTitle = 'Kelola Pengguna';
$activePage = 'pengguna';
require_once 'templates/header.php';
$result = $conn->query("SELECT id, nama, email, role FROM users ORDER BY role, nama");
?>

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Daftar Pengguna Sistem</h1>
    <a href="tambah_pengguna.php" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
        <i class="fas fa-plus mr-2"></i>Tambah Pengguna
    </a>
</div>

<?php if(isset($_GET['status'])): ?>
<div class="mb-4 p-4 text-sm rounded-lg <?php echo $_GET['status'] == 'sukses' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
    <?php echo htmlspecialchars($_GET['pesan']); ?>
</div>
<?php endif; ?>

<div class="bg-white shadow-md rounded-lg overflow-x-auto">
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold uppercase">Nama</th>
                <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold uppercase">Email</th>
                <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold uppercase">Role</th>
                <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td class="px-5 py-5 border-b bg-white text-sm"><?php echo htmlspecialchars($row['nama']); ?></td>
                <td class="px-5 py-5 border-b bg-white text-sm"><?php echo htmlspecialchars($row['email']); ?></td>
                <td class="px-5 py-5 border-b bg-white text-sm">
                    <span class="px-2 py-1 font-semibold leading-tight rounded-full <?php echo $row['role'] == 'asisten' ? 'bg-green-200 text-green-900' : 'bg-blue-200 text-blue-900'; ?>">
                        <?php echo ucfirst($row['role']); ?>
                    </span>
                </td>
                <td class="px-5 py-5 border-b bg-white text-sm">
                    <a href="edit_pengguna.php?id=<?php echo $row['id']; ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                    <?php if ($row['id'] != $_SESSION['user_id']): // Mencegah menghapus diri sendiri ?>
                    <a href="hapus_pengguna.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Anda yakin? Akun ini akan dihapus permanen!')" class="text-red-600 hover:text-red-900">Hapus</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php require_once 'templates/footer.php'; ?>