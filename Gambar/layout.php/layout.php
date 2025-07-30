<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Rental PS' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen p-10 font-sans">
    <div class="container mx-auto">
        <header class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold"><?= $title ?? '' ?></h1>
            <a href="/logout.php" class="text-sm text-red-400 hover:text-red-200">Logout</a>
        </header>

        <main>
            <?= $content ?? '' ?>
        </main>
    </div>
</body>
</html>
