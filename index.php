<?php
session_start();
require_once __DIR__ . '/includes/db.php';

// login status (aman)
$isLoggedIn = isset($_SESSION['user_id']) || isset($_SESSION['admin_logged_in']);

// ambil produk dari database
$sql = "SELECT * FROM products ORDER BY id ASC";
$result = mysqli_query($conn, $sql);

// pastikan selalu array
$products = [];
if ($result) {
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <title>PS Rental Indonesia - Sewa PlayStation Mudah dan Cepat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&amp;display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }
        /* Style untuk menyesuaikan gambar pada bagian game slideshow */
        .game-item img {
            width: 100%;
            height: 256px; /* Tinggi tetap */
            object-fit: cover; /* Pastikan gambar memenuhi area tanpa terdistorsi */
        }
    </style>
</head>
<body class="bg-gray-900 text-white relative">
    <header class="bg-gray-900 sticky top-0 z-50 border-b border-gray-700">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-4 py-3">
          <a
          class="flex items-center space-x-2 cursor-pointer"
          id="adminLogo"
          title="PS Rental Indonesia"
        >
          <img
            id="logo"
            src="assets/images/game/logo.png"
            alt="Logo PS Rental Indonesia"
            class="h-10 w-auto cursor-pointer"
          />
        </a>
            <nav class="hidden md:flex space-x-8 font-semibold text-gray-300">
                <a class="hover:text-white transition" href="#rental-packages">Paket</a>
                <a class="hover:text-white transition" href="#how-it-works">Cara Sewa</a>
                <a class="hover:text-white transition" href="#contact">Kontak</a>
            </nav>
            <div class="md:hidden">
                <button aria-label="Open menu" class="focus:outline-none" id="mobile-menu-button">
                    <i class="fas fa-bars text-2xl text-gray-300"></i>
                </button>
            </div>
        </div>
        <nav aria-label="Mobile menu" class="hidden bg-gray-800 border-t border-gray-700 md:hidden" id="mobile-menu">
            <a class="block px-4 py-3 border-b border-gray-700 hover:bg-gray-700 transition" href="#rental-packages">Paket Sewa</a>
            <a class="block px-4 py-3 border-b border-gray-700 hover:bg-gray-700 transition" href="#how-it-works">Cara Sewa</a>
            <a class="block px-4 py-3 border-b border-gray-700 hover:bg-gray-700 transition" href="#game-slideshow">Game Populer</a>
            <a class="block px-4 py-3 border-b border-gray-700 hover:bg-gray-700 transition" href="#testimonials">Testimoni</a>
            <a class="block px-4 py-3 hover:bg-gray-700 transition" href="#contact">Kontak</a>
        </nav>
    </header>

    <section class="relative bg-black">
        <img alt="Gamer playing PlayStation 5 with DualSense controller in cozy room with colorful LED lights" class="w-full object-cover max-h-[700px]" height="700" src="https://storage.googleapis.com/a1aa/image/d4635446-bfcc-4fa3-c144-a2ac21fd037f.jpg" width="1920"/>
        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent flex flex-col justify-center max-w-7xl mx-auto px-6 md:px-12" style="max-height: 700px;">
            <div class="max-w-xl text-white">
                <h1 class="text-4xl md:text-6xl font-extrabold mb-4 leading-tight">Sewa PlayStation Mudah dan Terjangkau</h1>
                <p class="text-lg md:text-xl mb-6">Nikmati pengalaman bermain game terbaik tanpa harus membeli konsol.</p>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 md:px-12 py-12 page-animate" id="game-slideshow">
    <h2 class="text-3xl font-bold mb-4 text-white text-center">
        Game Populer untuk Disewa
    </h2>

   <div class="relative max-w-5xl mx-auto group">

  <!-- Tombol Prev -->
  <button id="prevSlide"
    class="absolute left-0 top-1/2 -translate-y-1/2 bg-black/60 hover:bg-black text-white p-3 rounded-full z-10">
    ‹
  </button>

  <!-- Tombol Next -->
  <button id="nextSlide"
    class="absolute right-0 top-1/2 -translate-y-1/2 bg-black/60 hover:bg-black text-white p-3 rounded-full z-10">
    ›
  </button>

  <div class="overflow-hidden rounded-xl shadow-xl bg-black">
    <div id="game-slides-container"
      class="flex transition-transform duration-700 ease-in-out">

      <div class="min-w-full game-item relative">
        <img src="assets/images/game/call_of_duty_aw.png"
             class="w-full h-72 object-contain bg-black transition-transform duration-500 group-hover:scale-105"
             onerror="this.src='assets/images/game/call_of_duty_aw.png'">
        <div class="absolute bottom-0 w-full bg-black/70 text-center py-3">
          <h3 class="text-xl font-semibold">Call of Duty</h3>
        </div>
      </div>

      <div class="min-w-full game-item relative">
        <img src="assets/images/game/elder_ring.png"
             class="w-full h-72 object-contain bg-black transition-transform duration-500 group-hover:scale-105"
             onerror="this.src='assets/images/game/elder_ring.png'">
        <div class="absolute bottom-0 w-full bg-black/70 text-center py-3">
          <h3 class="text-xl font-semibold">Elden Ring</h3>
        </div>
      </div>

      <div class="min-w-full game-item relative">
        <img src="assets/images/game/pes.png"
             class="w-full h-72 object-contain bg-black transition-transform duration-500 group-hover:scale-105"
             onerror="this.src='assets/images/game/pes.png'">
        <div class="absolute bottom-0 w-full bg-black/70 text-center py-3">
          <h3 class="text-xl font-semibold">PES</h3>
        </div>
      </div>

       <div class="min-w-full game-item relative">
        <img src="assets/images/game/god-of-war-ragnarok.png"
             class="w-full h-72 object-contain bg-black transition-transform duration-500 group-hover:scale-105">
        <div class="absolute bottom-0 w-full bg-black/70 text-center py-3">
          <h3 class="text-xl font-semibold">God of War Ragnarok</h3>
        </div>
      </div>

      <div class="min-w-full game-item relative">
       <img
        src="assets/images/game/gta-v.png"
        class="w-full h-72 object-contain bg-black transition-transform duration-500 group-hover:scale-105">
        <div class="absolute bottom-0 w-full bg-black/70 text-center py-3">
          <h3 class="text-xl font-semibold">GTA 5</h3>
        </div>
      </div>

    </div>
  </div>
