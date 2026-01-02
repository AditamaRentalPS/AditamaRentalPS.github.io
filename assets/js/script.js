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

  animatedSections.forEach((section, index) => {
    setTimeout(() => {
      section.classList.add('show');
    }, index * 200);
  });

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

});
