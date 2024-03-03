document.addEventListener("DOMContentLoaded", function () {
    var loginModal = document.getElementById("loginModal");
    var signupModal = document.getElementById("signupModal");
    var overlay = document.getElementById("overlay");

    document
        .getElementById("loginLink")
        .addEventListener("click", function (event) {
            event.preventDefault();
            loginModal.style.display = "block";
            overlay.style.display = "block";
        });

    document
        .getElementById("signupLink")
        .addEventListener("click", function (event) {
            event.preventDefault();
            signupModal.style.display = "block";
            overlay.style.display = "block";
        });

    document.querySelectorAll(".close-btn").forEach(function (button) {
        button.addEventListener("click", function () {
            loginModal.style.display = "none";
            signupModal.style.display = "none";
            overlay.style.display = "none";
        });
    });

    document
        .getElementById("login-link")
        .addEventListener("click", function (event) {
            event.preventDefault();
            loginModal.style.display = "block";
            signupModal.style.display = "none";
        });

    document
        .getElementById("signup-link")
        .addEventListener("click", function (event) {
            event.preventDefault();
            signupModal.style.display = "block";
            loginModal.style.display = "none";
        });
});
