<!DOCTYPE html>
<?php
    session_start();
    include("../utilities/auth.php");
    require('../../app/database.php');

    if ($_SESSION["administrator"] != 1) {
        header("Location: /");
        exit;
    }

    if (isset($_GET["action"])) {
        if ($_GET["action"] === "delete-member") {
            $id = $_GET["id"];

            $query = "DELETE FROM `members` WHERE id=$id";

            $result = mysqli_query($con, $query);
                    
            if ($result) {
                header("Location: /admin");
            } else {
                echo mysqli_error($con);
            }
        } else if ($_GET["action"] === "delete-user") {
            $id = $_GET["id"];

            $query = "DELETE FROM `users` WHERE id=$id";

            $result = mysqli_query($con, $query);
                        
            if ($result) {
               header("Location: /admin");
            } else {
                echo mysqli_error($con);
            }
        }
    } else if (isset($_POST["action"])) {
        if ($_POST["action"] === "add-member") {
            $name = $_POST["name"];
            $image = $_POST["image"];
            $website = $_POST["website"];
            $institution = $_POST["institution"];
            $institution_image = $_POST["institution_image"];
            $expertise = $_POST["expertise"];
            $instrumentation = mysqli_real_escape_string($con, $_POST["instrumentation"]);
            $biography = mysqli_real_escape_string($con, $_POST["biography"]);
            
            $query = "INSERT into members (name, image, website, institution, institution_image, expertise, instrumentation, biography) VALUES ('$name', '$image', '$website', '$institution', '$institution_image', '$expertise', '$instrumentation', '$biography')";

            $result = mysqli_query($con, $query);
                    
            if ($result) {
                header("Location: /admin");
            } else {
                echo mysqli_error($con);
            }
        } else if ($_POST["action"] === "update-member") {
            $id = $_POST["id"];
            $name = $_POST["name"];
            $image = $_POST["image"];
            $website = $_POST["website"];
            $institution = $_POST["institution"];
            $institution_image = $_POST["institution_image"];
            $expertise = $_POST["expertise"];
            $instrumentation = mysqli_real_escape_string($con, $_POST["instrumentation"]);
            $biography = mysqli_real_escape_string($con, $_POST["biography"]);

            $query = "UPDATE members SET name='$name', image='$image', website='$website', institution='$institution', institution_image='$institution_image', expertise='$expertise', instrumentation='$instrumentation', biography='$biography' WHERE id=$id";

            $result = mysqli_query($con, $query);
                    
            if ($result) {
                header("Location: /admin");
            } else {
                echo mysqli_error($con);
            }
        } else if ($_POST["action"] === "add-user") {
            $username = trim($_POST["username"]);
            $email = trim($_POST["email"]);
            $displayname = trim($_POST["displayname"]);
            $password = trim($_POST["password"]);

            if (empty($username)) $username_err = "Please enter a email.";
            else if (empty($password)) $password_err = "Please enter a password.";
            else if (strlen($password) < 6) $password_err = "Password must have at least 6 characters.";

            if (empty($username_err) && empty($password_err)) {
                $username = mysqli_real_escape_string($con, $username);
                $email = mysqli_real_escape_string($con, $email);
                $displayname = mysqli_real_escape_string($con, $displayname);
                $user_stmt = "SELECT * FROM users WHERE username='$username'";
                $user_result = mysqli_query($con, $user_stmt);
                $user = mysqli_fetch_array($user_result);

                if ($user) {
                    $username_err = "An account with that email already exists.";
                } else {
                    $hpassword = mysqli_real_escape_string($con, password_hash($password, PASSWORD_DEFAULT));
                    $created = date("Y-m-d H:i:s");

                    $create_stmt = "INSERT INTO users (username, email, displayname, password, administrator, created) VALUES ('$username', '$email', '$displayname', '$hpassword', '0', '$created')";
                    $create_result = mysqli_query($con, $create_stmt);

                    if ($create_result) {
                        header("Location: /admin");
                    } else {
                        echo mysqli_error($con);
                    }
                }
            }
        } else if ($_POST["action"] === "update-user") {
            $id = $_POST["id"];
            $username = $_POST["username"];
            $email = $_POST["email"];
            $displayname = $_POST["displayname"];
            $password = $_POST["password"];
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $administrator = ($_POST["administrator"] == "on" ? 1 : 0);

            $query = ($password ?
                "UPDATE users SET username='$username', email='$email', displayname='$displayname', password='$hashed_password', administrator='$administrator' WHERE id=$id"
                :
                "UPDATE users SET username='$username', email='$email', displayname='$displayname', administrator='$administrator' WHERE id=$id"
            );

            $result = mysqli_query($con, $query);
                    
            if ($result) {
                header("Location: /admin");
            } else {
                echo mysqli_error($con);
            }
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
                        <li class="nav-item active">
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
            <a class="btn btn-outline-primary btn-sm" href="configuration">Website Configuration</a>
            <div class="divider"></div>
            <p class="title">Users</p>
            <table class="manage">
                <tr>
                    <th style="width: 5%;">ID</th>
                    <th style="width: 20%;">Display Name</th>
                    <th style="width: 15%;">Username</th>
                    <th style="width: 25%;">Email</th>
                    <th style="width: 15%;">Administrator</th>
                    <th style="width: 20%;">Actions</th>
                </tr>
                <?php
                    $query = "SELECT * FROM `users`";
                    $result = mysqli_query($con, $query) or die(mysqli_error());

                    if ($result) {
                        while($row = mysqli_fetch_array($result)) { ?>
                            <tr>
                                <td><?php echo $row["id"]; ?></td>
                                <td><?php echo $row["displayname"]; ?></td>
                                <td><?php echo $row["username"]; ?></td>
                                <td><?php echo $row["email"]; ?></td>
                                <td><?php if ($row["administrator"] == 1) echo "True"; else echo "False"; ?></td>
                                <td>
                                    <a class="btn btn-outline-primary btn-sm" href="#"
                                        data-toggle="modal"
                                        data-target="#addUser"
                                        data-id="<?php echo $row["id"]; ?>"
                                        data-username="<?php echo $row["username"]; ?>"
                                        data-email="<?php echo $row["email"]; ?>"
                                        data-displayname="<?php echo $row["displayname"]; ?>"
                                        data-administrator="<?php echo $row["administrator"]; ?>"
                                    >Edit</a>
                                    <a class="btn btn-outline-primary btn-sm<?php if ($row["administrator"] == 1) echo " disabled"; ?>" href="?action=delete-user&id=<?php echo $row["id"]; ?>">Remove</a>
                                </td>
                            </tr>
                        <?php }
                    } else {
                        echo "Nope!";
                    }
                ?>
            </table>
            <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#addUser">Add User</button>
            <div class="divider"></div>
            <p class="title">Organization Members</p>
            <table class="manage">
                <tr>
                    <th style="width: 20%;">Name</th>
                    <th style="width: 30%;">Institution</th>
                    <th style="width: 30%;">Expertise</th>
                    <th style="width: 20%;">Actions</th>
                </tr>
                <?php
                    $query = "SELECT * FROM members";
                    $result = mysqli_query($con, $query) or die(mysqli_error());

                    if ($result) {
                        while($row = mysqli_fetch_array($result)) { ?>
                            <tr>
                                <td><?php echo $row["name"]; ?></td>
                                <td><?php echo $row["institution"]; ?></td>
                                <td><?php echo $row["expertise"]; ?></td>
                                <td>
                                    <a class="btn btn-outline-primary btn-sm" href="#"
                                        data-toggle="modal"
                                        data-target="#addMember"
                                        data-id="<?php echo $row["id"]; ?>"
                                        data-name="<?php echo $row["name"]; ?>"
                                        data-image="<?php echo $row["image"]; ?>"
                                        data-website="<?php echo $row["website"]; ?>"
                                        data-institution="<?php echo $row["institution"]; ?>"
                                        data-institution_image="<?php echo $row["institution_image"]; ?>"
                                        data-expertise="<?php echo $row["expertise"]; ?>"
                                        data-instrumentation="<?php echo $row["instrumentation"]; ?>"
                                        data-biography="<?php echo $row["biography"]; ?>"
                                    >Edit</a>
                                    <a class="btn btn-outline-primary btn-sm" href="?action=delete-member&id=<?php echo $row["id"]; ?>">Remove</a>
                                </td>
                            </tr>
                        <?php }
                    } else {
                        echo "Nope!";
                    }
                ?>
            </table>
            <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#addMember">Add Member</button>
            <div class="divider"></div>
            <p class="title">Images</p>
            <table class="manage">
                <tr>
                    <th style="width: 5%;"></th>
                    <th style="width: 30%;">Name</th>
                    <th style="width: 65%;">Image</th>
                </tr>
                <?php
                    $files = array_diff(scandir("../assets/images/members", 1), array('..', '.'));

                    foreach ($files as $file) { ?>
                        <tr>
                            <td><a href="images/delete?file_location=members&file_name=<?php echo $file; ?>"><i class="far fa-times-circle"></i></a></td>
                            <td><?php echo $file; ?></td>
                            <td><img class="image-preview" src="/assets/images/members/<?php echo $file; ?>" /></td>
                        </tr>
                    <?php }
                ?>
            </table>
            <form class="form-inline" id="image-upload" action="images/upload" method="post" enctype="multipart/form-data">
                <input type="hidden" name="location" value="members">
                <input class="form-control" name="file-name" type="text" placeholder="File Name" required>
                <div class="custom-file">
                    <input name="file" type="file" class="custom-file-input" id="validatedCustomFile" required>
                    <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                    <div class="invalid-feedback">Example invalid custom file feedback</div>
                </div>
                <button type="submit" class="btn btn-outline-primary btn-sm">Upload Image</button>
            </form>
            <div class="divider"></div>
            <p class="title">Institution Images</p>
            <table class="manage">
                <tr>
                    <th style="width: 5%;"></th>
                    <th style="width: 30%;">Name</th>
                    <th style="width: 65%;">Image</th>
                </tr>
                <?php
                    $files = array_diff(scandir("../assets/images/institutions", 1), array('..', '.'));

                    foreach ($files as $file) { ?>
                        <tr>
                            <td><a href="images/delete?file_location=institutions&file_name=<?php echo $file; ?>"><i class="far fa-times-circle"></i></a></td>
                            <td><?php echo $file; ?></td>
                            <td><img class="image-preview" src="/assets/images/institutions/<?php echo $file; ?>" /></td>
                        </tr>
                    <?php }
                ?>
            </table>
            <form class="form-inline" id="image-upload" action="images/upload" method="post" enctype="multipart/form-data">
                <input type="hidden" name="location" value="institutions">
                <input class="form-control" name="file-name" type="text" placeholder="File Name" required>
                <div class="custom-file">
                    <input name="file" type="file" class="custom-file-input" id="validatedCustomFile" required>
                    <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                    <div class="invalid-feedback">Example invalid custom file feedback</div>
                </div>
                <button type="submit" class="btn btn-outline-primary btn-sm">Upload Image</button>
            </form>
        </div>

        <div class="modal fade" id="addMember" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Member</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form action="/admin/index" method="post">
                            <input id="add-member-action" type="hidden" name="action" value="add-member">
                            <input id="add-member-id" type="hidden" name="id">
                            <div class="form-group">
                                <label class="col-form-label">Name</label>
                                <input name="name" id="add-member-name" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Image Name</label>
                                <input name="image" id="add-member-image" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Website</label>
                                <input name="website" id="add-member-website" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Institution</label>
                                <input name="institution" id="add-member-institution" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Institution Image Name</label>
                                <input name="institution_image" id="add-member-institution-image" type="text" class="form-control">
                            </div>
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
                            <button type="submit" class="btn btn-primary" id="add-member-submit">Add Member</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addUser" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form action="/admin/index" method="post">
                            <input id="add-user-action" type="hidden" name="action" value="add-user">
                            <input id="add-user-id" type="hidden" name="id">
                            <div class="form-group">
                                <label class="col-form-label">Username</label>
                                <input name="username" id="add-user-username" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Email</label>
                                <input name="email" id="add-user-email" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Display Name</label>
                                <input name="displayname" id="add-user-displayname" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Password</label>
                                <input name="password" id="add-user-password" type="text" class="form-control">
                            </div>
                            <div class="custom-control custom-switch">
                                <input name="administrator" type="checkbox" class="custom-control-input" id="add-user-administrator" disabled>
                                <label class="custom-control-label" for="add-user-administrator">Administrator</label>
                            </div>
                            <br>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="add-user-submit">Add User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<script>
    $('#addMember').on('shown.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const id = button.data("id");
        const name = button.data("name");
        const image = button.data("image");
        const website = button.data("website");
        const institution = button.data("institution");
        const institution_image = button.data("institution_image");
        const expertise = button.data("expertise");
        const instrumentation = button.data("instrumentation");
        const biography = button.data("biography");

        const modal = $(this);
        modal.find("#add-member-id").val(id);
        modal.find("#add-member-name").val(name);
        modal.find("#add-member-image").val(image);
        modal.find("#add-member-website").val(website);
        modal.find("#add-member-institution").val(institution);
        modal.find("#add-member-institution-image").val(institution_image);
        modal.find("#add-member-expertise").val(expertise);
        modal.find("#add-member-instrumentation").val(instrumentation);
        modal.find("#add-member-biography").val(biography);
        modal.find("#add-member-action").val(name ? "update-member" : "add-member");
        modal.find("#add-member-submit").html(name ? "Update Member" : "Add Member");
    })
    $('#addUser').on('shown.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const id = button.data("id");
        const username = button.data("username");
        const email = button.data("email");
        const displayname = button.data("displayname");
        const administrator = button.data("administrator") === 1;

        const modal = $(this);
        modal.find("#add-user-id").val(id);
        modal.find("#add-user-username").val(username);
        modal.find("#add-user-email").val(email);
        modal.find("#add-user-displayname").val(displayname);
        modal.find("#add-user-administrator").prop("checked", administrator);
        modal.find("#add-user-administrator").prop("disabled", !username);
        modal.find("#add-user-action").val(username ? "update-user" : "add-user");
        modal.find("#add-user-submit").html(username ? "Update User" : "Add User");
    })
</script>

<style>
    .container .title {
        font-size: 24px;
        font-variant: small-caps;
    }
    .manage {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        color: black;
    }
    .manage tr {
        border: 0;
        color: black;
    }
    .manage td {
        text-align: left;
        padding: 8px;
    }
    .image-preview {
        height: 60px;
    }
    .custom-file {
        width: auto;
    }
    #image-upload input {
        margin: 0 10px;
    }
    #image-upload button {
        margin-left: 10px;
    }
    .divider {
        width: 100%;
        border-bottom: 1px solid #343a40;
        margin: 20px 0;
    }
    body {
        padding-bottom: 20px;
    }
</style>

<?php mysqli_close($con); ?>