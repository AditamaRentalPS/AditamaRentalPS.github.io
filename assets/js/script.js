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
  // PAGE LOAD ANIMATION
  // ===============================
  const animatedSections = document.querySelectorAll('.page-animate');
  setTimeout(() => {
    animatedSections.forEach((section, index) => {
      setTimeout(() => section.classList.add('show'), index * 250);
    });
  }, 300);

  // ===============================
  // PESAN → SIMPAN PAKET
  // ===============================
  const pesanButtons = document.querySelectorAll('.sewa-btn');
  const btnSewaSekarang = document.getElementById('btn-sewa-sekarang');

  pesanButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      const paket = btn.dataset.package;
      if (!paket) return;

      // simpan paket
      localStorage.setItem('selected_package', paket);

      // scroll ke tombol sewa sekarang
      if (btnSewaSekarang) {
        btnSewaSekarang.scrollIntoView({ behavior: 'smooth' });
      }
    });
  });

  // ===============================
  // SEWA SEKARANG → BUKA FORM
  // ===============================
  const contactSection = document.getElementById('contact');
  const packageSelect = document.getElementById('package');

  if (btnSewaSekarang && contactSection && packageSelect) {
    btnSewaSekarang.addEventListener('click', () => {
      const paket = localStorage.getItem('selected_package');

      // tampilkan form
      contactSection.classList.remove('hidden');

      // scroll ke form
      contactSection.scrollIntoView({ behavior: 'smooth' });

      // isi paket otomatis
      if (paket) {
        setTimeout(() => {
          packageSelect.value = paket;
          packageSelect.dispatchEvent(new Event('change'));
        }, 300);
      }
    });
  }

  // ===============================
  // LOGO → ADMIN (EASTER EGG)
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
