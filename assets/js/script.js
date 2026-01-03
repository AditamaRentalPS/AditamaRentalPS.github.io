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
  const contactForm = document.getElementById('contact');

  if (btnSewaSekarang && rentalPackages) {
    btnSewaSekarang.addEventListener('click', () => {
      // pastikan form disembunyikan
      if (contactForm) {
        contactForm.classList.add('hidden');
      }

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
    const hourly = parseInt(btn.dataset.hourly);

    document.getElementById('package').value = code;
    document.getElementById('price-per-unit').value = daily;

    document.getElementById('selected-package-name').textContent = name;
    document.getElementById('selected-package-price').textContent =
      'Rp' + daily.toLocaleString('id-ID') + ' / hari';

    document.getElementById('selected-package-info')
      .classList.remove('hidden');
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
