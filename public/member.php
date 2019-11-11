<?php
    session_start();
    require_once('../handlers/members.php');
    
    $id = $_GET["id"];

    if (empty($id)) {
        header("Location: /members");
        exit;
    }

    $member = select_member($id)->fetch_assoc();
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
        <div class="container member">
            <div class="content">
                <div class="information">
                    <img src="/assets/images/members/<?php echo $member["image"]; ?>" />
                    <div class="flex-column">
                        <div class="flex-grow"></div>
                        <p class="field name"><?php echo $member["name"]; ?></p>
                        <a class="field website" href="<?php echo $member["website"]; ?>"><?php echo $member["website"]; ?></a>
                        <div class="flex-grow"></div>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="institution">
                    <img class="image" src="/assets/images/institutions/<?php echo $member["institution_image"]; ?>" />
                    <div class="flex-column">
                        <div class="flex-grow"></div>
                        <p class="name"><?php echo $member["institution"]; ?></p>
                        <p class="expertise"><?php echo $member["expertise"]; ?></p>
                        <div class="flex-grow"></div>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="personal-information">
                    <p class="title">Biography</p>
                    <p class="field"><?php echo $member["biography"]; ?></p>
                    <br>
                    <p class="title">Instrumentation</p>
                    <p class="field"><?php echo $member["instrumentation"]; ?></p>
                </div>
            </div>
        </div>
    </body>
</html>