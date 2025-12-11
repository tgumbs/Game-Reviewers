document.addEventListener("DOMContentLoaded", () => {
  const cards = document.querySelectorAll(".review-card");
  const navLinks = document.querySelectorAll("nav a");

  navLinks.forEach(link => {
    link.addEventListener("mouseenter", () => {
      link.style.color = "#ffcc00"; // change color on hover
    });

    link.addEventListener("mouseleave", () => {
      link.style.color = "#ffffff"; // reset to original color
    });
  });

  cards.forEach(card => {
    card.addEventListener("mouseenter", () => {
      card.style.transform = "translateY(-8px)";
      card.style.boxShadow = "0 0 15px #ffa600";
      card.style.transition = "all 0.3s ease";
    });

    card.addEventListener("mouseleave", () => {
      card.style.transform = "translateY(0)";
      card.style.boxShadow = "none";
    });
  });
});
