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

 // === CTA "Sewa Sekarang" ===
document.getElementById('btn-sewa-sekarang')
  ?.addEventListener('click', () => {
    const chooseSection = document.getElementById('choose-package');

    chooseSection.classList.remove('hidden');
    chooseSection.scrollIntoView({
      behavior: 'smooth',
      block: 'start'
    });
  });


// === Dari Card Paket (Pesan) ===
document.querySelectorAll('.sewa-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    const pkg = btn.dataset.package;

    document.getElementById('package').value = pkg;

    document.getElementById('contact').classList.remove('hidden');
    document.getElementById('contact')
      .scrollIntoView({ behavior: 'smooth' });
  });
});

// === Pilih PS Manual ===
document.querySelectorAll('.choose-ps-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    const pkg = btn.dataset.package;

    document.getElementById('package').value = pkg;

    document.getElementById('contact').classList.remove('hidden');
    document.getElementById('contact').scrollIntoView({
      behavior: 'smooth'
    });
  });
});


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

  document.addEventListener('DOMContentLoaded', () => {
  const dateInput = document.getElementById('rental-date');
  if (!dateInput) return;

  const today = new Date().toISOString().split('T')[0];
  dateInput.min = today;
});

document.querySelectorAll('.sewa-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    const pkg = btn.dataset.package;
    document.getElementById('package').value = pkg;

    document.getElementById('contact').classList.remove('hidden');
    document.getElementById('contact').scrollIntoView({ behavior: 'smooth' });
  });
});

document.addEventListener('DOMContentLoaded', () => {
  const btnSewaSekarang = document.getElementById('btn-sewa-sekarang');
  const choosePackage = document.getElementById('choose-package');
  const contactForm = document.getElementById('contact');

  if (btnSewaSekarang && choosePackage) {
    btnSewaSekarang.addEventListener('click', () => {
      // Tampilkan pilih PS
      choosePackage.classList.remove('hidden');

      // Pastikan form masih disembunyikan
      if (contactForm) {
        contactForm.classList.add('hidden');
      }

      choosePackage.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
      });
    });
  }
});



});
