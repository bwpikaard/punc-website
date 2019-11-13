<?php
    session_start();
    require_once('../handlers/posts.php');
    require_once('../handlers/configuration.php');

    $banner = [
        "title" => "Nano Cooperative",
        "text" => "Upcoming Conference",
        "image" => "/assets/images/roanokecollegecampus.jpg",
        "class" => "conference"
    ]
?>

<!DOCTYPE html>

<html>
    <head>
        <?php include "../resources/templates/head.php"; ?>
        <title>Nano Cooperative</title>
    </head>
    <body>
        <?php include "../resources/templates/navbar.php"; ?>
        <?php include "../resources/templates/banner.php"; ?>
        <div class="container index conference">
            <div class="row information">
                <div>
                    <i class="<?php echo select_configuration("conference-information-1-icon"); ?>"></i>
                    <div class="flex-content">
                        <p class="title"><?php echo select_configuration("conference-information-1"); ?></p>
                        <p class="content"><?php echo select_configuration("conference-information-1-content"); ?></p>
                    </div>
                </div>
            </div>
            <div class="row information">
                <div>
                    <i class="<?php echo select_configuration("conference-information-1-icon"); ?>"></i>
                    <div class="flex-content">
                        <p class="title"><?php echo select_configuration("conference-information-1"); ?></p>
                        <p class="content"><?php echo select_configuration("conference-information-1-content"); ?></p>
                    </div>
                </div>
            </div>
            <div class="row information">
                <div>
                    <i class="<?php echo select_configuration("conference-information-1-icon"); ?>"></i>
                    <div class="flex-content">
                        <p class="title"><?php echo select_configuration("conference-information-1"); ?></p>
                        <p class="content"><?php echo select_configuration("conference-information-1-content"); ?></p>
                    </div>
                </div>
            </div>
            <div class="details">
                <p>Details to come soon!</p>
            </div>
        </div>
    </body>
</html>