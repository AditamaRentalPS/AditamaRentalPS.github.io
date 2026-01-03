document.addEventListener('DOMContentLoaded', () => {

  // ===============================
  // MOBILE MENU
  // ===============================
  const mobileMenuButton = document.getElementById('mobile-menu-button');
  const mobileMenu = document.getElementById('mobile-menu');

  if (mobileMenuButton && mobileMenu) {
    mobileMenuButton.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });
  }

  // ===============================
  // CTA SEWA SEKARANG → SCROLL KE PAKET
  // ===============================
  const btnSewaSekarang = document.getElementById('btn-sewa-sekarang');
  const rentalPackages = document.getElementById('rental-packages');

  if (btnSewaSekarang && rentalPackages) {
    btnSewaSekarang.addEventListener('click', () => {
      rentalPackages.scrollIntoView({ behavior: 'smooth' });
    });
  }

  // ===============================
  // AMBIL ELEMEN FORM
  // ===============================
  const pricePerUnitInput = document.getElementById('price-per-unit');
  const durationInput     = document.getElementById('duration');
  const durationType      = document.getElementById('duration-type');
  const totalText         = document.getElementById('total-price');
  const priceInfo         = document.getElementById('selected-package-price');

  // ===============================
  // HITUNG TOTAL
  // ===============================
function hitungTotal() {
  const durasiInput = document.getElementById('duration');
  const priceInput  = document.getElementById('price-per-unit');
  const totalText   = document.getElementById('total-price');
  const totalHidden = document.getElementById('total_price'); // 🔥 PENTING

  if (!durasiInput || !priceInput || !totalText || !totalHidden) return;

  const durasi = parseInt(durasiInput.value) || 0;
  const harga  = parseInt(priceInput.value) || 0;

  const total = durasi * harga;

  // tampil di UI
  totalText.textContent = 'Rp ' + total.toLocaleString('id-ID');

  // 🔥 INI YANG DIKIRIM KE PHP
  totalHidden.value = total;
}


  // ===============================
  // PESAN DARI CARD → BUKA FORM
  // ===============================
  document.querySelectorAll('.sewa-btn').forEach(btn => {
    btn.addEventListener('click', () => {

      const code   = btn.dataset.package;
      const name   = btn.dataset.name;
      const daily  = parseInt(btn.dataset.daily);
      const hourly = parseInt(btn.dataset.hourly);

      // simpan harga ke dataset
      pricePerUnitInput.dataset.daily  = daily;
      pricePerUnitInput.dataset.hourly = hourly;
      pricePerUnitInput.value = daily;

      document.getElementById('package').value = code;

      document.getElementById('selected-package-name').textContent = name;
      priceInfo.textContent =
        'Rp ' + daily.toLocaleString('id-ID') + ' / hari';

      document.getElementById('selected-package-info')
        .classList.remove('hidden');

      document.getElementById('contact')?.classList.remove('hidden');
      document.getElementById('rental-form')?.classList.remove('hidden');

      document.getElementById('contact')
        ?.scrollIntoView({ behavior: 'smooth' });

      hitungTotal();
    });
  });

  // ===============================
  // JENIS DURASI (HARI / JAM)
  // ===============================
  if (durationType) {
    durationType.addEventListener('change', () => {
      const isHourly = durationType.value === 'jam';

      const price = isHourly
        ? parseInt(pricePerUnitInput.dataset.hourly)
        : parseInt(pricePerUnitInput.dataset.daily);

      pricePerUnitInput.value = price;

      priceInfo.textContent =
        'Rp ' + price.toLocaleString('id-ID') +
        (isHourly ? ' / jam' : ' / hari');

      hitungTotal();
    });
  }

  // ===============================
  // HITUNG TOTAL SAAT DURASI DIKETIK
  // ===============================
  if (durationInput) {
    durationInput.addEventListener('input', hitungTotal);
  }

  // ===============================
  // DATE DEFAULT HARI INI
  // ===============================
  const dateInput = document.getElementById('rental-date');
  if (dateInput) {
    const today = new Date().toISOString().split('T')[0];
    dateInput.value = today;
    dateInput.min   = today;
  }

  // ===============================
  // LOGO → ADMIN (5x KLIK)
  // ===============================
  const logo = document.getElementById('logo');
  if (logo) {
    let count = 0;
    logo.addEventListener('click', () => {
      if (++count === 5) {
        window.location.href = 'admin/index.php';
      }
    });
  }

  const btnBayar = document.getElementById('btn-bayar');
  const qrisModal = document.getElementById('qris-modal');
  const btnKonfirmasi = document.getElementById('btn-konfirmasi-bayar');
  const rentalForm = document.getElementById('rental-form');

  if (btnBayar && qrisModal && btnKonfirmasi && rentalForm) {

    // klik SEWA SEKARANG → tampilkan QRIS
    btnBayar.addEventListener('click', () => {
      qrisModal.classList.remove('hidden');
      qrisModal.classList.add('flex');
    });

    // klik SAYA SUDAH BAYAR → submit form
    btnKonfirmasi.addEventListener('click', () => {
      qrisModal.classList.add('hidden');
      rentalForm.submit(); // 🔥 BARU SUBMIT KE PHP
    });

  }
});
