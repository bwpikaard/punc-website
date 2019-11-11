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
    $(".needs-validation").submit(event => {
        if (!event.target.checkValidity()) event.preventDefault();
        
        $(event.target).addClass('was-validated');
    });
});