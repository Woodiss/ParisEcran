const allContainers = document.querySelectorAll(".container-card-film");

allContainers.forEach((container) => {
  const leftToggle = container.querySelector("button:first-of-type");
  const rightToggle = container.querySelector("button:last-of-type");
  const contentFilm = container.querySelector(".film-content");

  if (contentFilm.offsetWidth < contentFilm.scrollWidth) {
    rightToggle.classList.add("active");
    contentFilm.addEventListener("scroll", (e) => {
      const scrollLeft = e.target.scrollLeft;
      const maxScrollLeft = e.target.scrollWidth - e.target.offsetWidth;
      console.log(scrollLeft, maxScrollLeft);

      if (scrollLeft > 0) {
        leftToggle.classList.add("active");
      } else {
        leftToggle.classList.remove("active");
      }

      if (scrollLeft >= maxScrollLeft) {
        rightToggle.classList.remove("active");
      } else {
        rightToggle.classList.add("active");
      }
    });
  }

  function handleClick(direction) {
    if (direction === "right") {
      contentFilm.scrollLeft = contentFilm.scrollLeft + contentFilm.offsetWidth;
      leftToggle.classList.add("active");
    } else if (direction === "left") {
      contentFilm.scrollLeft = contentFilm.scrollLeft - contentFilm.offsetWidth;
    }
  }

  rightToggle.addEventListener("click", () => handleClick("right"));
  leftToggle.addEventListener("click", () => handleClick("left"));
});
