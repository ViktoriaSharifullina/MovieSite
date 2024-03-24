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

    const form = document.querySelector("#signupModal form");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const errorContainer = document.querySelector(".errors-container");
        errorContainer.innerHTML = "";

        const formData = new FormData(form);
        let url = this.getAttribute("data-url");

        fetch(url, {
            method: "POST",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.errors) {
                    const errors = data.errors;
                    const errorList = Object.keys(errors)
                        .map((key) => `<li>${errors[key].join(". ")}</li>`)
                        .join("");
                    errorContainer.innerHTML = `<div class="alert alert-danger"><ul>${errorList}</ul></div>`;
                } else {
                    window.location.href = "/profile";
                }
            })
            .catch((error) => console.error("Error:", error));
    });
});
