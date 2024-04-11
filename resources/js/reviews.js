document.addEventListener("DOMContentLoaded", function () {
    const reviewButton = document.querySelector(".btn-write-review");
    const reviewFormContainer = document.querySelector(".write-form-container");
    const reviewForm = document.getElementById("review-form");

    // Переключение между показом формы и изменением текста кнопки
    reviewButton.addEventListener("click", function (event) {
        event.preventDefault();
        reviewFormContainer.classList.toggle("hidden");
        reviewButton.textContent =
            reviewButton.textContent === "Write a review"
                ? "Cancel"
                : "Write a review";
    });

    // Обработка отправки формы
    reviewForm.addEventListener("submit", function (event) {
        event.preventDefault();
        const formData = new FormData(reviewForm);
        const actionUrl = reviewForm.getAttribute("action");

        fetch(actionUrl, {
            method: "POST",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": formData.get("_token"),
            },
            body: new URLSearchParams(formData),
        })
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
                reviewFormContainer.classList.add("hidden");
                reviewButton.textContent = "Write a review";
                reviewForm.reset();
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    });
});
