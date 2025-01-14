// Get elements
const modalll = document.getElementById("vetcamp-modal");
const btnnn = document.getElementById("conocer-mas-vetcamp");
const closeBtnnn = document.querySelector(".modal .closeee");

// Open modal when button is clicked
btnnn.addEventListener("click", () => {
  modalll.style.display = "block";
});

// Close modal when 'X' is clicked
closeBtnnn.addEventListener("click", () => {
  modalll.style.display = "none";
});

// Close modal when clicking outside of the modal content
window.addEventListener("click", (e) => {
  if (e.target === modal) {
    modalll.style.display = "none";
  }
});
