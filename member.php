<!DOCTYPE html>
<?php
    session_start();
    require_once('./db.php');

    $id = $_GET["id"];

    if (empty($id)) {
        header("Location: /members");
        exit;
    }

    $query = "SELECT * FROM members WHERE id=$id LIMIT 1";

    $result = mysqli_query($con, $query) or die(mysqli_error());
    $row = mysqli_fetch_array($result);

    if (!$result) {
        echo mysqli_error($con);
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
        <div class="container member-page">
            <div class="member-content">
                <div class="member-information">
                    <img src="/assets/images/members/<?php echo $row["image"]; ?>" />
                    <div class="flex-column">
                        <div class="flex-grow"></div>
                        <p class="member-field member-name"><?php echo $row["name"]; ?></p>
                        <a class="member-website" href="<?php echo $row["website"]; ?>"><?php echo $row["website"]; ?></a>
                        <div class="flex-grow"></div>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="member-institution">
                    <img class="member-institution-icon" src="/assets/images/institutions/<?php echo $row["institution_image"]; ?>" />
                    <div class="flex-column">
                        <div class="flex-grow"></div>
                        <p class="member-institution-name"><?php echo $row["institution"]; ?></p>
                        <p class="member-expertise"><?php echo $row["expertise"]; ?></p>
                        <div class="flex-grow"></div>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="member-content">
                    <p class="title">Biography</p>
                    <p class="member-field member-biography"><?php echo $row["biography"]; ?></p>
                    <br>
                    <p class="title">Instrumentation</p>
                    <p class="member-field member-instrumentation"><?php echo $row["instrumentation"]; ?></p>
                </div>
            </div>
        </div>
    </body>
</html>

<?php mysqli_close($con); ?>
