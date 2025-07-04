<?php
require_once '../config.php';
$pageTitle = 'Laporan Masuk';
$activePage = 'laporan';
require_once 'templates/header.php';

// Filter
$filter_praktikum = $_GET['filter_praktikum'] ?? '';
$where_clause = '';
if (!empty($filter_praktikum)) {
    $where_clause = "WHERE m.id_praktikum = " . intval($filter_praktikum);
}

$sql = "SELECT pt.id, u.nama as nama_mahasiswa, mp.nama_praktikum, m.nama_modul, pt.file_laporan, pt.nilai, pt.tanggal_kumpul
        FROM pengumpulan_tugas pt
        JOIN users u ON pt.id_mahasiswa = u.id
        JOIN modul m ON pt.id_modul = m.id
        JOIN mata_praktikum mp ON m.id_praktikum = mp.id
        $where_clause
        ORDER BY pt.tanggal_kumpul DESC";
$result = $conn->query($sql);

$praktikums = $conn->query("SELECT id, nama_praktikum FROM mata_praktikum");
?>
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Daftar Laporan Masuk</h1>
    <form method="GET" class="flex items-center">
        <select name="filter_praktikum" class="border rounded-l-lg p-2">
            <option value="">Semua Praktikum</option>
            <?php while($prak = $praktikums->fetch_assoc()): ?>
                <option value="<?php echo $prak['id']; ?>" <?php echo ($filter_praktikum == $prak['id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($prak['nama_praktikum']); ?>
                </option>
            <?php endwhile; ?>
        </select>
        <button type="submit" class="bg-blue-500 text-white p-2 rounded-r-lg">Filter</button>
    </form>
</div>
<div class="bg-white shadow-md rounded-lg overflow-x-auto">
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold uppercase">Mahasiswa</th>
                <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold uppercase">Praktikum / Modul</th>
                <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold uppercase">Tanggal</th>
                <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold uppercase">Status</th>
                <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td class="px-5 py-5 border-b bg-white text-sm"><?php echo htmlspecialchars($row['nama_mahasiswa']); ?></td>
                <td class="px-5 py-5 border-b bg-white text-sm">
                    <strong><?php echo htmlspecialchars($row['nama_praktikum']); ?></strong><br>
                    <?php echo htmlspecialchars($row['nama_modul']); ?>
                </td>
                <td class="px-5 py-5 border-b bg-white text-sm"><?php echo date('d M Y, H:i', strtotime($row['tanggal_kumpul'])); ?></td>
                <td class="px-5 py-5 border-b bg-white text-sm">
                    <?php if($row['nilai'] !== null): ?>
                        <span class="text-green-600 font-semibold">Sudah Dinilai (<?php echo $row['nilai']; ?>)</span>
                    <?php else: ?>
                        <span class="text-yellow-600 font-semibold">Belum Dinilai</span>
                    <?php endif; ?>
                </td>
                <td class="px-5 py-5 border-b bg-white text-sm">
                    <a href="../uploads/laporan/<?php echo htmlspecialchars($row['file_laporan']); ?>" class="text-blue-600 mr-3" download>Unduh</a>
                    <a href="detail_laporan.php?id=<?php echo $row['id']; ?>" class="text-indigo-600">Beri Nilai</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php require_once 'templates/footer.php'; ?>