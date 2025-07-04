<?php

session_start();
require_once 'config.php';
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'asisten') { header("Location: asisten/dashboard.php"); } 
    else { header("Location: mahasiswa/dashboard.php"); }
    exit();
}
$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    if (empty($email) || empty($password)) {
        $message = "Email dan password harus diisi!";
    } else {
        $sql = "SELECT id, nama, email, password, role FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['nama'] = $user['nama'];
                $_SESSION['role'] = $user['role'];
                if ($user['role'] == 'asisten') { header("Location: asisten/dashboard.php"); } 
                else { header("Location: mahasiswa/dashboard.php"); }
                exit();
            } else { $message = "Password yang Anda masukkan salah."; }
        } else { $message = "Akun dengan email tersebut tidak ditemukan."; }
        $stmt->close();
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistem Praktikum</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-10 rounded-xl shadow-lg w-full max-w-sm transform transition-all duration-500 hover:shadow-2xl">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight">SIMPRAK</h1>
            <p class="text-gray-500 mt-2">Sistem Informasi Praktikum</p>
        </div>
        
        <?php 
            if (isset($_GET['status']) && $_GET['status'] == 'registered') {
                echo '<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert"><p class="font-bold">Sukses!</p><p>Registrasi berhasil! Silakan login.</p></div>';
            }
            if (!empty($message)) {
                echo '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert"><p class="font-bold">Oops!</p><p>' . htmlspecialchars($message) . '</p></div>';
            }
        ?>

        <form action="login.php" method="post" class="space-y-6">
            <div>
                <label for="email" class="sr-only">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                    <input type="email" id="email" name="email" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-shadow" placeholder="Email Anda" required>
                </div>
            </div>
            <div>
                <label for="password" class="sr-only">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input type="password" id="password" name="password" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-shadow" placeholder="Password" required>
                </div>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-300 font-semibold text-lg shadow-md hover:shadow-lg transform hover:-translate-y-1">
                Login
            </button>
        </form>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-600">Belum punya akun? <a href="register.php" class="text-blue-600 hover:underline font-medium">Daftar sekarang</a></p>
        </div>
    </div>

</body>
</html>