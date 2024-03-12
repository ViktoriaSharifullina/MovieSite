document.addEventListener("DOMContentLoaded", function () {
    var sortContentMenu = document.getElementById("sortContentMenu");
    var sortContent = document.getElementById("sortContent");
    var arrow = document.getElementById("arrow");
    var filterLanguage = document.getElementById("filterLanguage");
    var sortOptions = document.querySelectorAll(".sort-option");

    document
        .getElementById("sortButtonMenu")
        .addEventListener("click", function (event) {
            event.preventDefault();
            let sortContentMenu = document.getElementById("sortContentMenu");
            let arrow = document.getElementById("arrow");

            if (sortContentMenu.style.display === "none") {
                sortContentMenu.style.display = "block";
                arrow.style.transform = "rotate(0deg)";
            } else {
                sortContentMenu.style.display = "none";
                arrow.style.transform = "rotate(-90deg)";
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
        .getElementById("filterLanguageBtn")
        .addEventListener("click", function (event) {
            event.preventDefault();
            if (filterLanguage.style.display === "block") {
                filterLanguage.style.display = "none";
            } else {
                filterLanguage.style.display = "block";
            }
        });

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

    const languages = [
        { code: "en", name: "English" },
        { code: "fr", name: "French" },
        { code: "es", name: "Spanish" },
        { code: "de", name: "German" },
        { code: "ja", name: "Japanese" },
        { code: "pt", name: "Portuguese" },
        { code: "zh", name: "Chinese" },
        { code: "it", name: "Italian" },
        { code: "ru", name: "Russian" },
        { code: "ko", name: "Korean" },
        { code: "cs", name: "Czech" },
        { code: "ar", name: "Arabic" },
        { code: "nl", name: "Dutch" },
        { code: "hi", name: "Hindi" },
        { code: "sv", name: "Swedish" },
        { code: "tr", name: "Turkish" },
        { code: "pl", name: "Polish" },
        { code: "tl", name: "Tagalog" },
        { code: "cn", name: "Cantonese" },
        { code: "xx", name: "No Language" },
    ];

    const languageDropdown = document.getElementById("filterLanguage");
    const filterLanguageBtn = document.getElementById("filterLanguageBtn");
    const filterCaretIcon = filterLanguageBtn.querySelector(".fa-caret-down");

    languages.forEach((language) => {
        const languageLink = document.createElement("a");
        languageLink.href = "#";
        languageLink.className = "language-option";
        languageLink.dataset.language = language.code;
        languageLink.textContent = language.name;

        languageLink.addEventListener("click", function (e) {
            e.preventDefault();
            languageDropdown.style.display = "none";
            filterLanguageBtn.textContent = this.textContent;
            filterLanguageBtn.appendChild(filterCaretIcon);
        });

        languageDropdown.appendChild(languageLink);
    });

    var today = new Date().toISOString().substr(0, 10);
    document.getElementById("inputBefore").value = today;

    // Обработка выбора сортировки
    document.querySelectorAll(".sort-option").forEach((option) => {
        option.addEventListener("click", function (e) {
            e.preventDefault();
            const sortValue = this.getAttribute("data-sort");
            document.getElementById("hiddenSortField").value = sortValue;
        });
    });

    document.querySelectorAll(".language-option").forEach((option) => {
        option.addEventListener("click", function (e) {
            e.preventDefault();
            const languageValue = this.getAttribute("data-language");
            document.getElementById("hiddenLanguageField").value =
                languageValue;
        });
    });

    var form = document.getElementById("formFilter");

    form.addEventListener("submit", function (event) {
        var inputFromValue = document.getElementById("inputFrom").value;
        var inputBeforeValue = document.getElementById("inputBefore").value;

        if (inputFromValue) {
            document.getElementById("hiddenReleaseDateGteField").value =
                inputFromValue;
        }
        if (inputBeforeValue) {
            document.getElementById("hiddenReleaseDateLteField").value =
                inputBeforeValue;
        }
    });

    document
        .querySelector(".btn-search-filters")
        .addEventListener("click", function (e) {
            var dateFromValue = document.getElementById("inputFrom").value;
            document.getElementById("hiddenReleaseDateGteField").value =
                dateFromValue;

            var dateBeforeValue =
                document.getElementById("inputBefore").value ||
                new Date().toISOString().slice(0, 10);
            document.getElementById("hiddenReleaseDateLteField").value =
                dateBeforeValue;
        });
});
