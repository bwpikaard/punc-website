$(document).ready(function() {
    const form = $(".needs-validation");

    $(".needs-validation").submit(event => {
        if (!form[0].checkValidity()) {
            event.preventDefault();
        }
        form.addClass('was-validated');
    });
});