const showContainers = document.querySelectorAll(".show-replies");

showContainers.forEach((btn) =>
    btn.addEventListener("click", (e) => {
        let parentContainer = e.target.closest(".comment__container");
        console.log("it works!");
        let _id = parentContainer.id;
        if (_id) {
            let childrenContainer = parentContainer.querySelectorAll(
                `[dataset=${_id}]`
            );
            childrenContainer.forEach((child) =>
                child.classList.toggle("opened")
            );
        }
    })
);

document.addEventListener("DOMContentLoaded", function () {
    var writeReplyButtons = document.querySelectorAll(".write-reply");
    var cancelButtons = document.querySelectorAll(".cancel-comment-button");

    writeReplyButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            var commentCard = button.closest(".comment__card");
            var writeCommentContainer = commentCard.querySelector(
                ".write-comment-container"
            );
            writeCommentContainer.style.display = "block";
        });
    });

    cancelButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            var writeCommentContainer = button.closest(
                ".write-comment-container"
            );
            writeCommentContainer.style.display = "none";
        });
    });
});
