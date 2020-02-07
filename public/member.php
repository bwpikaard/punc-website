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
        <?php include "../resources/templates/head.php"; ?>
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
                        <a class="field website" href="<?php echo $member["website"]; ?>">Website</a>
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
                    <p class="title">Background & Research Interests</p>
                    <p class="field"><?php echo $member["biography"]; ?></p>
                    <br>
                    <p class="title">Instrumentation</p>
                    <p class="field"><?php echo $member["instrumentation"]; ?></p>
                </div>
            </div>
        </div>
        <?php include "../resources/templates/foot.php"; ?>
    </body>
</html>