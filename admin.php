        <?php
        // admin.php
        session_start();

        // Periksa apakah admin sudah login
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            // Jika tidak login, arahkan kembali ke halaman login universal
            header("Location: login.php"); // Mengarahkan ke login.php
            exit;
        }

        include 'db.php';

// Ambil semua game
$result = mysqli_query($conn, "SELECT * FROM games");
$games = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Tampung isi konten halaman
ob_start();
?>
<a href="table/game/tambah.php" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">+ Tambah Game</a>
<table class="table-auto w-full bg-white shadow-md rounded">
    <thead>
        <tr class="bg-gray-200">
            <th class="px-4 py-2">#</th>
            <th class="px-4 py-2">Gambar</th>
            <th class="px-4 py-2">Nama Game</th>
            <th class="px-4 py-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($games as $i => $game): ?>
        <tr class="border-t">
            <td class="px-4 py-2"><?= $i + 1 ?></td>
            <td class="px-4 py-2">
                <img src="gambar/<?= $game['gambar'] ?>" width="80">
            </td>
            <td class="px-4 py-2"><?= htmlspecialchars($game['nama_game']) ?></td>
            <td class="px-4 py-2">
                <a href="table/game/edit.php?id=<?= $game['id'] ?>" class="text-yellow-500">Edit</a> |
                <a href="table/game/hapus.php?id=<?= $game['id'] ?>" class="text-red-500" onclick="return confirm('Yakin?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
