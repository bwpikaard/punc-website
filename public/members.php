<!DOCTYPE html>
<?php 
    session_start();
    require_once('../app/members.php'); ?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="/assets/css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css">

        <title>Nano Cooperative</title>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="/">
                <img class="navbar-brand-image" src="/assets/images/logo.png" alt="">
                Nano Cooperative
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/conference">Conference</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="/members">Members</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <?php if ($_SESSION["id"] && $_SESSION["administrator"] == 1) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin" tabindex="-1">Admin</a>
                        </li>
                    <?php } ?>
                    <li class="nav-item">
                        <?php if ($_SESSION["id"]) { ?>
                            <a class="nav-link" href="/logout" tabindex="-1">Logout</a>
                        <?php } else { ?>
                            <a class="nav-link" href="/login" tabindex="-1">Login</a>
                        <?php } ?>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container-fluid members-display">
            <div class="input-group md-form form-sm form-1 pl-0">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-text1"><i class="fas fa-search" aria-hidden="true"></i></span>
                </div>
                <input class="form-control my-0 py-1" type="text" onkeyup="searchMembers()" id="search-members" placeholder="Search by name" aria-label="Search">
            </div>
            <div class="member-list row no-gutters">
                <?php
                    $result = select_members();

                    while($row = $result->fetch_assoc()) { ?>
                        <div class="member col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3" id="member-<?php echo $i; ?>">
                            <div class="member-content">
                                <img src="/assets/images/members/<?php echo $row["image"]; ?>" />
                                <a class="member-field member-name" href="/member?id=<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></a>
                                <a class="member-field member-website" href="<?php echo $row["website"]; ?>"><?php echo $row["website"]; ?></a>
                                <p class="member-field member-institution">
                                    <img class="member-institution-icon" src="/assets/images/institutions/<?php echo $row["institution_image"]; ?>" />
                                    <?php echo $row["institution"]; ?>
                                </p>
                                <p class="member-field member-expertise"><?php echo $row["expertise"]; ?></p>
                                <p class="member-field member-instrumentation"><?php echo $row["instrumentation"]; ?></p>
                            </div>
                        </div>
                    <?php } ?>
            </div>
        </div>
    </body>
</html>

<script>
    function searchMembers() {
        const input = $("#search-members").val().toLowerCase();
        const members = $(".member-list").children();

        members.each(m => {
            $(`.member-list .member#member-${m + 1}`).toggle(
                $(`.member-list .member#member-${m + 1} .member-name`).html().toLowerCase().includes(input)
            );
        });
    }
</script>

<style>
    .member-name {
        color: black;
    }
    .member-name:hover {
        text-decoration: none;
        color: #343a40;
    }
</style>