document.addEventListener('DOMContentLoaded', () => {

  // =========================
  // MOBILE MENU
  // =========================
  const mobileMenuButton = document.getElementById('mobile-menu-button');
  const mobileMenu = document.getElementById('mobile-menu');

  if (mobileMenuButton && mobileMenu) {
    mobileMenuButton.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });
  }

  // =========================
  // PAGE LOAD ANIMATION (A)
  // =========================
 const animatedSections = document.querySelectorAll('.page-animate');

  setTimeout(() => {
  animatedSections.forEach((section, index) => {
    setTimeout(() => {
      section.classList.add('show');
    }, index * 250);
  });
}, 300);


  // =========================
  // GAME SLIDESHOW
  // =========================
  const container = document.getElementById('game-slides-container');
  if (!container) return;

  const slides = container.children;
  const totalSlides = slides.length;
  if (totalSlides === 0) return;

  let currentIndex = 0;
  let autoSlide = setInterval(nextSlide, 4000);

  function updateSlide() {
    container.style.transform = `translateX(-${currentIndex * 100}%)`;
  }

  function nextSlide() {
    currentIndex = (currentIndex + 1) % totalSlides;
    updateSlide();
  }

  function prevSlide() {
    currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
    updateSlide();
  }

  document.getElementById('nextSlide')?.addEventListener('click', () => {
    nextSlide();
    resetAutoSlide();
  });

  document.getElementById('prevSlide')?.addEventListener('click', () => {
    prevSlide();
    resetAutoSlide();
  });

  container.parentElement?.addEventListener('mouseenter', () => {
    clearInterval(autoSlide);
  });

  container.parentElement?.addEventListener('mouseleave', () => {
    autoSlide = setInterval(nextSlide, 4000);
  });

  function resetAutoSlide() {
    clearInterval(autoSlide);
    autoSlide = setInterval(nextSlide, 4000);
  }

  // =========================
// SHOW CONTACT FORM ON CLICK
// =========================
const rentalButtons = document.querySelectorAll('.open-rental-form');
const contactSection = document.getElementById('contact');

rentalButtons.forEach(btn => {
  btn.addEventListener('click', e => {
    e.preventDefault();

    // tampilkan form jika masih tersembunyi
    if (contactSection.classList.contains('hidden')) {
      contactSection.classList.remove('hidden');

      // animasi masuk
      contactSection.classList.add('page-animate');
      setTimeout(() => {
        contactSection.classList.add('show');
      }, 50);
    }

    // scroll ke form
    contactSection.scrollIntoView({
      behavior: 'smooth',
      block: 'start'
    });
  });
});

let clickCount = 0;
document.getElementById('logo').addEventListener('click', () => {
  clickCount++;
  if (clickCount === 5) {
  window.location.href = 'admin/index.php';
  }
});

document.addEventListener('DOMContentLoaded', () => {
  const pesanButtons = document.querySelectorAll('.sewa-btn');
  const btnSewaSekarang = document.getElementById('btn-sewa-sekarang');
  const contactSection = document.getElementById('contact');
  const packageSelect = document.getElementById('package');

  // ===============================
  // 1. KLIK "PESAN" → SIMPAN PAKET
  // ===============================
  pesanButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      const selectedPackage = btn.dataset.package;
      if (!selectedPackage) return;

      // simpan paket yang dipilih
      localStorage.setItem('selected_package', selectedPackage);

      // scroll ke tombol "Sewa Sekarang"
      btnSewaSekarang.scrollIntoView({ behavior: 'smooth' });
    });
  });

  // ===============================
  // 2. KLIK "SEWA SEKARANG" → BUKA FORM
  // ===============================
  btnSewaSekarang.addEventListener('click', () => {
    const selectedPackage = localStorage.getItem('selected_package');

    // tampilkan form
    contactSection.classList.remove('hidden');

    // scroll ke form
    contactSection.scrollIntoView({ behavior: 'smooth' });

    // isi paket otomatis
    if (selectedPackage) {
      setTimeout(() => {
        packageSelect.value = selectedPackage;
        packageSelect.dispatchEvent(new Event('change'));
      }, 300);
    }
  });
});
});
