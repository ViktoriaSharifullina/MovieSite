document
    .querySelectorAll(".row-movie .movie-container")
    .forEach((container) => {
        const bookmarkBtn = container.querySelector(".bookmark-btn");

        container.addEventListener("mouseenter", () => {
            bookmarkBtn.style.opacity = 1; // Показываем кнопку при наведении
        });

        container.addEventListener("mouseleave", () => {
            bookmarkBtn.style.opacity = 0; // Скрываем кнопку при уходе курсора
        });

        bookmarkBtn.addEventListener("click", (e) => {
            e.preventDefault();

            // Ваш код для обработки клика на кнопку...

            // Например, добавить анимацию с использованием GSAP
            gsap.to(bookmarkBtn, {
                // Ваши настройки анимации...
            });
        });
    });
