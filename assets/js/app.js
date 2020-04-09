require('../css/app.css');

// Hide flash messages after some time
const flashes = document.getElementsByClassName("flash");
if (flashes.length > 0) {
    window.setTimeout(() => {
        flashes.forEach((elem) => elem.style.display = 'none');
    }, 4500)
}