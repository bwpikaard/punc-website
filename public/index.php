<?php
    session_start();
    require_once('../handlers/posts.php');
    require_once('../handlers/configuration.php');

    $banner = [
        "title" => "P.U.N.C.",
        "text" => "Primarily Undergraduate Nanomaterials Cooperative",
        "image" => "/assets/images/splash.png"
    ]
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
                        $posts = select_posts();

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