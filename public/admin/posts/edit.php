<!DOCTYPE html>
<?php
    session_start();
    require("../../utilities/auth.php");
    require_once('../../../app/database.php');

    if ($_SESSION["administrator"] != 1) {
        header("Location: /");
        exit;
    }

    if (isset($_GET["id"])) {
        $id = $_GET["id"];

        $query = "SELECT * FROM posts WHERE id=$id LIMIT 1";

        $result = mysqli_query($con, $query) or die(mysqli_error());
        $row = mysqli_fetch_array($result);

        if (!$result) {
            echo mysqli_error($con);
        }
    } else if (isset($_POST["id"])) {
        $id = $_POST["id"];
        $title = mysqli_real_escape_string($con, $_POST["title"]);
        $content = mysqli_real_escape_string($con, $_POST["content"]);
        $modified = date("Y-m-d H:i:s");
        
        $query = "UPDATE posts SET title='$title', content='$content', modified='$modified' WHERE id=$id";

        $result = mysqli_query($con, $query);
                
        if ($result) {
            header("Location: /admin/posts");
        } else {
            echo mysqli_error($con);
        }
    } else {
        header("Location: /admin/posts");
        exit;
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
        <link rel="stylesheet" href="/assets/css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.js"></script>

        <title>Nano Cooperative</title>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="/">
                <img class="navbar-brand-image" src="/assets/images/logo.png" alt="">
                Nano Cooperative
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
                        <a class="nav-link" href="/conference">Conference</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/members">Members</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <?php if ($_SESSION["id"] && $_SESSION["administrator"] == 1) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin" tabindex="-1">Admin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/posts" tabindex="-1">Posts</a>
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
        <div class="container">
            <p class="title">Edit Post</p>
            <form action="/admin/posts/edit" method="post">
                <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                <input class="form-control" name="title" type="text" placeholder="Post Title" id="post-title" value="<?php echo $row["title"]; ?>" required>
                <textarea name="content" id="summernote" required><?php echo $row["content"]; ?></textarea>
                <a class="btn btn-outline-primary btn-sm" href="/admin/posts" id="post-submit">Cancel</a>
                <button type="submit" class="btn btn-outline-primary btn-sm" id="post-submit">Save</button>
            </form>
        </div>
    </body>
</html>

<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            toolbar: [
                ["do", ["undo", "redo"]],
                ["style1", ["fontname", "fontsize", "height", "color"]],
                ["style2", ["bold","italic","underline", "strikethrough", "superscript", "subscript", "clear"]],
                ["style3", ["style", "ol", "ul", "paragraph"]],
                ["insert", ["picture", "link", "video", "table", "hr"]],
                ["misc", ["fullscreen"/*, "codeview"*/]],
                ["help", ["help"]]
            ],
            placeholder: "Write your article here.",
            codeviewFilter: true,
            codeviewIframeFilter: true
        });
    });
</script>

<style>
    .container .title {
        font-size: 24px;
        font-variant: small-caps;
    }
    #post-title {
        margin-bottom: 10px;
    }
    #post-submit {
        margin-top: 10px;
    }
    body {
        padding-bottom: 20px;
    }
</style>

<?php mysqli_close($con); ?>