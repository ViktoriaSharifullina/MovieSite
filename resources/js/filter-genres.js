document.addEventListener("DOMContentLoaded", function () {
    var genres = [
        { id: 28, name: "Action" },
        { id: 37, name: "Western" },
        { id: 10752, name: "War" },
        { id: 9648, name: "Mystery" },
        { id: 99, name: "Documentary" },
        { id: 18, name: "Drama" },
        { id: 36, name: "History" },
        { id: 35, name: "Comedy" },
        { id: 80, name: "Crime" },
        { id: 10749, name: "Romance" },
        { id: 10402, name: "Music" },
        { id: 16, name: "Animation" },
        { id: 12, name: "Adventure" },
        { id: 10751, name: "Family" },
        { id: 10770, name: "TV Movie" },
        { id: 53, name: "Thriller" },
        { id: 27, name: "Horror" },
        { id: 878, name: "Science Fiction" },
        { id: 14, name: "Fantasy" },
    ];

    var filterGenresContainer = document.getElementById("filterGenres");
    var hiddenGenresField = document.getElementById("hiddenGenresField");

    if (!filterGenresContainer || !hiddenGenresField) {
        console.error("Some elements are missing.");
        return;
    }

    genres.forEach(function (genre) {
        var li = document.createElement("li");
        li.setAttribute("data-value", genre.id);
        li.textContent = genre.name;

        li.addEventListener("click", function () {
            this.classList.toggle("selected");
            updateSelectedGenres();
        });

        filterGenresContainer.appendChild(li);
    });

    function updateSelectedGenres() {
        var selectedGenres = Array.from(
            document.querySelectorAll("#filterGenres li.selected")
        ).map(function (li) {
            return li.getAttribute("data-value");
        });

        hiddenGenresField.value = selectedGenres.join(",");
    }
});
