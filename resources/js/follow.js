document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".btn-add-friend");
    buttons.forEach((button) => {
        button.addEventListener("click", function () {
            const userId = this.dataset.userId;
            const isFriend = this.dataset.friendStatus === "friend";
            const url = this.dataset.url;
            const csrfToken = this.dataset.csrfToken;

            fetch(url, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    Accept: "application/json",
                    "Content-Type": "application/json",
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    alert(data.message);
                    if (data.status === "added") {
                        this.dataset.friendStatus = "friend";
                        this.textContent = "Remove from Friends";
                    } else {
                        this.dataset.friendStatus = "not-friend";
                        this.textContent = "Add to Friends";
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                });
        });
    });
});
