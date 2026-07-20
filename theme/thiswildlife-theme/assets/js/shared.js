// ================= SHARED JAVASCRIPT ================= 

// Hamburger Menu Toggle
document.addEventListener('DOMContentLoaded', function() {
  const hamburgerBtn = document.getElementById("menuBtn") || document.getElementById("hamburgerBtn");
  const mobileMenu = document.getElementById("mobileMenu");

  if (hamburgerBtn && mobileMenu) {
    hamburgerBtn.addEventListener("click", () => {
      mobileMenu.style.display = mobileMenu.style.display === "block" ? "none" : "block";
    });
  }
});