</div>

<section class="bg-gray-900 py-14 px-6 md:px-12 page-animate">
  <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 text-center">

    <div>
      <svg class="mx-auto w-10 h-10 text-green-400 mb-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path d="M9 12l2 2 4-4"/>
        <circle cx="12" cy="12" r="10"/>
      </svg>
      <p class="font-semibold">Unit Dicek Sebelum Dikirim</p>
    </div>

    <div>
      <svg class="mx-auto w-10 h-10 text-green-400 mb-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path d="M18 10a6 6 0 1 1-12 0"/>
        <path d="M12 14v7"/>
      </svg>
      <p class="font-semibold">Customer Service Aktif</p>
    </div>

    <div>
      <svg class="mx-auto w-10 h-10 text-green-400 mb-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path d="M12 3l7 4v6c0 5-3.5 8-7 9-3.5-1-7-4-7-9V7z"/>
      </svg>
      <p class="font-semibold">Aman & Terpercaya</p>
    </div>

  </div>
</section>


    <section id="how-it-works" class="bg-gray-800 py-16 px-6 md:px-12">
  <div class="max-w-7xl mx-auto text-center">
    <h2 class="text-3xl font-bold mb-4">Cara Sewa PlayStation</h2>
    <p class="text-gray-400 mb-12">
      Ikuti langkah mudah berikut untuk mulai bermain
    </p>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

      <div class="bg-gray-900 rounded-xl p-6 hover:shadow-xl transition">
        <svg class="mx-auto mb-4 w-12 h-12 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M3 3h18v4H3zM3 9h18v12H3z"/>
        </svg>
        <h3 class="font-semibold text-lg mb-2">Pilih Paket</h3>
        <p class="text-gray-400 text-sm">Tentukan konsol sesuai kebutuhan Anda.</p>
      </div>

      <div class="bg-gray-900 rounded-xl p-6 hover:shadow-xl transition">
        <svg class="mx-auto mb-4 w-12 h-12 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <circle cx="12" cy="12" r="10"/>
          <path d="M12 6v6l4 2"/>
        </svg>
        <h3 class="font-semibold text-lg mb-2">Tentukan Durasi</h3>
        <p class="text-gray-400 text-sm">Pilih sewa per jam atau per hari.</p>
      </div>

      <div class="bg-gray-900 rounded-xl p-6 hover:shadow-xl transition">
        <svg class="mx-auto mb-4 w-12 h-12 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <circle cx="12" cy="7" r="4"/>
          <path d="M5.5 21a6.5 6.5 0 0 1 13 0"/>
        </svg>
        <h3 class="font-semibold text-lg mb-2">Isi Data</h3>
        <p class="text-gray-400 text-sm">Lengkapi data pemesanan.</p>
      </div>

      <div class="bg-gray-900 rounded-xl p-6 hover:shadow-xl transition">
        <svg class="mx-auto mb-4 w-12 h-12 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M20 6L9 17l-5-5"/>
        </svg>
        <h3 class="font-semibold text-lg mb-2">Konsol Dikirim</h3>
        <p class="text-gray-400 text-sm">Pesanan diproses & dikirim.</p>
      </div>

    </div>
  </div>
