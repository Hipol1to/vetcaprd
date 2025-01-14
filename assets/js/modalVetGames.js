// Get elements
const modall = document.getElementById("vetgames-modal");
const btnn = document.getElementById("conocer-mas-vetgames");
const closeBtnn = document.querySelector(".modal .closee");

// Open modal when button is clicked
btnn.addEventListener("click", () => {
  modall.style.display = "block";
});

// Close modal when 'X' is clicked
closeBtnn.addEventListener("click", () => {
  modall.style.display = "none";
});

// Close modal when clicking outside of the modal content
window.addEventListener("click", (e) => {
  if (e.target === modal) {
    modall.style.display = "none";
  }
});
