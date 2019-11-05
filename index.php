<!DOCTYPE html>
<?php
    session_start();
    require('./db.php');
    require('./configuration.php');

    function getAuthor($id) {
        global $con;

        $query = "SELECT * FROM users WHERE `id`='$id'";

        $result = mysqli_query($con, $query);
        $value = mysqli_fetch_array($result);
        
        if ($result) {
            return $value;
        } else {
            echo mysqli_error($con);
        }
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
                    <li class="nav-item active">
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
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="carousel-text-container">
                        <p class="carousel-text">P.U.N.C.<span>Primarily Undergraduate Nanomaterials Cooperative</span></p>
                    </div>
                    <img src="/assets/images/roanokecollegecampus.jpg" class="d-block w-100" alt="...">
                </div>
            </div>
        </div>
        <div class="container-fluid home">
            <div class="row">
                <div class="col-lg-4 information">
                    <i class="<?php echo getConfiguration("index-information-1-icon"); ?>"></i>
                    <div class="content-container">
                        <p class="title"><?php echo getConfiguration("index-information-1"); ?></p>
                        <p class="content"><?php echo getConfiguration("index-information-1-content"); ?></p>
                    </div>
                </div>
                <div class="col-lg-4 information">
                    <i class="<?php echo getConfiguration("index-information-2-icon"); ?>"></i>
                    <div class="content-container">
                        <p class="title"><?php echo getConfiguration("index-information-2"); ?></p>
                        <p class="content"><?php echo getConfiguration("index-information-2-content"); ?></p>
                    </div>
                </div>
                <div class="col-lg-4 information">
                    <i class="<?php echo getConfiguration("index-information-3-icon"); ?>"></i>
                    <div class="content-container">
                        <p class="title"><?php echo getConfiguration("index-information-3"); ?></p>
                        <p class="content"><?php echo getConfiguration("index-information-3-content"); ?></p>
                    </div>
                </div>
            </div>
            <br><br>
            <div class="row justify-content-center">
                <div class="col-lg-5 information">
                    <div class="content-container text-center">
                        <p class="title" style="font-size: 24px;">Becoming a Member</p>
                        <p class="content">Fill out the form below to request membership. It will be submitted to the organization managers and you will be notified when a decision is made.</p>
                        <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#membership-request" style="margin-top: 10px;">Request Membership</button>
                    </div>
                </div>
            </div>
            <div class="divider"></div>
            <div class="posts-container">
                <p class="title">Recent Posts</p>
                <br>
                <div class="posts">
                    <?php
                        $query = "SELECT * FROM posts WHERE published='1'";
                        $result = mysqli_query($con, $query) or die(mysqli_error());

                        if ($result) {
                            while($row = mysqli_fetch_array($result)) { ?>
                                <div class="post">
                                    <h2 class="title"><?php echo $row["title"]; ?></h2>
                                    <p class="author">By <?php echo getAuthor($row["author"])["displayname"]; ?> on <?php echo $row["created"]; ?></p>
                                    <div class="content"><?php echo $row["content"]; ?></div>
                                </div>
                            <?php }
                        } else {
                            echo "Nope!";
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="modal fade" id="membership-request" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Request Membership</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form action="/index.php" method="post">
                        <p class="note">Please have an image of yourself and your institution's logo ready upon request. File must be a png or jpg.</p>
                            <div class="form-group">
                                <label class="col-form-label">Full Name</label>
                                <input name="name" id="add-member-name" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Contact Email</label>
                                <input name="name" id="add-member-email" type="text" class="form-control">
                            </div>
                            <!--<div class="form-group">
                                <label class="col-form-label">Image Name</label>
                                <input name="image" id="add-member-image" type="text" class="form-control">
                            </div>-->
                            <div class="form-group">
                                <label class="col-form-label">Website</label>
                                <input name="website" id="add-member-website" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Institution</label>
                                <input name="institution" id="add-member-institution" type="text" class="form-control">
                            </div>
                            <!--<div class="form-group">
                                <label class="col-form-label">Institution Image Name</label>
                                <input name="institution_image" id="add-member-institution-image" type="text" class="form-control">
                            </div>-->
                            <div class="form-group">
                                <label class="col-form-label">Expertise</label>
                                <input name="expertise" id="add-member-expertise" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Instrumentation</label>
                                <textarea name="instrumentation" id="add-member-instrumentation" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Biography</label>
                                <textarea name="biography" id="add-member-biography" class="form-control"></textarea>
                            </div>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="add-member-submit">Send Request</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<style>
    .posts-container > .title {
        font-size: 24px;
        font-variant: small-caps;
        margin: 0;
    }
    .recent-posts {
        font-size: 24px;
    }
    .posts-container .posts .post {
        padding: 10px 20px;
        border-left: 4px solid #343a40;
        margin: 10px 0;
    }
    .posts-container .posts .post .title {
        font-weight: bold;
    }
    .posts-container .posts .post .author {
        font-style: italic;
    }
    .posts-container .posts .post .content {
        
    }
</style>

<?php mysqli_close($con); ?>