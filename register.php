<?php

require_once 'config.php';
$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);
    if (empty($nama) || empty($email) || empty($password) || empty($role)) {
        $message = "Semua field harus diisi!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Format email tidak valid!";
    } elseif (!in_array($role, ['mahasiswa', 'asisten'])) {
        $message = "Peran tidak valid!";
    } else {
        $sql = "SELECT id FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $message = "Email sudah terdaftar. Silakan gunakan email lain.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $sql_insert = "INSERT INTO users (nama, email, password, role) VALUES (?, ?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("ssss", $nama, $email, $hashed_password, $role);
            if ($stmt_insert->execute()) {
                header("Location: login.php?status=registered");
                exit();
            } else { $message = "Terjadi kesalahan. Silakan coba lagi."; }
            $stmt_insert->close();
        }
        $stmt->close();
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi - Sistem Praktikum</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen py-10">

    <div class="bg-white p-10 rounded-xl shadow-lg w-full max-w-sm transform transition-all duration-500 hover:shadow-2xl">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Buat Akun Baru</h1>
            <p class="text-gray-500 mt-1">Gabung dengan Sistem Praktikum</p>
        </div>

        <?php if (!empty($message)): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <p class="font-bold">Terjadi Kesalahan</p>
                <p><?php echo htmlspecialchars($message); ?></p>
            </div>
        <?php endif; ?>

        <form action="register.php" method="post" class="space-y-5">
            <div>
                <label for="nama" class="sr-only">Nama Lengkap</label>
                <div class="relative">
                     <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <input type="text" id="nama" name="nama" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Nama Lengkap" required>
                </div>
            </div>
            <div>
                <label for="email" class="sr-only">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                    <input type="email" id="email" name="email" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Email Anda" required>
                </div>
            </div>
            <div>
                <label for="password" class="sr-only">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input type="password" id="password" name="password" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Password" required>
                </div>
            </div>
             <div>
                <label for="role" class="sr-only">Daftar Sebagai</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user-graduate text-gray-400"></i>
                    </div>
                    <select id="role" name="role" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 appearance-none" required>
                        <option value="" disabled selected>Pilih peran Anda...</option>
                        <option value="mahasiswa">Mahasiswa</option>
                        <option value="asisten">Asisten</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-300 transition-all duration-300 font-semibold text-lg shadow-md hover:shadow-lg transform hover:-translate-y-1">
                Daftar
            </button>
        </form>

         <div class="text-center mt-6">
            <p class="text-sm text-gray-600">Sudah punya akun? <a href="login.php" class="text-blue-600 hover:underline font-medium">Login di sini</a></p>
        </div>
    </div>

</body>
</html>