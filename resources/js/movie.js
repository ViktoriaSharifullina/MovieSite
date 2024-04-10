var btnContainer = document.getElementById("buttons-container");

document.querySelectorAll(".bookmark-btn, .heart-btn").forEach((button) => {
    button.addEventListener("click", function (e) {
        e.preventDefault();

        window.isUserAuthenticated =
            document.body.getAttribute("data-user-authenticated") === "1";

        if (!window.isUserAuthenticated) {
            document.getElementById("loginModal").style.display = "block";
            document.getElementById("overlay").style.display = "block";
            return;
        }

        const movieId = this.dataset.movieId;
        const listType = this.dataset.listType;
        const mediaType = this.dataset.mediaType;
        const url = this.dataset.url;
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");

        fetch(url, {
            method: "POST",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": csrfToken,
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                movie_tmdb_id: movieId,
                list_type: listType,
                media_type: mediaType,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
                if (data.status === "added") {
                    this.classList.add("focused");
                } else if (data.status === "removed") {
                    this.classList.remove("focused");
                }
            })
            .catch((error) => console.error("Error:", error));
    });
});

var textStarBtn = document.getElementById("btn-star-text");
var btnStarContent = document.querySelector("#btn-star-content");
var allNumbers = document.querySelectorAll(".number-rate");

document
    .getElementById("ratingMenu")
    .addEventListener("mouseleave", function (event) {
        var ratingMenu = document.getElementById("ratingMenu");
        var starButton = document.getElementById("starButton");

        ratingMenu.classList.add("hidden");
        starButton.classList.remove("hidden");
    });

var icon = document.getElementById("iconStar");
var iconOnMenu = document.getElementById("iconStarMenu");
var selectedNumber = document.getElementById("selectedNumber");

document.querySelectorAll(".number-rate").forEach((number) => {
    number.addEventListener("click", function (event) {
        const ratingValue = event.target.textContent;
        const movieId = document.getElementById("starButton").dataset.movieId;
        const url = document.getElementById("starButton").dataset.url;
        const mediaType =
            document.getElementById("starButton").dataset.mediaType;

        console.log(mediaType);

        var clickedNumber = event.target;

        allNumbers.forEach(function (number) {
            number.style.color = "#7e7e7e";
        });

        clickedNumber.style.color = "#ed3f40";
        iconOnMenu.style.color = "#ed3f40";
        icon.style.color = "#ed3f40";
        btnStarContent.classList.add("btn-content-wide");

        selectedNumber.textContent = clickedNumber.textContent;
        selectedNumber.classList.remove("hidden");
        textStarBtn.classList.remove("hidden");

        fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify({
                movie_tmdb_id: movieId,
                rating_value: ratingValue,
                media_type: mediaType,
            }),
        })
            .then((response) => {
                if (!response.ok)
                    throw new Error("Network response was not ok");
                return response.json();
            })
            .then((data) => {
                if (data.status === "Rating set") {
                    console.log("Rating was set successfully");
                }
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    });
});

document.getElementById("starButton").addEventListener("click", function () {
    const movieId = this.dataset.movieId;
    const url = this.dataset.url;
    const mediaType = this.dataset.mediaType;

    if (textStarBtn.classList.contains("hidden")) {
        starButton.classList.remove("focused");
        starButton.classList.add("hidden");
        ratingMenu.classList.remove("hidden");
    } else {
        textStarBtn.classList.add("hidden");
        starButton.classList.remove("focused");
        selectedNumber.textContent = "";
        btnStarContent.classList.remove("btn-content-wide");
        icon.style.color = "#7e7e7e";

        allNumbers.forEach(function (number) {
            number.style.color = "#7e7e7e";
        });

        console.log(mediaType);

        fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify({
                movie_tmdb_id: movieId,
                rating_value: 0,
                media_type: mediaType,
            }),
        })
            .then((response) => {
                if (!response.ok)
                    throw new Error("Network response was not ok");
                return response.json();
            })
            .then((data) => {
                if (data.status === "Rating removed") {
                    console.log("Rating removed successfully");
                } else if (
                    data.status === "Rating not found or already removed"
                ) {
                    console.log("Rating not found or already removed");
                }
            })
            .catch((error) => console.error("Error:", error));
    }
});

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

const reviewsTab = document.querySelector(".reviews");
const discussionsTab = document.querySelector(".discussions");

const reviewsContainer = document.querySelector(".reviews-container");
const commentsContainer = document.querySelector(".comments-container");

function resetActiveState() {
    reviewsTab.classList.remove("active");
    discussionsTab.classList.remove("active");
    reviewsContainer.style.display = "none";
    commentsContainer.style.display = "none";
}

// Обработчик событий для вкладки "Reviews"
reviewsTab.addEventListener("click", function () {
    resetActiveState();
    this.classList.add("active");
    reviewsContainer.style.display = "block";
});

// Обработчик событий для вкладки "Discussions"
discussionsTab.addEventListener("click", function () {
    resetActiveState();
    this.classList.add("active");
    commentsContainer.style.display = "block";
});

// Инициализируем состояние интерфейса
resetActiveState();
reviewsTab.click();
