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

document.getElementById("starButton").addEventListener("click", hideStarButton);

var starButton = document.getElementById("starButton");
var ratingMenu = document.getElementById("ratingMenu");
var textStarBtn = document.getElementById("btn-star-text");
var selectedNumber = document.getElementById("selectedNumber");
var btnStarContent = document.querySelector("#btn-star-content");
var allNumbers = document.querySelectorAll(".number-rate");
var iconOnMenu = document.getElementById("iconStarMenu");
var icon = document.getElementById("iconStar");

function hideStarButton() {
    if (!textStarBtn.classList.contains("hidden")) {
        textStarBtn.classList.add("hidden");
        starButton.classList.remove("focused");
        selectedNumber.textContent = "";
        btnStarContent.style.width = "40px";
        icon.style.color = "#7e7e7e";

        allNumbers.forEach(function (number) {
            number.style.color = "#7e7e7e";
        });
    } else {
        starButton.classList.remove("focused");
        starButton.classList.add("hidden");
        ratingMenu.classList.remove("hidden");
    }
}

document
    .getElementById("ratingMenu")
    .addEventListener("mouseleave", hideRatingMenu);

function hideRatingMenu() {
    var ratingMenu = document.getElementById("ratingMenu");
    var starButton = document.getElementById("starButton");

    ratingMenu.classList.add("hidden");
    starButton.classList.remove("hidden");
}

document.querySelectorAll(".number-rate").forEach(function (number) {
    number.addEventListener("click", rateMovie);
});

function rateMovie(event) {
    var clickedNumber = event.target;

    allNumbers.forEach(function (number) {
        number.style.color = "#7e7e7e";
    });

    clickedNumber.style.color = "#ed3f40";
    iconOnMenu.style.color = "#ed3f40";
    icon.style.color = "#ed3f40";
    btnStarContent.style.width = "230px";

    selectedNumber.textContent = clickedNumber.textContent;
    selectedNumber.classList.remove("hidden");
    textStarBtn.classList.remove("hidden");
}

var swiper = new Swiper(".slide-content", {
    slidesPerView: 3,
    spaceBetween: 15,
    loop: true,
    fade: true,
    grabCursor: true,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
        dynamicBullets: true,
    },
    navigation: {
        nextEl: ".arrow.next",
        prevEl: ".arrow.prev",
    },
});