</section>

    <section class="max-w-7xl mx-auto px-6 md:px-12 py-12" id="rental-packages">
  <h2 class="text-3xl font-bold mb-8 text-white text-center">
    Paket Sewa PlayStations
  </h2>

  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
    <?php foreach ($products as $ps): ?>
      <?php $isAvailable = (int)$ps['stock'] > 0; ?>

      <article class="bg-gray-800 rounded-lg overflow-hidden shadow-lg flex flex-col
        <?= $isAvailable ? 'hover:shadow-2xl' : 'opacity-60' ?>">

        <img
          src="assets/images/game/<?= explode('_', $ps['code'])[0] ?>.jpg"
          alt="<?= htmlspecialchars($ps['name']) ?>"
          class="w-full h-56 object-cover"
        />

        <div class="p-6 flex flex-col flex-grow">
          <h3 class="text-xl font-semibold mb-2">
            <?= htmlspecialchars($ps['name']) ?>
          </h3>

          <p class="text-blue-400 font-bold text-lg mb-2">
            Mulai dari Rp<?= number_format($ps['daily_rate'], 0, ',', '.') ?> / hari
          </p>

          <p class="text-blue-400 font-bold text-md mb-4">
            Atau Rp<?= number_format($ps['hourly_rate'], 0, ',', '.') ?> / jam
          </p>

          <!-- STATUS STOK -->
          <div class="text-sm font-semibold mb-4">
            <?php if ($isAvailable): ?>
              <span class="text-green-400">
                ✔ Tersedia: <?= $ps['stock'] ?> unit
              </span>
            <?php else: ?>
              <span class="text-red-400">
                ✖ Stok Habis
              </span>
            <?php endif; ?>
          </div>

          <!-- BUTTON -->
          <button
            class="sewa-btn w-full py-3 rounded-lg font-semibold transition
              <?= $isAvailable
                ? 'bg-blue-600 hover:bg-blue-700 text-white'
                : 'bg-gray-600 text-gray-300 cursor-not-allowed'
              ?>"
            data-package="<?= $ps['code'] ?>"
            <?= $isAvailable ? '' : 'disabled' ?>
          >
            Pesan
          </button>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
