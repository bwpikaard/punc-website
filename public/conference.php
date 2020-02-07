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
                <div class="col-lg-4">
                    <i class="<?php echo select_configuration("conference-information-1-icon"); ?>"></i>
                    <div class="flex-content">
                        <p class="title"><?php echo select_configuration("conference-information-1"); ?></p>
                        <p class="content"><?php echo select_configuration("conference-information-1-content"); ?></p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <i class="<?php echo select_configuration("conference-information-2-icon"); ?>"></i>
                    <div class="flex-content">
                        <p class="title"><?php echo select_configuration("conference-information-2"); ?></p>
                        <p class="content"><?php echo select_configuration("conference-information-2-content"); ?></p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="flex-content">
                        <img class="photograph" src="/assets/images/content/<?php echo select_configuration("conference-information-3"); ?>" />
                    </div>
                </div>
            </div>
        </div>
        <?php include "../resources/templates/foot.php"; ?>
    </body>
</html>