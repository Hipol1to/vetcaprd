// JavaScript for slider functionality
document.addEventListener("DOMContentLoaded", function () {
  const slides = document.querySelectorAll(".slider-item-001");
  const dotsContainer = document.querySelector(".slider-dots-001");
  let currentSlide = 0;

  // Create dots dynamically
  slides.forEach((_, index) => {
    const dot = document.createElement("span");
    dot.classList.add("dot-001");
    if (index === 0) dot.classList.add("active-001");
    dot.addEventListener("click", () => goToSlide(index));
    dotsContainer.appendChild(dot);
  });

  const dots = document.querySelectorAll(".slider-dots-001 span");

  function goToSlide(index) {
    slides[currentSlide].classList.remove("active-001");
    dots[currentSlide].classList.remove("active-001");
    currentSlide = index;
    slides[currentSlide].classList.add("active-001");
    dots[currentSlide].classList.add("active-001");
  }

  // Auto-slide every 5 seconds
  setInterval(() => {
    let nextSlide = (currentSlide + 1) % slides.length;
    goToSlide(nextSlide);
  }, 5000);
});
