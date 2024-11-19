document.querySelector(".arrow").addEventListener("click", function () {
    const target = document.querySelector("#next-section");
    target.scrollIntoView({ behavior: "smooth" });
});
