<?php
    session_start();
    require_once('../handlers/members.php');
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta property="og:type" content="website">
        <meta property="og:url" content="https://nanocooperative.com">
        <meta property="og:title" content="Nano Cooperative">
        <meta property="og:description" content="Primarily Undergraduate Nanomaterials Cooperative (PUNK)">
        <meta property="og:site_name" content="Nano Cooperative">
        <meta property="og:image" content="https://nanocooperative.com/assets/images/icon.png">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link href="/assets/images/icon.png" rel="icon" type="image/x-icon">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.css" rel="stylesheet">
        <link rel="stylesheet" href="/assets/css/style.css">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.js"></script>
        <script src="/assets/js/index.js"></script>
        <title>Nano Cooperative</title>
    </head>
    <body>
        <?php include "../resources/templates/navbar.php"; ?>
        <div class="container-fluid members">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-text1">
                        <i class="fas fa-search" aria-hidden="true"></i>
                    </span>
                </div>
                <input class="form-control" type="text" onkeyup="searchMembers()" id="search-members" placeholder="Search by Name">
            </div>
            <div class="row no-gutters list">
                <?php
                    $result = select_members();
                    $i = 1;

                    while($row = $result->fetch_assoc()) { ?>
                        <div class="member col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3" id="member-<?php echo $i; ?>">
                            <div class="information">
                                <img src="/assets/images/members/<?php echo $row["image"]; ?>" />
                                <a class="field name" href="/member?id=<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></a>
                                <a class="field website" href="<?php echo $row["website"]; ?>"><?php echo $row["website"]; ?></a>
                                <p class="field institution">
                                    <img class="field institution-image" src="/assets/images/institutions/<?php echo $row["institution_image"]; ?>" />
                                    <?php echo $row["institution"]; ?>
                                </p>
                                <p class="field expertise"><?php echo $row["expertise"]; ?></p>
                                <p class="field instrumentation"><?php echo $row["instrumentation"]; ?></p>
                            </div>
                        </div>
                    <?php $i++; } ?>
            </div>
        </div>
    </body>
</html>