const toggleNav = document.querySelector("#toggle-nav");
const asideNav = document.querySelector("aside");
const svgs = toggleNav.querySelectorAll("svg");

toggleNav.addEventListener("click", () => {
    const isOpen = asideNav.classList.toggle("open");
    
    svgs[0].classList.toggle("hide", isOpen);
    svgs[1].classList.toggle("hide", !isOpen);

    document.body.classList.toggle("no-scroll", isOpen && window.innerWidth <= 600);
});