// kod na dropdown
const masters = document.querySelectorAll(".dropdown-parent");
console.log(masters);
for (const master of masters) {
    const slaves = master.querySelectorAll(".dropdown-clicker");
    const targets = master.querySelectorAll(".dropdown-child");
    slaves[0].addEventListener("click", () => {
        if (master.classList.contains("dropped")) {
            targets[0].style.display = "block";
            master.classList.remove("dropped");
        } else {
            targets[0].style.display = "none";
            master.classList.add("dropped");
        }
    })
}
