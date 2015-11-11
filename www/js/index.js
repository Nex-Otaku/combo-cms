function showSystemMessage(id) {
    var selector = "#" + id;
    $(selector).show();
    setTimeout(function() { $(selector).fadeOut("slow"); }, 5000);
}

$(function() {
    showSystemMessage("errorMessage");
    showSystemMessage("statusMessage");
});