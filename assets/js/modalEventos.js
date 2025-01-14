// Get elements
const modal = document.getElementById("vetcap-tour-modal");
const btn = document.getElementById("conocer-mas-vetcap_tour");
const closeBtn = document.querySelector(".modal .close");

// Open modal when button is clicked
btn.addEventListener("click", () => {
  modal.style.display = "block";
});

// Close modal when 'X' is clicked
closeBtn.addEventListener("click", () => {
  modal.style.display = "none";
});

// Close modal when clicking outside of the modal content
window.addEventListener("click", (e) => {
  if (e.target === modal) {
    modal.style.display = "none";
  }
});
