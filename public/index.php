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
                        <button type="button" class="atn" data-toggle="modal" data-target="#request-membership" style="margin-top: 10px;">Request Membership</button>
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
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="modal fade" id="request-membership" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Request Membership</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <p>Please review one of our current member’s pages for an example of content for the following fields. <a id="title" href="/member?id=1" target="_blank">Steve Hughes</a></p>
                        <form class="needs-validation" action="/utilities/members" method="post" enctype="multipart/form-data" novalidate>
                            <input name="request" type="hidden">
                            <div class="form-group">
                                <label>Name</label>
                                <input name="name" type="text" class="form-control" required>
                                <div class="invalid-feedback">
                                    Please enter a value.
                                </div>
                            </div>
                            <div class="custom-file">
                                <input name="image" type="file" class="form-control-file custom-file-input">
                                <label class="custom-file-label">Image of Yourself (PNG or JPG)</label>
                                <div class="invalid-feedback">
                                    Please choose a file.
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Contact Email</label>
                                <input name="email" type="email" class="form-control" required>
                                <div class="invalid-feedback">
                                    Please enter a valid email.
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Website</label>
                                <input name="website" type="text" class="form-control" required>
                                <div class="invalid-feedback">
                                    Please enter a value.
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Institution</label>
                                <br>
                                <input name="institution" type="text" class="form-control" required>
                                <div class="invalid-feedback">
                                    Please enter a value.
                                </div>
                            </div>
                            <div class="custom-file">
                                <input name="institution-image" type="file" class="form-control-file custom-file-input">
                                <label class="custom-file-label">Your Institution's Logo (PNG or JPG)</label>
                                <div class="invalid-feedback">
                                    Please choose a file.
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Expertise</label>
                                <input name="expertise" type="text" class="form-control" required>
                                <small class="form-text text-muted">Please keep it short.</small>
                                <div class="invalid-feedback">
                                    Please enter a value.
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Institution's Instrumentation</label>
                                <textarea name="instrumentation" class="form-control" required></textarea>
                                <div class="invalid-feedback">
                                    Please enter a value.
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Background & Research Interests</label>
                                <textarea name="biography" class="form-control" required></textarea>
                                <div class="invalid-feedback">
                                    Please enter a value.
                                </div>
                            </div>
                            <small class="form-text text-muted">All of the above information will be publicly displayed on acceptance.</small>
                            <button type="button" class="atn atn-light" data-dismiss="modal">Close</button>
                            <button type="submit" class="atn action" id="submit">Request Membership</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="request-membership-success" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Request Membership</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <p>Your request has been sumitted. You will be notified when a decision is made.
                    </div>
                </div>
            </div>
        </div>
        <?php include "../resources/templates/foot.php"; ?>
    </body>
</html>

<?php if (isset($_GET["success"])) echo '
<script>
    $(document).ready(function() {
        $("#request-membership-success").modal("show");
    })
</script>
'; ?>