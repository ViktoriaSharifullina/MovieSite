document.addEventListener("DOMContentLoaded", function () {
    var loginModal = document.getElementById("loginModal");
    var signupModal = document.getElementById("signupModal");
    var overlay = document.getElementById("overlay");

    document
        .getElementById("signupLink")
        .addEventListener("click", function (event) {
            event.preventDefault();
            signupModal.style.display = "block";
            overlay.style.display = "block";
        });

    document
        .getElementById("loginLink")
        .addEventListener("click", function (event) {
            event.preventDefault();
            loginModal.style.display = "block";
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
                } else if (errorData.error) {
                    errorsContainer.innerHTML = `<div class="alert alert-danger">${errorData.error}</div>`;
                } else {
                    window.location.href = "/profile";
                }
            })
            .catch((error) => console.error("Error:", error));
    });

    const loginForm = document.querySelector("#loginModal form");

    loginForm.addEventListener("submit", function (e) {
        e.preventDefault();
        const formData = new FormData(loginForm);

        let url = this.getAttribute("data-url");
        const errorsContainer = document.querySelector(".errors-container");
        errorsContainer.innerHTML = "";

        fetch(url, {
            method: "POST",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            credentials: "same-origin",
            body: formData,
        })
            .then((response) => {
                if (!response.ok) {
                    throw response;
                }
                return response.json();
            })
            .then((data) => {
                console.log("User logged in successfully:", data);
                window.location.href = "/profile";
            })
            .catch((errorResponse) => {
                errorResponse.json().then((errorData) => {
                    console.error("Error:", errorData);
                    if (errorData.errors) {
                        const errors = errorData.errors;
                        const errorList = Object.keys(errors)
                            .map((key) => `<li>${errors[key].join(". ")}</li>`)
                            .join("");
                        errorsContainer.innerHTML = `<div class="alert alert-danger"><ul>${errorList}</ul></div>`;
                    } else if (errorData.error) {
                        errorsContainer.innerHTML = `<div class="alert alert-danger">${errorData.error}</div>`;
                    }
                });
            });
    });
});
