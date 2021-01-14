let fm_close = document.getElementById('flash-message_close');
let flash_message = document.querySelector('.flash-message');

fm_close.addEventListener("click", () => {
    flash_message.classList.add('hide');
    flash_message.classList.remove('show');
});