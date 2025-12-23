<?php
session_start(); // Selalu mulai session di awal file PHP yang menggunakan session

// Cek apakah user sedang login (untuk tampilan Sign In/Logout di navbar)
$isLoggedIn = isset($_SESSION['user_id']); // Cek apakah user biasa login
if (!$isLoggedIn && isset($_SESSION['admin_logged_in'])) {
    // Jika bukan user biasa tapi admin yang login, anggap juga sebagai 'logged in' untuk tampilan navbar
    $isLoggedIn = true;
}


// Data paket sewa untuk harga per jam (disimpan tapi tidak lagi ditampilkan di sidebar)
$psPackages = [
    'ps5_standard' => ['name' => 'PS5 Standard Edition', 'hourly_rate' => 25000],
    'ps4_pro' => ['name' => 'PS4 Pro Edition', 'hourly_rate' => 15000],
    'ps3_classic' => ['name' => 'PS3 Classic Edition', 'hourly_rate' => 10000],
];

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

    <div class="bg-black text-gray-400 text-xs py-1 px-4 flex justify-between items-center">
        <div class="flex space-x-4">
            <a class="hover:text-white" href="#">Indonesia</a>
            <a class="hover:text-white" href="#">Support</a>
            <?php if ($isLoggedIn): ?>
                <a class="hover:text-white" href="logout.php">Logout</a>
            <?php else: ?>
                <a class="hover:text-white" href="login.php">Sign In</a> <a class="hover:text-white" href="register.php">Register</a>
            <?php endif; ?>
        </div>
        <div class="flex space-x-4">
            <a class="hover:text-white" href="#"><i class="fab fa-facebook-f"></i></a>
            <a class="hover:text-white" href="#"><i class="fab fa-twitter"></i></a>
            <a class="hover:text-white" href="#"><i class="fab fa-youtube"></i></a>
            <a class="hover:text-white" href="#"><i class="fab fa-instagram"></i></a>
        </div>
    </div>

    <header class="bg-gray-900 sticky top-0 z-50 border-b border-gray-700">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-4 py-3">
            <a class="flex items-center space-x-2" href="index.php">
                <img alt="Logo PS Rental Indonesia with a PlayStation controller icon and text" class="h-10 w-auto" height="40" src="https://storage.googleapis.com/a1aa/image/346efd31-3ca4-4b96-8bd3-0f0864a4d339.jpg" width="120"/>
            </a>
            <nav class="hidden md:flex space-x-8 font-semibold text-gray-300">
                <a class="hover:text-white transition" href="#rental-packages">Paket Sewa</a>
                <a class="hover:text-white transition" href="#how-it-works">Cara Sewa</a>
                <a class="hover:text-white transition" href="#game-slideshow">Game Populer</a>
                <a class="hover:text-white transition" href="#testimonials">Testimoni</a>
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
                <a class="inline-block bg-blue-700 hover:bg-blue-800 text-white font-semibold px-6 py-3 rounded-md transition" href="#rental-packages">Lihat Paket Sewa</a>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 md:px-12 py-12" id="rental-packages">
        <h2 class="text-3xl font-bold mb-8 text-white text-center">Paket Sewa PlayStations</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            <article class="bg-gray-800 rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition flex flex-col">
                <img alt="PlayStation 5 console with DualSense controller on white background" class="w-full h-56 object-cover" height="225" src="https://storage.googleapis.com/a1aa/image/8477b33f-e7bd-4eba-5014-3c5c7ac299bf.jpg" width="400"/>
                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="text-xl font-semibold mb-2">PS5 Standard Edition</h3>
                    <p class="text-gray-400 text-sm mb-4 flex-grow">Sewa konsol PlayStation 5 dengan performa terbaik dan grafis memukau.</p>
                    <p class="text-blue-400 font-bold text-lg mb-2" data-daily-rate="150000">Mulai dari Rp150.000 / hari</p>
                    <p class="text-blue-400 font-bold text-md mb-4" data-hourly-rate="25000">Atau Rp25.000 / jam</p>
                    <div class="text-sm font-semibold mb-3">
                        <span class="text-green-400"><i class="fas fa-check-circle"></i> Tersedia: 5 unit</span>
                    </div>
                    <a class="mt-auto inline-block bg-blue-700 hover:bg-blue-800 text-white font-semibold px-6 py-3 rounded-md transition text-center" href="#contact">Sewa Sekarang</a>
                </div>
            </article>
            <article class="bg-gray-800 rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition flex flex-col">
                <img alt="PlayStation 4 Pro console with DualShock controller on white background" class="w-full h-56 object-cover" height="225" src="https://storage.googleapis.com/a1aa/image/7b6d7592-eca3-4ffb-fc1b-bf2d378ed009.jpg" width="400"/>
                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="text-xl font-semibold mb-2">PS4 Pro Edition</h3>
                    <p class="text-gray-400 text-sm mb-4 flex-grow">Konsol PlayStation 4 Pro dengan performa tinggi dan banyak game populer.</p>
                    <p class="text-blue-400 font-bold text-lg mb-2" data-daily-rate="100000">Mulai dari Rp100.000 / hari</p>
                    <p class="text-blue-400 font-bold text-md mb-4" data-hourly-rate="15000">Atau Rp15.000 / jam</p>
                    <div class="text-sm font-semibold mb-3">
                        <span class="text-green-400"><i class="fas fa-check-circle"></i> Tersedia: 3 unit</span>
                    </div>
                    <a class="mt-auto inline-block bg-blue-700 hover:bg-blue-800 text-white font-semibold px-6 py-3 rounded-md transition text-center" href="#contact">Sewa Sekarang</a>
                </div>
            </article>
            <article class="bg-gray-800 rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition flex flex-col">
                <img alt="PlayStation 3 console with DualShock controller on white background" class="w-full h-56 object-cover" height="225" src="ps 3.jpg" width="400"/>
                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="text-xl font-semibold mb-2">PS3 Classic Edition</h3>
                    <p class="text-gray-400 text-sm mb-4 flex-grow">Konsol PlayStation 3 dengan koleksi game klasik dan nostalgia.</p>
                    <p class="text-blue-400 font-bold text-lg mb-2" data-daily-rate="80000">Mulai dari Rp80.000 / hari</p>
                    <p class="text-blue-400 font-bold text-md mb-4" data-hourly-rate="10000">Atau Rp10.000 / jam</p>
                    <div class="text-sm font-semibold mb-3">
                        <span class="text-red-400"><i class="fas fa-times-circle"></i> Stok Habis</span>
                    </div>
                    <a class="mt-auto inline-block bg-gray-600 cursor-not-allowed text-white font-semibold px-6 py-3 rounded-md transition text-center">Stok Habis</a>
                </div>
            </article>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 md:px-12 py-12" id="game-slideshow">
        <h2 class="text-3xl font-bold mb-4 text-white text-center">Game Populer untuk Disewa</h2>
        <div class="relative max-w-4xl mx-auto">
            <div class="overflow-hidden rounded-lg shadow-lg">
                <div class="flex transition-transform duration-500 ease-in-out" id="game-slides-container" style="transform: translateX(0%);">
                    <div class="min-w-full flex-shrink-0 game-item">
                        <img alt="Cover art of Horizon Forbidden West game showing a female warrior in a lush forest with robotic creatures" class="w-full h-64 object-cover" height="256" src="hor.avif" width="1024"/>
                        <div class="p-4 bg-gray-800 text-white text-center">
                            <h3 class="text-xl font-semibold game-title">Horizon Forbidden West</h3>
                        </div>
                    </div>
                    <div class="min-w-full flex-shrink-0 game-item">
                        <img alt="Cover art of Elden Ring game showing a warrior standing on a cliff with a vast fantasy landscape" class="w-full h-64 object-cover" height="256" src="elden ring.avif" width="1024"/>
                        <div class="p-4 bg-gray-800 text-white text-center">
                            <h3 class="text-xl font-semibold game-title">Elden Ring</h3>
                        </div>
                    </div>
                    <div class="min-w-full flex-shrink-0 game-item">
                        <img alt="Cover art of Returnal game showing a female astronaut in a hostile alien environment" class="w-full h-64 object-cover" height="256" src="GTA.jpeg" width="1024"/>
                        <div class="p-4 bg-gray-800 text-white text-center">
                            <h3 class="text-xl font-semibold game-title">Gta 5</h3>
                        </div>
                    </div>
                    <div class="min-w-full flex-shrink-0 game-item">
                        <img alt="Cover art of Gran Turismo 7 game showing a red sports car racing on a coastal highway" class="w-full h-64 object-cover" height="256" src="https://storage.googleapis.com/a1aa/image/31c44947-dc39-4305-c23c-c8e2fc684224.jpg" width="1024"/>
                        <div class="p-4 bg-gray-800 text-white text-center">
                            <h3 class="text-xl font-semibold game-title">Gran Turismo 7</h3>
                        </div>
                    </div>
                    <div class="min-w-full flex-shrink-0 game-item">
                        <img alt="Cover art of God of War Ragnarok game showing Kratos and Atreus in a snowy landscape" class="w-full h-64 object-cover" height="256" src="gow2.jpg" width="1024"/>
                        <div class="p-4 bg-gray-800 text-white text-center">
                            <h3 class="text-xl font-semibold game-title">God of War Ragnarok</h3>
                        </div>
                    </div>
                </div>
            </div>
            <button aria-label="Previous slide" class="absolute top-1/2 left-2 -translate-y-1/2 bg-blue-700 hover:bg-blue-800 text-white rounded-full p-2 shadow-lg focus:outline-none" id="prev-slide">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button aria-label="Next slide" class="absolute top-1/2 right-2 -translate-y-1/2 bg-blue-700 hover:bg-blue-800 text-white rounded-full p-2 shadow-lg focus:outline-none" id="next-slide">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </section>

    <section class="bg-gray-800 py-16 px-6 md:px-12" id="how-it-works">
        <div class="max-w-7xl mx-auto text-center">
            <h2 class="text-3xl font-bold mb-12 text-white">Cara Sewa PlayStation</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="flex flex-col items-center text-center">
                    <div class="bg-blue-700 rounded-full w-16 h-16 flex items-center justify-center mb-6 text-white text-2xl font-bold">1</div>
                    <img alt="Icon of a calendar and clock representing booking schedule" class="w-20 h-20 mb-4" height="80" src="https://storage.googleapis.com/a1aa/image/a238e365-745e-46a3-651a-bb8f701567e8.jpg" width="80"/>
                    <h3 class="text-xl font-semibold mb-2 text-white">Pilih Paket Sewa</h3>
                    <p class="text-gray-400 max-w-xs">Tentukan paket PlayStation yang ingin Anda sewa sesuai kebutuhan.</p>
                </div>
                <div class="flex flex-col items-center text-center">
                    <div class="bg-blue-700 rounded-full w-16 h-16 flex items-center justify-center mb-6 text-white text-2xl font-bold">2</div>
                    <img alt="Icon of a form and pen representing filling rental form" class="w-20 h-20 mb-4" height="80" src="https://storage.googleapis.com/a1aa/image/96c15051-6e55-4c0a-3d52-20e5b3e386e2.jpg" width="80"/>
                    <h3 class="text-xl font-semibold mb-2 text-white">Isi Formulir</h3>
                    <p class="text-gray-400 max-w-xs">Lengkapi data diri dan jadwal sewa melalui formulir pemesanan.</p>
                </div>
                <div class="flex flex-col items-center text-center">
                    <div class="bg-blue-700 rounded-full w-16 h-16 flex items-center justify-center mb-6 text-white text-2xl font-bold">3</div>
                    <img alt="Icon of delivery truck representing delivery and pickup service" class="w-20 h-20 mb-4" height="80" src="https://storage.googleapis.com/a1aa/image/39a9dd3c-824e-4fe8-388b-34db70650c70.jpg" width="80"/>
                    <h3 class="text-xl font-semibold mb-2 text-white">Terima &amp; Mainkan</h3>
                    <p class="text-gray-400 max-w-xs">Konsol akan diantar ke alamat Anda, siap untuk dimainkan.</p>
                </div>
            </div>
        </div>
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

    <section class="bg-gradient-to-r from-blue-900 to-blue-700 py-16 px-6 md:px-12" id="contact">
        <div class="max-w-3xl mx-auto text-white">
            <h2 class="text-4xl font-bold mb-6 text-center">Hubungi Kami</h2>

            <?php if (isset($_SESSION['form_message'])): ?>
                <div class="mb-4 p-3 rounded <?php echo ($_SESSION['form_message_type'] == 'success') ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                    <?php echo htmlspecialchars($_SESSION['form_message']); ?>
                </div>
                <?php
                // Hapus pesan dari session setelah ditampilkan
                unset($_SESSION['form_message']);
                unset($_SESSION['form_message_type']);
                ?>
            <?php endif; ?>

            <form class="space-y-6" id="rental-form" method="POST" action="process_order.php" novalidate>
                <div>
                    <label class="block mb-2 font-semibold" for="name">Nama Lengkap</label>
                    <input class="w-full rounded-md px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500" id="name" name="name" placeholder="Masukkan nama lengkap Anda" required type="text"/>
                </div>
                <div>
                    <label class="block mb-2 font-semibold" for="email">Email</label>
                    <input class="w-full rounded-md px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500" id="email" name="email" placeholder="Masukkan email Anda" required type="email"/>
                </div>
                <div>
                    <label class="block mb-2 font-semibold" for="phone">Nomor Telepon</label>
                    <input class="w-full rounded-md px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500" id="phone" name="phone" placeholder="Masukkan nomor telepon Anda" required type="tel"/>
                </div>
                <div>
                    <label class="block mb-2 font-semibold" for="package">Pilih Paket Sewa</label>
                    <select class="w-full rounded-md px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500" id="package" name="package" required>
                        <option disabled selected value="">-- Pilih Paket --</option>
                        <option value="ps5_standard" data-daily-rate="150000" data-hourly-rate="25000">PS5 Standard Edition</option>
                        <option value="ps4_pro" data-daily-rate="100000" data-hourly-rate="15000">PS4 Pro Edition</option>
                        <option value="ps3_classic" data-daily-rate="80000" data-hourly-rate="10000">PS3 Classic Edition</option>
                    </select>
                </div>
                <div>
                    <label class="block mb-2 font-semibold" for="rental-date">Tanggal Mulai Sewa</label>
                    <input class="w-full rounded-md px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500" id="rental-date" name="rental_date" required type="date"/>
                </div>
                <div>
                    <label class="block mb-2 font-semibold" for="duration-type">Jenis Durasi</label>
                    <select class="w-full rounded-md px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500" id="duration-type" name="duration_type" required>
                        <option value="hari">Hari</option>
                        <option value="jam">Jam</option>
                    </select>
                </div>
                <div>
                    <label class="block mb-2 font-semibold" for="duration">Durasi Sewa (<span id="duration-unit">hari</span>)</label>
                    <input class="w-full rounded-md px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500" id="duration" min="1" name="duration" placeholder="Masukkan durasi sewa" required type="number"/>
                </div>
                <div class="text-xl font-bold text-white text-center">
                    Total Harga: <span id="total-price">Rp0</span>
                    <input type="hidden" id="hidden-total-price" name="total_price_hidden" value="0">
                </div>
                <button class="w-full bg-blue-700 hover:bg-blue-800 text-white font-semibold px-6 py-3 rounded-md transition" type="submit">Kirim Pesanan</button>
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

    <script>
        // === Mobile Menu Toggle ===
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // === Rental Form Price Calculation ===
        const rentalForm = document.getElementById('rental-form');
        const packageSelect = document.getElementById('package');
        const durationTypeSelect = document.getElementById('duration-type');
        const durationInput = document.getElementById('duration');
        const durationUnitSpan = document.getElementById('duration-unit');
        const totalPriceSpan = document.getElementById('total-price');
        const hiddenTotalPriceInput = document.getElementById('hidden-total-price'); // Hidden input untuk total harga


        // Fungsi untuk menghitung dan memperbarui total harga
        function calculateTotalPrice() {
            const selectedOption = packageSelect.options[packageSelect.selectedIndex];
            // Pastikan kita mendapatkan angka dari data-set
            const dailyRate = parseFloat(selectedOption.dataset.dailyRate || 0);
            const hourlyRate = parseFloat(selectedOption.dataset.hourlyRate || 0);
            const duration = parseFloat(durationInput.value || 0);
            const durationType = durationTypeSelect.value;

            let totalPrice = 0;

            if (duration > 0) {
                if (durationType === 'hari') { // Sesuaikan dengan value di option HTML
                    totalPrice = dailyRate * duration;
                } else if (durationType === 'jam') { // Sesuaikan dengan value di option HTML
                    totalPrice = hourlyRate * duration;
                }
            }
            totalPriceSpan.textContent = `Rp${totalPrice.toLocaleString('id-ID')}`;
            hiddenTotalPriceInput.value = totalPrice; // Update nilai hidden input
        }

        // Event listeners untuk perhitungan harga
        packageSelect.addEventListener('change', calculateTotalPrice);
        durationTypeSelect.addEventListener('change', () => {
            durationUnitSpan.textContent = durationTypeSelect.value === 'hari' ? 'hari' : 'jam'; // Sesuaikan unit
            durationInput.placeholder = durationTypeSelect.value === 'hari' ? 'Masukkan durasi sewa dalam hari' : 'Masukkan durasi sewa dalam jam';
            calculateTotalPrice(); // Hitung ulang saat jenis durasi berubah
        });
        durationInput.addEventListener('input', calculateTotalPrice); // Hitung ulang saat durasi input berubah

        // Panggil perhitungan awal saat halaman dimuat
        calculateTotalPrice();


        // === Rental Form Submission (Sekarang hanya validasi HTML5) ===
        rentalForm.addEventListener('submit', (e) => {
            calculateTotalPrice();
        });


        // === Game Slideshow functionality ===
        const gameSlidesContainer = document.getElementById('game-slides-container');
        const prevSlideBtn = document.getElementById('prev-slide');
        const nextSlideBtn = document.getElementById('next-slide');
        // Pastikan gameSlidesContainer.children hanya menghitung elemen yang ingin di-slide
        const totalSlides = gameSlidesContainer.children.length;
        let currentIndex = 0;

        function updateSlidePosition() {
            gameSlidesContainer.style.transform = `translateX(-${currentIndex * 100}%)`;
        }

        prevSlideBtn.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
            updateSlidePosition();
        });

        nextSlideBtn.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % totalSlides;
            updateSlidePosition();
        });

        // Auto slide setiap 5 detik
        let autoSlideInterval = setInterval(() => {
            currentIndex = (currentIndex + 1) % totalSlides;
            updateSlidePosition();
        }, 5000);

        // Pause slideshow saat kursor di atas container
        gameSlidesContainer.parentElement.addEventListener('mouseenter', () => {
            clearInterval(autoSlideInterval);
        });
        gameSlidesContainer.parentElement.addEventListener('mouseleave', () => {
            autoSlideInterval = setInterval(() => {
                currentIndex = (currentIndex + 1) % totalSlides;
                updateSlidePosition();
            }, 5000);
        });

        // Re-initialize slide position saat ukuran jendela berubah (responsif)
        window.addEventListener('resize', updateSlidePosition);
        // Panggil sekali saat load untuk posisi awal yang benar
        updateSlidePosition();
    </script>
</body>
</html>