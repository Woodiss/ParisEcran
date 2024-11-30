const sectionCinema = document.querySelector(".section-cinema")
const toggleCinema = document.querySelector("#collapse-cinema")

toggleCinema.addEventListener("click", () => {
    sectionCinema.classList.toggle("active")
})