<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pembayaran Berhasil</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-900 to-blue-600">

  <div class="bg-white rounded-xl shadow-xl p-10 max-w-md text-center animate-fade-in">
    <div class="flex justify-center mb-6">
      <div class="bg-green-100 text-green-600 rounded-full p-4">
        ✅
      </div>
    </div>

    <h1 class="text-3xl font-bold text-gray-800 mb-3">
      Pembayaran Berhasil
    </h1>

    <p class="text-gray-600 mb-6">
      Pesanan kamu sudah kami terima dan sedang diproses.
    </p>

    <a href="index.php"
       class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">
      Kembali ke Beranda
    </a>
  </div>

  <style>
    @keyframes fade-in {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
      animation: fade-in 0.6s ease-out;
    }
  </style>

</body>
</html>