$content = ob_get_clean();
$title = "Dashboard Admin";
include 'layout/layout.php';
?>

        // Opsional: Ambil data admin yang sedang login untuk ditampilkan di halaman
        $admin_name = $_SESSION['admin_name'] ?? 'Admin'; // Mengambil nama admin dari sesi
        ?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="utf-8" />
            <meta content="width=device-width, initial-scale=1" name="viewport" />
            <title>PS Rental Indonesia - Admin Dashboard</title>
            <script src="https://cdn.tailwindcss.com"></script>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
            <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&amp;display=swap" rel="stylesheet" />
            <style>
                body {
                    font-family: 'Montserrat', sans-serif;
                }

                /* Tambahkan style untuk konten yang tersembunyi */
                .content-section {
                    display: none;
                }

                .content-section.active {
                    display: block;
                }

                /* Style untuk gambar thumbnail */
                .thumbnail-img {
                    width: 50px;
                    /* Ukuran thumbnail */
                    height: 50px;
                    object-fit: cover;
                    border-radius: 4px;
                    margin-right: 8px;
                }
            </style>
        </head>

        <body class="bg-gray-900 text-white flex">
            <aside class="w-64 bg-gray-800 p-6 flex flex-col min-h-screen border-r border-gray-700">
                <div class="flex items-center space-x-2 mb-8">
                    <img alt="Logo PS Rental Indonesia" class="h-8 w-auto" src="https://storage.googleapis.com/a1aa/image/346efd31-3ca4-4b96-8bd3-0f0864a4d339.jpg" />
                    <span class="text-xl font-bold">Admin Panel</span>
                </div>
                <nav class="flex-grow">
                    <ul class="space-y-4">
                        <li>
                            <a href="#" id="nav-dashboard" class="flex items-center space-x-3 text-gray-300 hover:text-white hover:bg-gray-700 p-3 rounded-md transition active-nav">
                                <i class="fas fa-tachometer-alt"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" id="nav-manage-games" class="flex items-center space-x-3 text-gray-300 hover:text-white hover:bg-gray-700 p-3 rounded-md transition">
                                <i class="fas fa-gamepad"></i>
                                <span>Manage Games</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" id="nav-manage-consoles" class="flex items-center space-x-3 text-gray-300 hover:text-white hover:bg-gray-700 p-3 rounded-md transition">
                                <i class="fas fa-desktop"></i> <span>Manage Consoles</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" id="nav-manage-orders" class="flex items-center space-x-3 text-gray-300 hover:text-white hover:bg-gray-700 p-3 rounded-md transition">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Manage Orders</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" id="nav-reports" class="flex items-center space-x-3 text-gray-300 hover:text-white hover:bg-gray-700 p-3 rounded-md transition">
                                <i class="fas fa-chart-line"></i>
                                <span>Reports</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="mt-8">
                    <a href="logout.php" class="flex items-center space-x-3 text-red-400 hover:text-red-500 hover:bg-gray-700 p-3 rounded-md transition">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </aside>

            <main class="flex-1 p-8">
                <header class="flex justify-between items-center mb-8">
                    <h1 class="text-3xl font-bold" id="main-content-title">Manage Games</h1>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-400">Welcome, <?php echo htmlspecialchars($admin_name); ?>!</span> <button class="text-gray-300 hover:text-white focus:outline-none">
                            <i class="fas fa-bell text-xl"></i>
                        </button>
                    </div>
                </header>

                <section id="dashboard-content" class="content-section active">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-300">Total Orders</h3>
                                <i class="fas fa-shopping-cart text-blue-500 text-2xl"></i>
                            </div>
                            <p class="text-4xl font-bold text-white">1,250</p>
                            <p class="text-green-400 text-sm mt-2"><i class="fas fa-arrow-up"></i> 12% from last month</p>
                        </div>
                        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-300">Active Users</h3>
                                <i class="fas fa-users text-purple-500 text-2xl"></i>
                            </div>
                            <p class="text-4xl font-bold text-white">560</p>
                            <p class="text-green-400 text-sm mt-2"><i class="fas fa-arrow-up"></i> 5% from last month</p>
                        </div>
                        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-300">Available Consoles</h3>
                                <i class="fas fa-gamepad text-green-500 text-2xl"></i>
                            </div>
                            <p class="text-4xl font-bold text-white">45</p>
                            <p class="text-red-400 text-sm mt-2"><i class="fas fa-arrow-down"></i> 2 Consoles rented today</p>
                        </div>
                    </div>

                    <! <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                        <h3 class="text-xl font-semibold mb-6">Recent Orders</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-700">
                                <thead class="bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Order ID</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Customer</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Console</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Rental Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Duration</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-800">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">#ORD001</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">Budi Santoso</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">PS5 Standard</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">2025-07-27</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">3 days</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="#" class="text-blue-500 hover:text-blue-700 mr-3">View</a>
                                            <a href="#" class="text-green-500 hover:text-green-700">Approve</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">#ORD002</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">Siti Aminah</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">PS4 Pro</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">2025-07-26</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">2 days</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-s  emibold rounded-full bg-green-100 text-green-800">Completed</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="#" class="text-blue-500 hover:text-blue-700 mr-3">View</a>
                                            <a href="#" class="text-gray-500 cursor-not-allowed">Approve</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <section id="manage-games-content" class="content-section">
                    <div class="bg-gray-800 p-6 rounded-lg shadow-lg mb-8">
                        <h3 class="text-xl font-semibold mb-6">Tambah / Edit Judul Game</h3>
                        <form id="game-form" class="space-y-4">
                            <input type="hidden" id="game-id" name="id">
                            <div>
                                <label class="block text-gray-300 text-sm font-bold mb-2" for="game_title">Judul Game:</label>
                                <input type="text" id="game_title" name="game_title" class="shadow appearance-none border rounded w-full py-2 px-3 bg-gray-700 text-white leading-tight focus:outline-none focus:shadow-outline" placeholder="Contoh: God of War Ragnarök" required>
                            </div>
                            <div>
                                <label class="block text-gray-300 text-sm font-bold mb-2" for="game_image_url">URL Gambar Game:</label>
                                <input type="file" id="game_image_url" name="game_image_url" class="shadow appearance-none border rounded w-full py-2 px-3 bg-gray-700 text-white leading-tight focus:outline-none focus:shadow-outline" placeholder="Contoh: https://example.com/game_image.jpg">
                            </div>
                            <div class="flex justify-end space-x-4">
                                <button type="button" id="cancel-edit-game-btn" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline hidden">Batal Edit</button>
                                <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Simpan Judul Game</button>
                            </div>
                        </form>
                    </div>
                </section>

                <section id="manage-consoles-content" class="content-section">
                    <div class="bg-gray-800 p-6 rounded-lg shadow-lg mb-8">
                        <h3 class="text-xl font-semibold mb-6">Tambah / Edit Model PlayStation</h3>
                        <form id="console-form" class="space-y-4">
                            <input type="hidden" id="console-id" name="id">
                            <div>
                                <label class="block text-gray-300 text-sm font-bold mb-2" for="model_name">Nama Model PS:</label>
                                <input type="text" id="model_name" name="model_name" class="shadow appearance-none border rounded w-full py-2 px-3 bg-gray-700 text-white leading-tight focus:outline-none focus:shadow-outline" placeholder="Contoh: PS5 Standard Edition" required>
                            </div>
                            <div>
                                <label class="block text-gray-300 text-sm font-bold mb-2" for="description">Deskripsi:</label>
                                <textarea id="description" name="description" class="shadow appearance-none border rounded w-full py-2 px-3 bg-gray-700 text-white leading-tight focus:outline-none focus:shadow-outline" rows="3" placeholder="Deskripsi singkat model PS"></textarea>
                            </div>
                            <div>
                                <label class="block text-gray-300 text-sm font-bold mb-2" for="daily_rate">Harga Sewa Harian (Rp):</label>
                                <input type="number" id="daily_rate" name="daily_rate" class="shadow appearance-none border rounded w-full py-2 px-3 bg-gray-700 text-white leading-tight focus:outline-none focus:shadow-outline" min="0" required>
                            </div>
                            <div>
                                <label class="block text-gray-300 text-sm font-bold mb-2" for="hourly_rate">Harga Sewa Per Jam (Rp):</label>
                                <input type="number" id="hourly_rate" name="hourly_rate" class="shadow appearance-none border rounded w-full py-2 px-3 bg-gray-700 text-white leading-tight focus:outline-none focus:shadow-outline" min="0">
                            </div>
                            <div>
                                <label class="block text-gray-300 text-sm font-bold mb-2" for="image_url">URL Gambar Model:</label>
                                <input type="url" id="image_url" name="image_url" class="shadow appearance-none border rounded w-full py-2 px-3 bg-gray-700 text-white leading-tight focus:outline-none focus:shadow-outline" placeholder="Contoh: https://example.com/ps5.jpg">
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="is_available_for_rent" name="is_available_for_rent" class="mr-2 leading-tight">
                                <label class="text-gray-300 text-sm font-bold" for="is_available_for_rent">Tersedia untuk disewa</label>
                            </div>
                            <div class="flex justify-end space-x-4">
                                <button type="button" id="cancel-edit-console-btn" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline hidden">Batal Edit</button>
                                <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Simpan Model PS</button>
                            </div>
                        </form>
                    </div>

                    <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                        <h3 class="text-xl font-semibold mb-6">Daftar Model PlayStation</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-700">
                                <thead class="bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">ID</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Nama Model</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Harga Harian</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Harga Per Jam</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Tersedia</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="console-list" class="divide-y divide-gray-800">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </main>

            <script>
                // === Sidebar Navigation Logic ===
                const navLinks = document.querySelectorAll('aside nav ul li a');
                const contentSections = document.querySelectorAll('.content-section');
                const mainContentTitle = document.getElementById('main-content-title');

                navLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();

                        // Remove active class from all nav links
                        navLinks.forEach(item => {
                            item.classList.remove('active-nav', 'text-white', 'bg-gray-700');
                            item.classList.add('text-gray-300'); // Ensure default color is reapplied
                        });
                        // Add active class to clicked link
                        this.classList.add('active-nav', 'text-white', 'bg-gray-700');
                        this.classList.remove('text-gray-300');


                        // Hide all content sections
                        contentSections.forEach(section => section.classList.remove('active'));

                        // Show the corresponding content section
                        const targetId = this.id.replace('nav-', '') + '-content';
                        const targetSection = document.getElementById(targetId);
                        if (targetSection) {
                            targetSection.classList.add('active');
                            // Update main content title
                            mainContentTitle.textContent = this.querySelector('span').textContent;
                        }
                    });
                });

                // Initialize active nav and content on load
                document.addEventListener('DOMContentLoaded', () => {
                    document.getElementById('nav-dashboard').click(); // Tetap default ke dashboard
                    renderGameList(); // Render daftar game
                    renderConsoleList(); // Render daftar konsol
                });


                // === CRUD for Manage Games (Client-side simulation) ===
                const gameForm = document.getElementById('game-form');
                const gameIdInput = document.getElementById('game-id');
                const gameTitleInput = document.getElementById('game_title');
                const gameImageUrlInput = document.getElementById('game_image_url');
                const gameListBody = document.getElementById('game-list');
                const cancelEditGameBtn = document.getElementById('cancel-edit-game-btn');

                let games = [{
                        id: 1,
                        title: 'God of War Ragnarök',
                        image_url: 'https://cdn1.epicgames.com/offer/ef337955b20b4a459362624a42b32267/EGS_GodofWarRagnarok_SantaMonicaStudio_S2_1200x1600-4b2165c40026e63283fcc4ed50df887e'
                    },
                    {
                        id: 2,
                        title: 'Marvel\'s Spider-Man 2',
                        image_url: 'https://image.api.playstation.com/vulcan/ap/rnd/202306/0722/01ff6c9a091c784e72782b2d24249a5b67482f5b667e45e7.png'
                    },
                    {
                        id: 3,
                        title: 'Grand Theft Auto V',
                        image_url: 'https://upload.wikimedia.org/wikipedia/en/a/a5/Grand_Theft_Auto_V_Primary_Cover_Art.png'
                    }
                ];
                let nextGameId = 4;

                // Function to render game list
                function renderGameList() {
                    gameListBody.innerHTML = ''; // Clear existing list
                    games.forEach(game => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">${game.id}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                ${game.image_url ? `<img src="${game.image_url}" alt="${game.title}" class="thumbnail-img inline-block">` : 'Tidak Ada Gambar'}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">${game.title}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button data-id="${game.id}" class="edit-game-btn text-yellow-500 hover:text-yellow-700 mr-3">Edit</button>
                                <button data-id="${game.id}" class="delete-game-btn text-red-500 hover:text-red-700">Hapus</button>
                            </td>
                        `;
                        gameListBody.appendChild(row);
                    });

                    // Attach event listeners to new buttons
                    document.querySelectorAll('.edit-game-btn').forEach(button => {
                        button.addEventListener('click', editGame);
                    });
                    document.querySelectorAll('.delete-game-btn').forEach(button => {
                        button.addEventListener('click', deleteGame);
                    });
                }

                // Handle game form submission (Create/Update)
                gameForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const id = gameIdInput.value;
                    const title = gameTitleInput.value;
                    const image_url = gameImageUrlInput.value;

                    if (id) { // Update existing game
                        const index = games.findIndex(g => g.id == id);
                        if (index !== -1) {
                            games[index] = {
                                id: parseInt(id),
                                title,
                                image_url
                            };
                            alert('Judul game berhasil diperbarui!');
                        }
                    } else { // Add new game
                        const newGame = {
                            id: nextGameId++,
                            title,
                            image_url
                        };
                        games.push(newGame);
                        alert('Judul game berhasil ditambahkan!');
                    }

                    // Reset form and re-render list
                    gameForm.reset();
                    gameIdInput.value = ''; // Clear hidden ID
                    cancelEditGameBtn.classList.add('hidden'); // Hide cancel button
                    renderGameList(); // Re-render the list
                    console.log("Game data saved/updated:", games);
                });

                // Edit Game
                function editGame(event) {
                    const idToEdit = parseInt(event.target.dataset.id);
                    const gameToEdit = games.find(g => g.id === idToEdit);

                    if (gameToEdit) {
                        gameIdInput.value = gameToEdit.id;
                        gameTitleInput.value = gameToEdit.title;
                        gameImageUrlInput.value = gameToEdit.image_url;
                        cancelEditGameBtn.classList.remove('hidden'); // Show cancel button
                    }
                }

                // Cancel Game Edit
                cancelEditGameBtn.addEventListener('click', () => {
                    gameForm.reset();
                    gameIdInput.value = '';
                    cancelEditGameBtn.classList.add('hidden');
                });

                // Delete Game
                function deleteGame(event) {
                    const idToDelete = parseInt(event.target.dataset.id);
                    if (confirm(`Apakah Anda yakin ingin menghapus judul game dengan ID ${idToDelete}?`)) {
                        games = games.filter(g => g.id !== idToDelete);
                        renderGameList();
                        alert('Judul game berhasil dihapus!');
                        console.log("Game deleted:", idToDelete);
                    }
                }

                // === CRUD for Manage Consoles (Client-side simulation) ===
                const consoleForm = document.getElementById('console-form');
                const consoleIdInput = document.getElementById('console-id');
                const modelNameInput = document.getElementById('model_name');
                const descriptionInput = document.getElementById('description');
                const dailyRateInput = document.getElementById('daily_rate');
                const hourlyRateInput = document.getElementById('hourly_rate');
                const imageUrlInput = document.getElementById('image_url');
                const isAvailableInput = document.getElementById('is_available_for_rent');
                const consoleListBody = document.getElementById('console-list');
                const cancelEditConsoleBtn = document.getElementById('cancel-edit-console-btn');

                let consoles = [{
                        id: 1,
                        model_name: 'PS5 Standard Edition',
                        description: 'Sewa konsol PlayStation 5 dengan performa terbaik dan grafis memukau.',
                        daily_rate: 150000,
                        hourly_rate: 25000,
                        image_url: 'https://storage.googleapis.com/a1aa/image/8477b33f-e7bd-4eba-5014-3c5c7ac299bf.jpg',
                        is_available_for_rent: true
                    },
                    {
                        id: 2,
                        model_name: 'PS4 Pro Edition',
                        description: 'Konsol PlayStation 4 Pro dengan performa tinggi dan banyak game populer.',
                        daily_rate: 100000,
                        hourly_rate: 15000,
                        image_url: 'https://storage.googleapis.com/a1aa/image/7b6d7592-eca3-4ffb-fc1b-bf2d378ed009.jpg',
                        is_available_for_rent: true
                    },
                    {
                        id: 3,
                        model_name: 'PS3 Classic Edition',
                        description: 'Konsol PlayStation 3 dengan koleksi game klasik dan nostalgia.',
                        daily_rate: 80000,
                        hourly_rate: 10000,
                        image_url: 'ps 3.jpg',
                        is_available_for_rent: false
                    }
                ];
                let nextConsoleId = 4;

                // Function to render console list
                function renderConsoleList() {
                    consoleListBody.innerHTML = '';
                    consoles.forEach(consoleItem => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">${consoleItem.id}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">${consoleItem.model_name}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">Rp${consoleItem.daily_rate.toLocaleString('id-ID')}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">Rp${consoleItem.hourly_rate.toLocaleString('id-ID')}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${consoleItem.is_available_for_rent ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                                    ${consoleItem.is_available_for_rent ? 'Ya' : 'Tidak'}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button data-id="${consoleItem.id}" class="edit-console-btn text-yellow-500 hover:text-yellow-700 mr-3">Edit</button>
                                <button data-id="${consoleItem.id}" class="delete-console-btn text-red-500 hover:text-red-700">Hapus</button>
                            </td>
                        `;
                        consoleListBody.appendChild(row);
                    });

                    // Attach event listeners to new buttons
                    document.querySelectorAll('.edit-console-btn').forEach(button => {
                        button.addEventListener('click', editConsole);
                    });
                    document.querySelectorAll('.delete-console-btn').forEach(button => {
                        button.addEventListener('click', deleteConsole);
                    });
                }

                // Handle console form submission (Create/Update)
                consoleForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const id = consoleIdInput.value;
                    const model_name = modelNameInput.value;
                    const description = descriptionInput.value;
                    const daily_rate = parseFloat(dailyRateInput.value);
                    const hourly_rate = parseFloat(hourlyRateInput.value);
                    const image_url_val = imageUrlInput.value;
                    const is_available_for_rent = isAvailableInput.checked;

                    if (id) { // Update existing console
                        const index = consoles.findIndex(c => c.id == id);
                        if (index !== -1) {
                            consoles[index] = {
                                id: parseInt(id),
                                model_name,
                                description,
                                daily_rate,
                                hourly_rate,
                                image_url: image_url_val,
                                is_available_for_rent
                            };
                            alert('Model PlayStation berhasil diperbarui!');
                        }
                    } else { // Add new console
                        const newConsole = {
                            id: nextConsoleId++,
                            model_name,
                            description,
                            daily_rate,
                            hourly_rate,
                            image_url: image_url_val,
                            is_available_for_rent
                        };
                        consoles.push(newConsole);
                        alert('Model PlayStation berhasil ditambahkan!');
                    }

                    // Reset form and re-render list
                    consoleForm.reset();
                    consoleIdInput.value = '';
                    cancelEditConsoleBtn.classList.add('hidden');
                    renderConsoleList();
                    console.log("Console data saved/updated:", consoles);
                });

                // Edit Console
                function editConsole(event) {
                    const idToEdit = parseInt(event.target.dataset.id);
                    const consoleToEdit = consoles.find(c => c.id === idToEdit);

                    if (consoleToEdit) {
                        consoleIdInput.value = consoleToEdit.id;
                        modelNameInput.value = consoleToEdit.model_name;
                        descriptionInput.value = consoleToEdit.description;
                        dailyRateInput.value = consoleToEdit.daily_rate;
                        hourlyRateInput.value = consoleToEdit.hourly_rate;
                        imageUrlInput.value = consoleToEdit.image_url;
                        isAvailableInput.checked = consoleToEdit.is_available_for_rent;
                        cancelEditConsoleBtn.classList.remove('hidden');
                    }
                }

                // Cancel Console Edit
                cancelEditConsoleBtn.addEventListener('click', () => {
                    consoleForm.reset();
                    consoleIdInput.value = '';
                    cancelEditConsoleBtn.classList.add('hidden');
                });

                // Delete Console
                function deleteConsole(event) {
                    const idToDelete = parseInt(event.target.dataset.id);
                    if (confirm(`Apakah Anda yakin ingin menghapus model PlayStation dengan ID ${idToDelete}?`)) {
                        consoles = consoles.filter(c => c.id !== idToDelete);
                        renderConsoleList();
                        alert('Model PlayStation berhasil dihapus!');
                        console.log("Console deleted:", idToDelete);
                    }
                }
            </script>
        </body>

        </html>