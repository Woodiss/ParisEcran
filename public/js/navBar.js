const toggleBtn = document.querySelector("button#toogle-nav")
const navLinksContainer = document.querySelector(".navlinks-container")
function handleClick() {
    toggleBtn.classList.toggle("active")
    navLinksContainer.classList.toggle("active")
    document.body.classList.toggle("no-scroll")
}

toggleBtn.addEventListener("click", handleClick)