</section>

    </section>
    <section class="max-w-7xl mx-auto px-6 md:px-12 py-12" id="testimonials">
        <h2 class="text-3xl font-bold mb-8 text-white text-center">Apa Kata Pelanggan Kami</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <blockquote class="bg-gray-800 rounded-lg p-6 shadow-lg hover:shadow-2xl transition flex flex-col">
                <p class="text-gray-300 italic mb-4 flex-grow">"Sewa PS5 di sini sangat mudah dan cepat. Konsolnya selalu dalam kondisi bagus dan pengirimannya tepat waktu."</p>
                <footer class="text-blue-400 font-semibold">– Andi, Jakarta</footer>
            </blockquote>
            <blockquote class="bg-gray-800 rounded-lg p-6 shadow-lg hover:shadow-2xl transition flex flex-col">
                <p class="text-gray-300 italic mb-4 flex-grow">"Harga sewa terjangkau dan pilihan paket lengkap. Saya bisa main game favorit tanpa harus beli konsol."</p>
                <footer class="text-blue-400 font-semibold">– Sari, Bandung</footer>
            </blockquote>
            <blockquote class="bg-gray-800 rounded-lg p-6 shadow-lg hover:shadow-2xl transition flex flex-col">
                <p class="text-gray-300 italic mb-4 flex-grow">"Pelayanan customer service ramah dan responsif. Sangat direkomendasikan untuk yang ingin coba PS tanpa ribet."</p>
                <footer class="text-blue-400 font-semibold">– Budi, Surabaya</footer>
            </blockquote>
        </div>
    </section>


    <section class="bg-gradient-to-r from-black-800 to-blue-600 py-14 text-center">
  <h2 class="text-3xl font-bold mb-4">Siap Main Hari Ini?</h2>
  <p class="mb-6 text-blue-100">
    Sewa PlayStation sekarang tanpa harus membeli konsol.
  </p>
        <button
        id="btn-sewa-sekarang"
        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-md transition"
      >
        Sewa Sekarang
      </button>
</section>

    <section
  id="contact"
  class="bg-gradient-to-r from-blue-900 to-blue-700 py-16 px-6 md:px-12 hidden"
>
  <div class="max-w-3xl mx-auto text-white">
    <h2 class="text-4xl font-bold mb-6 text-center">
      Siap Main Hari Ini?
    </h2>
    <p class="text-center mb-8 text-blue-100">
      Sewa PlayStation sekarang tanpa harus membeli konsol.
    </p>

    <form
      id="rental-form"
      class="space-y-6"
      method="POST"
      action="process_order.php"
      novalidate
    >
      <!-- Nama -->
      <div>
        <label class="block mb-2 font-semibold" for="name">
          Nama Lengkap
        </label>
        <input
          id="name"
          name="name"
          type="text"
          required
          placeholder="Masukkan nama lengkap Anda"
          class="w-full rounded-md px-4 py-3 text-gray-900 focus:ring-2 focus:ring-blue-500"
        />
      </div>

      <!-- Email -->
      <div>
        <label class="block mb-2 font-semibold" for="email">
          Email
        </label>
        <input
          id="email"
          name="email"
          type="email"
          required
          placeholder="Masukkan email Anda"
          class="w-full rounded-md px-4 py-3 text-gray-900 focus:ring-2 focus:ring-blue-500"
        />
      </div>

      <!-- Telepon -->
      <div>
        <label class="block mb-2 font-semibold" for="phone">
          Nomor Telepon
        </label>
        <input
          id="phone"
          name="phone"
          type="tel"
          required
          placeholder="Masukkan nomor telepon Anda"
          class="w-full rounded-md px-4 py-3 text-gray-900 focus:ring-2 focus:ring-blue-500"
        />
      </div>

      <!-- Paket -->
      <div>
        <label class="block mb-2 font-semibold" for="package">
          Pilih Paket Sewa
        </label>
       <select
          id="package"
          name="package"
          class="hidden"
        >
          <option value="">-- Pilih Paket --</option>
          <option value="ps5_standard">PS5 Standard</option>
          <option value="ps4_pro">PS4 Pro</option>
          <option value="ps3_classic">PS3 Classic</option>
        </select>
      </div>
      <!-- Tanggal -->
      <div>
        <label class="block mb-2 font-semibold" for="rental-date">
          Tanggal Mulai Sewa
        </label>
        <input
            type="date"
            id="rental-date"
            name="rental_date"
            min="<?php echo date('Y-m-d'); ?>"
            required
            class="w-full rounded-md px-4 py-3 text-gray-900"
          />
      </div>

      <!-- Jenis Durasi -->
      <div>
        <label class="block mb-2 font-semibold" for="duration-type">
          Jenis Durasi
        </label>
        <select
          id="duration-type"
          name="duration_type"
          required
          class="w-full rounded-md px-4 py-3 text-gray-900 focus:ring-2 focus:ring-blue-500"
        >
          <option value="hari">Hari</option>
          <option value="jam">Jam</option>
        </select>
      </div>

      <!-- Durasi -->
      <div>
        <label class="block mb-2 font-semibold" for="duration">
          Durasi Sewa (<span id="duration-unit">hari</span>)
        </label>
        <input
          id="duration"
          name="duration"
          type="number"
          min="1"
          required
          placeholder="Masukkan durasi sewa"
          class="w-full rounded-md px-4 py-3 text-gray-900 focus:ring-2 focus:ring-blue-500"
        />
      </div>

      <!-- Total Harga -->
      <div class="text-xl font-bold text-center">
        Total Harga:
        <span id="total-price">Rp0</span>
        <input
          type="hidden"
          id="hidden-total-price"
          name="total_price_hidden"
          value="0"
        />
      </div>

      <!-- Submit -->
      <button
        type="submit"
        class="w-full bg-blue-700 hover:bg-blue-800 text-white font-semibold px-6 py-3 rounded-md transition"
      >
        Sewa Sekarang
      </button>
    </form>
  </div>
