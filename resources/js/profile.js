document.addEventListener("DOMContentLoaded", function () {
    const currentPath = window.location.pathname;
    document.querySelectorAll(".profile-link").forEach((link) => {
        const linkUrl = new URL(
            link.getAttribute("href"),
            window.location.origin
        );
        if (currentPath === linkUrl.pathname) {
            link.classList.add("active");
        }
    });
});
