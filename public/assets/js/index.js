function searchMembers() {
    const input = $("#search-members").val().toLowerCase();
    const members = $(".members .list").children();

    members.each(m => {
        $(`.members .list .member#member-${m + 1}`).toggle(
            $(`.members .list .member#member-${m + 1} .field.name`).html().toLowerCase().includes(input)
        );
    });
}

$(document).ready(function() {
    const form = $(".needs-validation");

    $(".needs-validation").submit(event => {
        if (!form[0].checkValidity()) {
            event.preventDefault();
        }
        form.addClass('was-validated');
    });
});