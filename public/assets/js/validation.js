$(document).ready(function() {
    const params = new URLSearchParams(window.location.search);

    if (params.has("ue")) {
        $("#username").addClass("is-invalid").parent().find(".invalid-feedback").html(params.get("ue"));
    } else if (params.has("pe")) {
        $("#password").addClass("is-invalid").parent().find(".invalid-feedback").html(params.get("pe"));
    }
});