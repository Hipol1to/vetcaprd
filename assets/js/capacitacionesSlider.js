const slider = document.querySelector(".slider-capacitaciones");
const slides = document.querySelectorAll(".slide");
const prevBtn = document.querySelector(".prev-btn");
const nextBtn = document.querySelector(".next-btn");

let currentIndex = 0; // Tracks the current slide index
const totalSlides = slides.length; // Total number of slides

function updateSliderPosition() {
  // Adjust the slider position based on the current index
  const offset = -currentIndex * 100; // Multiply by 100% to shift slides
  slider.style.transform = `translateX(${offset}%)`;
}

// Event listener for previous button
prevBtn.addEventListener("click", () => {
  // Decrement the index and wrap around using modulo
  currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
  updateSliderPosition(); // Update slider position
});

// Event listener for next button
nextBtn.addEventListener("click", () => {
  // Increment the index and wrap around using modulo
  currentIndex = (currentIndex + 1) % totalSlides;
  updateSliderPosition(); // Update slider position
});
