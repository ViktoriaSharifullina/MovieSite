document.addEventListener("DOMContentLoaded", function () {
    var sortContentMenu = document.getElementById("sortContentMenu");
    var sortContent = document.getElementById("sortContent");
    var arrow = document.getElementById("arrow");
    var filterCountryContent = document.getElementById("filterCountry");

    document
        .getElementById("sortButtonMenu")
        .addEventListener("click", function (event) {
            event.preventDefault();
            if (sortContentMenu.style.display === "block") {
                sortContentMenu.style.display = "none";
                sortContent.style.display = "none";
                arrow.style.transform = "rotate(0deg)";
            } else {
                sortContentMenu.style.display = "block";
                arrow.style.transform = "rotate(90deg)";
            }
        });

    document
        .getElementById("sortButton")
        .addEventListener("click", function (event) {
            event.preventDefault();
            if (sortContent.style.display === "block") {
                sortContent.style.display = "none";
            } else {
                sortContent.style.display = "block";
            }
        });

    document
        .getElementById("filterCountryBtn")
        .addEventListener("click", function (event) {
            event.preventDefault();
            if (filterCountryContent.style.display === "block") {
                filterCountryContent.style.display = "none";
            } else {
                filterCountryContent.style.display = "block";
            }
        });
});

document.addEventListener("DOMContentLoaded", function () {
    var sortOptions = document.querySelectorAll(".sort-option");
    var sortContent = document.getElementById("sortContent");

    sortOptions.forEach(function (option) {
        option.addEventListener("click", function (e) {
            e.preventDefault();
            sortContent.style.display = "none";
            var selectedOption = option.textContent.trim();
            var sortBtn = document.getElementById("sortButton");
            var caretIcon = document.getElementById("sortCaretIcon");

            sortBtn.innerHTML = "";
            sortBtn.textContent = selectedOption;
            sortBtn.appendChild(caretIcon);
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    var countryOptions = document.querySelectorAll(".country-option");
    var filterCountryContent = document.getElementById("filterCountry");

    countryOptions.forEach(function (option) {
        option.addEventListener("click", function (e) {
            e.preventDefault();
            filterCountryContent.style.display = "none";
            var selectedCountry = option.textContent.trim();
            var filterBtn = document.getElementById("filterCountryBtn");
            var caretIcon = document.getElementById("filterCaretIcon");

            filterBtn.innerHTML = "";
            filterBtn.textContent = selectedCountry;
            filterBtn.appendChild(caretIcon);
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    var today = new Date().toISOString().substr(0, 10);
    document.getElementById("inputBefore").value = today;
});
