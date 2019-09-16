/*Закрытие всплывающего окна*/
var modalhelp = document.querySelector(".modal-help");
var modaloverlay = document.querySelector(".modal-overlay");
var closehelp = modalhelp.querySelector(".close");

document.addEventListener("click", function (evt) {
    if (evt.target == closehelp ) {
        evt.preventDefault();
        modaloverlay.classList.remove("modal-show");
        modalhelp.classList.remove("modal-show");
    }
});

window.addEventListener("keydown", function (evt) {
    if (evt.keyCode === 27) {
        if (modalhelp.classList.contains("modal-show")) {
            evt.preventDefault();
            modaloverlay.classList.remove("modal-show");
            modalhelp.classList.remove("modal-show");
        }
    }
});
