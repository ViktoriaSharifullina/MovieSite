var btnContainer = document.getElementById("buttons-container");
var btns = btnContainer.getElementsByClassName("btn");

for (var i = 0; i < btns.length; i++) {
    btns[i].addEventListener("click", function () {
        if (this.classList.contains("focused")) {
            this.classList.remove("focused");
        } else {
            this.classList.add("focused");
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    const ratingButton = document.getElementById("ratingButton");
    const ratingMenu = document.getElementById("ratingMenu");
    const closeMenu = document.getElementById("closeMenu");
    const stars = document.getElementById("stars");
    const ratingValue = document.getElementById("ratingValue");
    const submitRating = document.getElementById("submitRating");

    ratingButton.addEventListener("click", function () {
        ratingMenu.style.display = "block";
    });

    closeMenu.addEventListener("click", function () {
        ratingMenu.style.display = "none";
    });

    stars.addEventListener("click", function (e) {
        if (e.target.tagName === "I") {
            const rating = parseInt(e.target.getAttribute("data-rating"), 10);
            ratingValue.textContent = rating.toFixed(1);
        }
    });

    submitRating.addEventListener("click", function () {
        ratingMenu.style.display = "none";
        // You can perform additional actions here based on the selected rating
    });
});
