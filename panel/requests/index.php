<!DOCTYPE html>
<?php
    session_start();
    include("../../auth.php");
    require('../../db.php');

    if ($_SESSION["administrator"] != 1) {
        header("Location: /");
        exit;
    }
?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="/assets/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.js"></script>

        <title>P.U.N.C.</title>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="/">
                <img class="navbar-brand-image" src="/assets/images/logo.png" alt="">
                P.U.N.C.
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
                        <a class="nav-link" href="/conferences">Conferences</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/members">Members</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <?php if ($_SESSION["id"] && $_SESSION["administrator"] == 1) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/panel" tabindex="-1">Admin Panel</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/panel/posts" tabindex="-1">Posts</a>
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
        <div class="container">
            <p class="title">Pending Requests</p>
            <table class="manage">
                <tr>
                    <th style="width: 5%;">ID</th>
                    <th style="width: 40%;">Name</th>
                    <th style="width: 35%;">Institution</th>
                    <th style="width: 20%;">Actions</th>
                </tr>
                <?php
                    $query = "SELECT * FROM requests";
                    $result = mysqli_query($con, $query) or die(mysqli_error());

                    if ($result) {
                        while($row = mysqli_fetch_array($result)) { ?>
                            <tr>
                                <td><?php echo $row["id"]; ?></td>
                                <td><?php echo $row["name"] ?></td>
                                <td><?php echo $row["institution"]; ?></td>
                                <td>
                                    <a class="btn btn-outline-primary btn-sm" href="edit?id=<?php echo $row["id"]; ?>">Edit</a>
                                    <a class="btn btn-outline-primary btn-sm" href="">Delete</a>
                                </td>
                            </tr>
                        <?php }
                    } else {
                        echo "Nope!";
                    }
                ?>
            </table>
        </div>
    </body>
</html>

<style>
    .container .title {
        font-size: 24px;
        font-variant: small-caps;
    }
    .manage {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        color: red;
    }
    .manage tr {
        border: 0;
        color: black;
    }
    .manage td {
        text-align: left;
        padding: 8px;
    }
    .image-preview {
        height: 60px;
    }
    .custom-file {
        width: auto;
    }
    #image-upload input {
        margin: 0 10px;
    }
    #image-upload button {
        margin-left: 10px;
    }
    .divider {
        width: 100%;
        border-bottom: 1px solid #343a40;
        margin: 20px 0;
    }
    body {
        padding-bottom: 20px;
    }
</style>

<?php mysqli_close($con); ?>