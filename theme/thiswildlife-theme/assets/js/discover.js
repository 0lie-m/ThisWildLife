document.addEventListener('DOMContentLoaded', function() {
  const revealItems = document.querySelectorAll(".reveal");

  const revealOnScroll = () => {
    revealItems.forEach(item => {
      const itemTop = item.getBoundingClientRect().top;
      const trigger = window.innerHeight - 70;

      if (itemTop < trigger) {
        item.classList.add("show");
      }
    });
  };

  window.addEventListener("scroll", revealOnScroll);
  window.addEventListener("load", revealOnScroll);
});