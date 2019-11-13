<?php
    session_start();
    require_once('../handlers/posts.php');
    require_once('../handlers/configuration.php');

    $banner = [
        "title" => "P.U.N.C.",
        "text" => "Primarily Undergraduate Nanomaterials Cooperative",
        "image" => "/assets/images/splash.png",
        "class" => "index"
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
        <div class="container index">
            <div class="row information">
                <div class="col-lg-4">
                    <i class="<?php echo select_configuration("index-information-1-icon"); ?>"></i>
                    <div class="flex-content">
                        <p class="title"><?php echo select_configuration("index-information-1"); ?></p>
                        <p class="content"><?php echo select_configuration("index-information-1-content"); ?></p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <i class="<?php echo select_configuration("index-information-2-icon"); ?>"></i>
                    <div class="flex-content">
                        <p class="title"><?php echo select_configuration("index-information-2"); ?></p>
                        <p class="content"><?php echo select_configuration("index-information-2-content"); ?></p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <i class="<?php echo select_configuration("index-information-3-icon"); ?>"></i>
                    <div class="flex-content">
                        <p class="title"><?php echo select_configuration("index-information-3"); ?></p>
                        <p class="content"><?php echo select_configuration("index-information-3-content"); ?></p>
                    </div>
                </div>
            </div>
            <br><br>
            <div class="row information justify-content-center">
                <div class="col-lg-5">
                    <div class="flex-content center">
                        <p class="title" style="font-size: 24px;">Becoming a Member</p>
                        <p class="content">Fill out the form below to request membership. It will be submitted to the organization managers and you will be notified when a decision is made.</p>
                        <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#membership-request" style="margin-top: 10px;">Request Membership</button>
                    </div>
                </div>
            </div>
            <div class="divider"></div>
            <div class="posts">
                <p class="title">Recent Posts</p>
                <br>
                <div class="frame">
                    <?php
                        $posts = select_posts(true);

                        while($row = $posts->fetch_assoc()) {
                    ?>
                                <div class="post">
                                    <h2 class="title"><?php echo $row["title"]; ?></h2>
                                    <p class="author">By <?php echo select_author($row["author"])["displayname"]; ?> on <?php echo $row["created"]; ?></p>
                                    <div class="content"><?php echo $row["content"]; ?></div>
                                </div>
                        <?php } ?>
                </div>
            </div>
        </div>
    </body>
</html>