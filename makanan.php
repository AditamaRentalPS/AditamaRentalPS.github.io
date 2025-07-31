<?php
session_start(); // Always start the session at the beginning of the PHP file

// Data menu minuman/makanan
$menuItems = [
    ['name' => 'Mie Instan', 'price' => 10000, 'image' => 'Mie.png'],
    ['name' => 'Teh Hangat', 'price' => 5000, 'image' => 'teh.jpg'],
    ['name' => 'Kopi Hitam', 'price' => 7000, 'image' => 'kopi.jpg'],
    ['name' => 'Susu Kotak', 'price' => 8000, 'image' => 'susu.jpg'],
    ['name' => 'Air Mineral Botol', 'price' => 3000, 'image' => 'air.avif'],
];

// Data paket sewa (disimpan di sini karena mungkin akan diintegrasikan nanti,
// tapi tidak ditampilkan di halaman ini)
$psPackages = [
    'ps5_standard' => ['name' => 'PS5 Standard Edition', 'hourly_rate' => 25000],
    'ps4_pro' => ['name' => 'PS4 Pro Edition', 'hourly_rate' => 15000],
    'ps3_classic' => ['name' => 'PS3 Classic Edition', 'hourly_rate' => 10000],
];

// Cek apakah user sedang login (untuk tampilan Sign In/Logout di navbar)
$isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <title>PS Rental Indonesia - Pesan Makanan & Minuman</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&amp;display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }
        .menu-card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
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
                <a class="hover:text-white transition" href="index.php#rental-packages">Paket Sewa</a>
                <a class="hover:text-white transition" href="index.php#how-it-works">Cara Sewa</a>
                <a class="hover:text-white transition" href="index.php#game-slideshow">Game Populer</a>
                <a class="hover:text-white transition" href="index.php#testimonials">Testimoni</a>
                <a class="hover:text-white transition" href="makanan.php">Makanan & Minuman</a>
                <a class="hover:text-white transition" href="index.php#contact">Kontak</a>
            </nav>
            <div class="md:hidden">
                <button aria-label="Open menu" class="focus:outline-none" id="mobile-menu-button">
                    <i class="fas fa-bars text-2xl text-gray-300"></i>
                </button>
            </div>
        </div>
        <nav aria-label="Mobile menu" class="hidden bg-gray-800 border-t border-gray-700 md:hidden" id="mobile-menu">
            <a class="block px-4 py-3 border-b border-gray-700 hover:bg-gray-700 transition" href="index.php#rental-packages">Paket Sewa</a>
            <a class="block px-4 py-3 border-b border-gray-700 hover:bg-gray-700 transition" href="index.php#how-it-works">Cara Sewa</a>
            <a class="block px-4 py-3 border-b border-gray-700 hover:bg-gray-700 transition" href="index.php#game-slideshow">Game Populer</a>
            <a class="block px-4 py-3 border-b border-gray-700 hover:bg-gray-700 transition" href="index.php#testimonials">Testimoni</a>
            <a class="block px-4 py-3 border-b border-gray-700 hover:bg-gray-700 transition" href="makanan.php">Makanan & Minuman</a>
            <a class="block px-4 py-3 hover:bg-gray-700 transition" href="index.php#contact">Kontak</a>
        </nav>
    </header>

    <main class="max-w-6xl mx-auto px-6 md:px-12 py-12">
        <h1 class="text-4xl font-extrabold mb-4 text-white text-center">Pesan Makanan & Minuman</h1>
        <p class="text-xl text-gray-300 text-center mb-10 leading-relaxed">
            Lengkapi sesi gaming Anda agar makin seru dan nyaman dengan pilihan makanan dan minuman favorit kami!
            Dari camilan pengganjal lapar hingga minuman segar, semua tersedia untuk menemani Anda.
        </p>

        <div class="bg-gray-800 rounded-xl shadow-2xl p-8 transform transition-all duration-300 hover:scale-[1.01]">
            <form id="order-menu-form" class="space-y-8">
                <h2 class="text-3xl font-bold mb-8 text-white text-center border-b-2 border-blue-500 pb-4">Daftar Menu Pilihan</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($menuItems as $index => $item): ?>
                        <div class="menu-card bg-gray-700 rounded-lg overflow-hidden shadow-xl flex flex-col justify-between">
                            <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="w-full h-48 object-cover border-b border-gray-600">
                            <div class="p-5 flex flex-col flex-grow">
                                <label for="item-<?php echo $index; ?>" class="text-gray-100 font-semibold text-xl mb-2 cursor-pointer">
                                    <?php echo htmlspecialchars($item['name']); ?>
                                </label>
                                <p class="text-blue-400 font-extrabold text-2xl mb-4">
                                    Rp<?php echo number_format($item['price'], 0, ',', '.'); ?>
                                </p>
                                <div class="flex items-center justify-center mt-auto">
                                    <button type="button" class="quantity-btn bg-gray-600 hover:bg-gray-500 text-white p-2 rounded-l-md text-lg font-bold" data-action="decrease">-</button>
                                    <input type="number" id="item-<?php echo $index; ?>" data-price="<?php echo $item['price']; ?>" min="0" value="0"
                                           class="w-20 bg-gray-900 text-white text-center text-xl py-2 px-1 focus:outline-none focus:ring-2 focus:ring-blue-500 quantity-input">
                                    <button type="button" class="quantity-btn bg-gray-600 hover:bg-gray-500 text-white p-2 rounded-r-md text-lg font-bold" data-action="increase">+</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="mt-12 pt-8 border-t-2 border-gray-600 text-center">
                    <p class="text-3xl font-bold text-white mb-6">
                        <span>Total Pesanan Anda:</span>
                        <span id="total-menu-price" class="text-blue-400 ml-4">Rp0</span>
                    </p>
                    <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-extrabold px-12 py-5 rounded-full transition duration-300 ease-in-out text-2xl shadow-lg hover:shadow-xl transform hover:scale-105">
                        Pesan Sekarang
                    </button>
                </div>
            </form>
        </div>
    </main>

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
                    <li><a class="hover:text-white" href="index.php#rental-packages">Paket Sewa</a></li>
                    <li><a class="hover:text-white" href="index.php#how-it-works">Cara Sewa</a></li>
                    <li><a class="hover:text-white" href="index.php#contact">Hubungi Kami</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-4">Bantuan</h4>
                <ul class="space-y-2">
                    <li><a class="hover:text-white" href="#">FAQ</a></li>
                    <li><a class="hover:text-white" href="#">Kebijakan Pengembalian</a></li>
                    <li><a class="hover:text-white" href="#">Syarat &amp; Ketentuan</a></li>
                    <li><a class="hover:text-white text-blue-400" href="admin.php">Admin Panel</a></li>
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

        // === Menu Order Functionality ===
        const quantityInputs = document.querySelectorAll('.quantity-input');
        const totalMenuPriceSpan = document.getElementById('total-menu-price');
        const orderMenuForm = document.getElementById('order-menu-form');

        // Calculate total price for menu items
        function calculateTotalMenuPrice() {
            let total = 0;
            quantityInputs.forEach(input => {
                const price = parseFloat(input.dataset.price);
                const quantity = parseInt(input.value);
                if (!isNaN(price) && !isNaN(quantity) && quantity > 0) {
                    total += price * quantity;
                }
            });
            totalMenuPriceSpan.textContent = `Rp${total.toLocaleString('id-ID')}`;
        }

        // Add event listeners to quantity inputs
        quantityInputs.forEach(input => {
            input.addEventListener('input', calculateTotalMenuPrice);
        });

        // Add event listeners for quantity buttons
        document.querySelectorAll('.quantity-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                const input = e.target.closest('div').querySelector('.quantity-input');
                let quantity = parseInt(input.value);
                if (e.target.dataset.action === 'increase') {
                    quantity++;
                } else if (e.target.dataset.action === 'decrease' && quantity > 0) {
                    quantity--;
                }
                input.value = quantity;
                calculateTotalMenuPrice();
            });
        });

        // Initial calculation for menu items on load
        calculateTotalMenuPrice();

        // Handle menu order form submission (simple alert for now)
        orderMenuForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const selectedItems = [];
            let totalOrder = 0;

            quantityInputs.forEach(input => {
                const quantity = parseInt(input.value);
                if (quantity > 0) {
                    const itemName = input.previousElementSibling.previousElementSibling.textContent.trim(); // Adjusted to get item name from label
                    const itemPrice = parseFloat(input.dataset.price);
                    selectedItems.push(`${itemName} (${quantity}x)`);
                    totalOrder += itemPrice * quantity;
                }
            });

            if (selectedItems.length > 0) {
                alert(`Pesanan Anda:\n${selectedItems.join('\n')}\n\nTotal: Rp${totalOrder.toLocaleString('id-ID')}\n\nPesanan telah dikirim!`);
                orderMenuForm.reset();
                calculateTotalMenuPrice(); // Reset total harga setelah form direset
            } else {
                alert('Pilih setidaknya satu item untuk dipesan.');
            }
        });
    </script>
</body>
</html>