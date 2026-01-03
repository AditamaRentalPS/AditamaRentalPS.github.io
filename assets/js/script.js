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
  // CTA: SEWA SEKARANG → SCROLL KE PAKET
  // ===============================
 const btnSewaSekarang = document.getElementById('btn-sewa-sekarang');
const rentalPackages = document.getElementById('rental-packages');

if (btnSewaSekarang && rentalPackages) {
  btnSewaSekarang.addEventListener('click', () => {
    rentalPackages.scrollIntoView({
      behavior: 'smooth',
      block: 'start'
    });
  });
}

  // ===============================
  // PESAN DARI CARD → BUKA FORM
  // ===============================
document.querySelectorAll('.sewa-btn').forEach(btn => {
  btn.addEventListener('click', () => {

    const code = btn.dataset.package;
    const name = btn.dataset.name;
    const daily = parseInt(btn.dataset.daily);

    // isi hidden input
    document.getElementById('package').value = code;
    document.getElementById('price-per-unit').value = daily;

    // tampilkan info paket
    document.getElementById('selected-package-name').textContent = name;
    document.getElementById('selected-package-price').textContent =
      'Rp ' + daily.toLocaleString('id-ID') + ' / hari';

    document
      .getElementById('selected-package-info')
      .classList.remove('hidden');

    // 🔥 TAMPILKAN SECTION CONTACT + FORM
    const contactSection = document.getElementById('contact');
    const formSection = document.getElementById('rental-form');

    if (contactSection && formSection) {
      contactSection.classList.remove('hidden'); // ⬅️ INI YANG KURANG
      formSection.classList.remove('hidden');

      contactSection.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
      });
    }

  });
});



  // ===============================
  // DATE MIN TODAY
  // ===============================
  const dateInput = document.getElementById('rental-date');
  if (dateInput) {
    const today = new Date().toISOString().split('T')[0];
    dateInput.min = today;
  }

  // ===============================
  // LOGO → ADMIN (5x CLICK)
  // ===============================
  const logo = document.getElementById('logo');
  if (logo) {
    let clickCount = 0;
    logo.addEventListener('click', () => {
      clickCount++;
      if (clickCount === 5) {
        window.location.href = 'admin/index.php';
      }
    });
  }

});
