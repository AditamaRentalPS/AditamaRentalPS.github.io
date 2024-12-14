const express = require('express');
const app = express();

const maintenanceMode = true; // Ganti ke false jika selesai

app.use((req, res, next) => {
    if (maintenanceMode) {
        res.status(503).send(`
            <!DOCTYPE html>
            <html lang="id">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Website Dalam Perbaikan</title>
                <style>
                    body { text-align: center; font-family: Arial, sans-serif; padding: 50px; }
                    h1 { color: #555; }
                </style>
            </head>
            <body>
                <h1>Website Sedang Dalam Perbaikan</h1>
                <p>Kami sedang melakukan pembaruan. Silakan kembali lagi nanti.</p>
            </body>
            </html>
        `);
    } else {
        next();
    }
});

// Tambahkan rute normal di bawah ini
app.get('/', (req, res) => {
    res.send('Website aktif!');
});

app.listen(3000, () => {
    console.log('Server berjalan di http://localhost:3000');
});
