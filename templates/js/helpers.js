
function redirect_to_image($img_url) {
    var url = $img_url;

    window.open(url, '_blank');
}

function remove_modal() {
    var modal = document.getElementById('modal-container');
    modal.remove();
}