<?php
// login.php (Formulir Login Universal)
session_start();

// Inisialisasi variabel untuk pesan error dan sukses
$login_error = '';
if (isset($_SESSION['login_error'])) {
    $login_error = $_SESSION['login_error'];
    unset($_SESSION['login_error']); // Hapus pesan error setelah ditampilkan
}

$registration_success = ''; // Untuk menampilkan pesan jika registrasi berhasil
if (isset($_SESSION['reg_success'])) {
    $registration_success = $_SESSION['reg_success'];
    unset($_SESSION['reg_success']); // Hapus pesan sukses setelah ditampilkan
}

// Inisialisasi variabel untuk mengisi ulang email form jika ada error login
$old_login_email = $_SESSION['old_login_email'] ?? '';
unset($_SESSION['old_login_email']); // Hapus email lama setelah diambil
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - PS Rental Indonesia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-900 text-white flex items-center justify-center min-h-screen px-4">
    <div class="bg-gray-800 p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Login Akun</h2>

        <?php if ($login_error): ?>
            <div class="bg-red-500 text-white p-3 rounded-md mb-4 text-center">
                <?php echo htmlspecialchars($login_error); ?>
            </div>
        <?php endif; ?>

        <?php if ($registration_success): ?>
            <div class="bg-green-500 text-white p-3 rounded-md mb-4 text-center">
                <?php echo htmlspecialchars($registration_success); ?>
            </div>
        <?php endif; ?>

        <form method="post" action="login_process.php" class="space-y-5">
            <div>
                <label class="block mb-2 font-semibold" for="email">Email</label>
                <input type="email" id="email" name="email" required class="w-full px-4 py-3 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?php echo htmlspecialchars($old_login_email); ?>" />
            </div>
            <div>
                <label class="block mb-2 font-semibold" for="password">Password</label>
                <input type="password" id="password" name="password" required class="w-full px-4 py-3 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
            <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white font-semibold py-3 rounded-md transition">Login</button>
        </form>
        <p class="text-sm text-center mt-4">Belum punya akun? <a href="register.php" class="text-blue-400 hover:underline">Daftar di sini</a></p>
        <p class="text-sm text-center mt-2">Kembali ke <a href="index.php" class="text-blue-400 hover:underline">Halaman Utama</a></p>
    </div>
</body>
</html>