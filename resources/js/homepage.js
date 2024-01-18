const arrows = document.querySelectorAll(".arrow");
const movieLists = document.querySelectorAll(".movie-list");

arrows.forEach((arrow, i) => {
    const itemNumber = movieLists[i].querySelectorAll("img").length;
    const visibleItems = 7; // Количество видимых элементов
    const moveCount = 2; // Количество элементов, перемещаемых за каждый клик
    const maxClicks = Math.ceil((itemNumber - visibleItems) / moveCount);

    let clickCounter = 0;

    arrow.addEventListener("click", () => {
        if (clickCounter < maxClicks) {
            movieLists[i].style.transform = `translateX(${
                movieLists[i].computedStyleMap().get("transform")[0].x.value -
                230 * moveCount
            }px)`;
            clickCounter++;
        } else {
            movieLists[i].style.transform = "translateX(0)";
            clickCounter = 0;
        }
    });
});
