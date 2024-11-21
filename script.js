function scrollToSection(id) {
  const section = document.getElementById(id);
  if (section) {
      section.scrollIntoView({ behavior: 'smooth' });
  }
}

document.querySelectorAll('nav ul li a').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const targetId = this.getAttribute('href').substring(1);
      scrollToSection(targetId);
  });
});
