document.addEventListener("DOMContentLoaded", function () {
    var modal = document.getElementById("loginModal");
    var overlay = document.getElementById("overlay");

    document
        .getElementById("loginLink")
        .addEventListener("click", function (event) {
            event.preventDefault();
            modal.style.display = "block";
            overlay.style.display = "block";
        });

    document
        .querySelector(".overlay-modal")
        .addEventListener("click", function () {
            modal.style.display = "none";
            overlay.style.display = "none";
        });

    document.querySelector(".close-btn").addEventListener("click", function () {
        modal.style.display = "none";
        overlay.style.display = "none";
    });
});
