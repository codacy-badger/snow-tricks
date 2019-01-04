const showMediaButton = document.querySelector("[data-action='display-medias-mobile']");

showMediaButton.addEventListener("click", function (event) {
    const mediaWrapper = document.querySelector(".media-wrapper");

    mediaWrapper.classList.toggle('media-wrapper__show');

    const btnMediaWrapper = document.querySelector(".mobile-btn");

    btnMediaWrapper.text = "Cacher les médias";
});