</section>

    <footer class="bg-gray-900 border-t border-gray-700 py-10 px-6 md:px-12 mt-12">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8 text-gray-400 text-sm">
            <div>
                <h4 class="text-white font-semibold mb-4">PS Rental Indonesia</h4>
                <p class="mb-4 max-w-xs">Sewa PlayStation mudah dan terpercaya di Indonesia. Nikmati game favorit tanpa harus membeli konsol.</p>
                <div class="flex space-x-4 text-gray-400">
                    <a aria-label="Facebook" class="hover:text-white" href="#"><i class="fab fa-facebook-f fa-lg"></i></a>
                    <a aria-label="Twitter" class="hover:text-white" href="#"><i class="fab fa-twitter fa-lg"></i></a>
                    <a aria-label="YouTube" class="hover:text-white" href="#"><i class="fab fa-youtube fa-lg"></i></a>
                    <a aria-label="Instagram" class="hover:text-white" href="#"><i class="fab fa-instagram fa-lg"></i></a>
                </div>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-4">Layanan</h4>
                <ul class="space-y-2">
                    <li><a class="hover:text-white" href="#rental-packages">Paket Sewa</a></li>
                    <li><a class="hover:text-white" href="#how-it-works">Cara Sewa</a></li>
                    <li><a class="hover:text-white" href="#contact">Hubungi Kami</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-4">Bantuan</h4>
                <ul class="space-y-2">
                    <li><a class="hover:text-white" href="#">FAQ</a></li>
                    <li><a class="hover:text-white" href="#">Kebijakan Pengembalian</a></li>
                    <li><a class="hover:text-white" href="#">Syarat &amp; Ketentuan</a></li>
                    <li><a class="hover:text-white text-blue-400" href="admin.php">Admin Panel</a></li> </ul>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-4">Kontak</h4>
                <p class="mb-2">Email: support@psrental.id</p>
                <p class="mb-2">Telepon: +62 812-3456-7890</p>
                <p>Alamat: Jl. Gaming No. 123, Jakarta, Indonesia</p>
            </div>
        </div>
    </footer>
    <script src="assets/js/script.js"></script>
</body>
</html>