<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();
    require_once("../handlers/authorization.php");
    require_once('../handlers/users.php');
    require_once('../handlers/members.php');
    require_once('../handlers/posts.php');
    require_once('../handlers/configuration.php');

    not_administrator();
?>

<!DOCTYPE html>

<html>
    <head>
        <?php include "../resources/templates/head.php"; ?>
        <title>Nano Cooperative</title>
    </head>
    <body>
        <?php include "../resources/templates/navbar.php"; ?>
        <div class="container-fluid admin">
            <ul class="nav nav-pills" id="myTab" role="tablist">
                <li class="nav-item"><a class="nav-link btn active" data-toggle="tab" href="#users" role="tab" aria-controls="home" aria-selected="true">Users</a></li>
                <li class="nav-item"><a class="nav-link btn" data-toggle="tab" href="#members" role="tab" aria-controls="profile" aria-selected="false">Members</a></li>
                <li class="nav-item"><a class="nav-link btn" data-toggle="tab" href="#images" role="tab" aria-controls="profile" aria-selected="false">Images</a></li>
                <li class="nav-item"><a class="nav-link btn" data-toggle="tab" href="#posts" role="tab" aria-controls="profile" aria-selected="false">Posts</a></li>
                <li class="nav-item"><a class="nav-link btn" data-toggle="tab" href="#configuration" role="tab" aria-controls="contact" aria-selected="false">Configuration</a></li>
            </ul>
            <div class="container tab-content">
                <div class="tab-pane fade show active table-responsive-md" id="users">
                    <p class="title">Users</p>
                    <table class="table table-borderless table-hover">
                        <tr>
                            <th style="width: 5%;">ID</th>
                            <th style="width: 20%;">Display Name</th>
                            <th style="width: 15%;">Username</th>
                            <th style="width: 25%;">Email</th>
                            <th style="width: 15%;">Administrator</th>
                            <th style="width: 20%;">Actions</th>
                        </tr>
                        <?php
                            $result = select_users();

                            while($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $row["id"]; ?></td>
                                    <td><?php echo $row["displayname"]; ?></td>
                                    <td><?php echo $row["username"]; ?></td>
                                    <td><?php echo $row["email"]; ?></td>
                                    <td><?php if ($row["administrator"] == 1) echo "True"; else echo "False"; ?></td>
                                    <td>
                                        <a class="btn btn-sm action" href="#"
                                            data-toggle="modal"
                                            data-target="#register-user"
                                            data-id="<?php echo $row["id"]; ?>"
                                            data-username="<?php echo $row["username"]; ?>"
                                            data-email="<?php echo $row["email"]; ?>"
                                            data-displayname="<?php echo $row["displayname"]; ?>"
                                            data-administrator="<?php echo $row["administrator"]; ?>"
                                        >Edit</a>
                                        <a class="btn btn-sm action<?php if ($row["administrator"] == 1) echo " disabled"; ?>" href="/utilities/users?delete&id=<?php echo $row["id"]; ?>">Remove</a>
                                    </td>
                                </tr>
                            <?php } ?>
                    </table>
                    <button type="button" class="btn btn-sm action" data-toggle="modal" data-target="#register-user">Add User</button>
                </div>
                <div class="tab-pane fade table-responsive-md" id="members">
                    <p class="title">Organization Members</p>
                    <table class="table table-borderless table-hover">
                        <tr>
                            <th style="width: 30%;">Name</th>
                            <th style="width: 30%;">Institution</th>
                            <th style="width: 20%;">Approved</th>
                            <th style="width: 20%;">Actions</th>
                        </tr>
                        <?php
                            $result = select_members(false);

                            while($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $row["name"]; ?></td>
                                    <td><?php echo $row["institution"]; ?></td>
                                    <td><?php if ($row["approved"] == 1) echo "True"; else echo "False"; ?></td>
                                    <td>
                                        <a class="btn btn-sm action" href="#"
                                            data-toggle="modal"
                                            data-target="#register-member"
                                            data-id="<?php echo $row["id"]; ?>"
                                            data-name="<?php echo $row["name"]; ?>"
                                            data-image-name="<?php echo $row["image"]; ?>"
                                            data-website="<?php echo $row["website"]; ?>"
                                            data-institution="<?php echo $row["institution"]; ?>"
                                            data-institution-image-name="<?php echo $row["institution_image"]; ?>"
                                            data-expertise="<?php echo $row["expertise"]; ?>"
                                            data-instrumentation="<?php echo $row["instrumentation"]; ?>"
                                            data-biography="<?php echo $row["biography"]; ?>"
                                            data-approved="<?php echo $row["approved"]; ?>"
                                        >Edit</a>
                                        <a class="btn btn-sm action" href="/utilities/members?delete&id=<?php echo $row["id"]; ?>">Remove</a>
                                    </td>
                                </tr>
                            <?php } ?>
                    </table>
                    <button type="button" class="btn btn-sm action" data-toggle="modal" data-target="#register-member">Add Member</button>
                </div>
                <div class="tab-pane fade table-responsive-md" id="images">
                    <p class="title">Images</p>
                    <table class="table table-borderless table-hover">
                        <tr>
                            <th style="width: 5%;"></th>
                            <th style="width: 30%;">Name</th>
                            <th style="width: 65%;">Image</th>
                        </tr>
                        <?php
                            $files = array_diff(scandir("./assets/images/members", 1), array('..', '.'));

                            foreach ($files as $file) { ?>
                                <tr>
                                    <td><a href="/utilities/images?delete&file_location=members&file_name=<?php echo $file; ?>"><i class="far fa-times-circle"></i></a></td>
                                    <td><?php echo $file; ?></td>
                                    <td><img class="image-preview" src="/assets/images/members/<?php echo $file; ?>" /></td>
                                </tr>
                            <?php }
                        ?>
                    </table>
                    <form class="form-inline" id="image-upload" action="/utilities/images" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="location" value="members">
                        <input class="form-control" name="file-name" type="text" placeholder="File Name" required>
                        <div class="custom-file">
                            <input name="file" type="file" class="custom-file-input" id="validatedCustomFile" required>
                            <label class="custom-file-label">Choose file...</label>
                            <div class="invalid-feedback">Example invalid custom file feedback</div>
                        </div>
                        <button type="submit" class="btn btn-sm action">Upload Image</button>
                    </form>
                    <div class="divider"></div>
                    <p class="title">Institution Images</p>
                    <table class="table table-borderless table-hover">
                        <tr>
                            <th style="width: 5%;"></th>
                            <th style="width: 30%;">Name</th>
                            <th style="width: 65%;">Image</th>
                        </tr>
                        <?php
                            $files = array_diff(scandir("./assets/images/institutions", 1), array('..', '.'));

                            foreach ($files as $file) { ?>
                                <tr>
                                    <td><a href="/utilities/images?delete&file_location=institutions&file_name=<?php echo $file; ?>"><i class="far fa-times-circle"></i></a></td>
                                    <td><?php echo $file; ?></td>
                                    <td><img class="image-preview" src="/assets/images/institutions/<?php echo $file; ?>" /></td>
                                </tr>
                            <?php }
                        ?>
                    </table>
                    <form class="form-inline" id="image-upload" action="/utilities/images" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="location" value="institutions">
                        <input class="form-control" name="file-name" type="text" placeholder="File Name" required>
                        <div class="custom-file">
                            <input name="file" type="file" class="custom-file-input" id="validatedCustomFile" required>
                            <label class="custom-file-label">Choose file...</label>
                            <div class="invalid-feedback">Example invalid custom file feedback</div>
                        </div>
                        <button type="submit" class="btn btn-sm action">Upload Image</button>
                    </form>
                </div>
                <div class="tab-pane fade table-responsive-md" id="posts">
                    <p class="title">Existing Posts</p>
                    <table class="table table-borderless table-hover manage">
                        <tr>
                            <th style="width: 5%;">ID</th>
                            <th style="width: 10%;">Published</th>
                            <th style="width: 40%;">Title</th>
                            <th style="width: 25%;">Author</th>
                            <th style="width: 20%;">Actions</th>
                        </tr>
                        <?php
                            $result = select_posts(false);

                            while($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $row["id"]; ?></td>
                                    <td><?php if ($row["published"] == 1) echo "True"; else echo "False"; ?></td>
                                    <td><?php echo $row["title"]; ?></td>
                                    <td><?php echo select_author($row["author"])["displayname"]; ?></td>
                                    <td>
                                        <a class="btn btn-sm action" href="edit?id=<?php echo $row["id"]; ?>">Edit</a>
                                        <?php if ($row["published"] == 1) { ?>
                                            <a class="btn btn-sm action" href="/utilities/posts?id=<?php echo $row["id"]; ?>&unpublish" href="#">Unpublish</a>
                                        <?php } else { ?>
                                            <a class="btn btn-sm action" href="/utilities/posts?id=<?php echo $row["id"]; ?>&publish" href="#">Publish</a>
                                        <?php } ?>
                                        <a class="btn btn-sm action" href="/utilities/posts?id=<?php echo $row["id"]; ?>&delete">Delete</a>
                                    </td>
                                </tr>
                            <?php } ?>
                    </table>
                    <div class="divider"></div>
                    <p class="title">Compose a Draft</p>
                    <form action="/utilities/posts" method="post">
                        <input name="register" type="hidden">
                        <input class="form-control" name="title" type="text" placeholder="Post Title" id="post-title" required>
                        <textarea name="content" id="summernote" required></textarea>
                        <button type="submit" class="btn btn-sm action" id="post-submit">Create</button>
                    </form>
                </div>
                <div class="tab-pane fade table-responsive-md" id="configuration">
                    <p class="title">Website Configuration</p>
                    <table class="table table-borderless table-hover manage">
                        <tr>
                            <th style="width: 20%;">Key</th>
                            <th style="width: 60%;">Value</th>
                            <th style="width: 20%;">Actions</th>
                        </tr>
                        <?php
                            $result = select_configurations();

                            while($row = mysqli_fetch_array($result)) { ?>
                                <tr>
                                    <td><?php echo $row["key"]; ?></td>
                                    <td><?php echo $row["value"] ?></td>
                                    <td>
                                        <a class="btn btn-sm action" href="#"
                                            data-toggle="modal"
                                            data-target="#register-configuration"
                                            data-key="<?php echo $row["key"]; ?>"
                                            data-value="<?php echo $row["value"]; ?>"
                                        >Edit</a>
                                        <a class="btn btn-sm action" href="/utilities/configuration?delete&key=<?php echo $row["key"]; ?>">Delete</a>
                                    </td>
                                </tr>
                            <?php } ?>
                    </table>
                    <button type="button" class="btn btn-sm action" data-toggle="modal" data-target="#register-configuration">Add Configuration</button>
                </div>
            </div>
        </div>
        <div class="modal fade" id="register-member" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Member Management</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form class="needs-validation" action="/utilities/members" method="post" novalidate>
                            <input name="action" type="hidden" id="action">
                            <input name="id" type="hidden" id="id">
                            <div class="form-group">
                                <label>Name</label>
                                <input name="name" type="text" class="form-control" id="name" placeholder="Name" required>
                                <div class="invalid-feedback">
                                    Please enter a value.
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Image Name</label>
                                <input name="image-name" type="text" class="form-control" id="image-name" placeholder="Image Name" required>
                                <div class="invalid-feedback">
                                    Please enter a value.
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Website</label>
                                <input name="website" type="text" class="form-control" id="website" placeholder="Website" required>
                                <div class="invalid-feedback">
                                    Please enter a value.
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Institution</label>
                                <input name="institution" type="text" class="form-control" id="institution" placeholder="Institution" required>
                                <div class="invalid-feedback">
                                    Please enter a value.
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Institution Image Name</label>
                                <input name="institution-image-name" type="text" class="form-control" id="institution-image-name" placeholder="Institution Image Name" required>
                                <div class="invalid-feedback">
                                    Please enter a value.
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Expertise</label>
                                <input name="expertise" type="text" class="form-control" id="expertise" placeholder="Expertise" required>
                                <div class="invalid-feedback">
                                    Please enter a value.
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Instrumentation</label>
                                <textarea name="instrumentation" class="form-control" id="instrumentation" placeholder="Instrumentation" required></textarea>
                                <div class="invalid-feedback">
                                    Please enter a value.
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Biography</label>
                                <textarea name="biography" class="form-control" id="biography" placeholder="Biography" required></textarea>
                                <div class="invalid-feedback">
                                    Please enter a value.
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input name="approved" type="checkbox" class="custom-control-input" id="approved">
                                    <label class="custom-control-label" for="approved">Approved</label>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn action" id="submit">Add Member</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="register-user" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">User Management</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form class="needs-validation" action="/utilities/users" method="post" novalidate>
                            <input name="callback" type="hidden" value="/admin#users">
                            <input name="register" type="hidden" id="action">
                            <input name="id" type="hidden" id="id">
                            <div class="form-group">
                                <label>Username</label>
                                <input name="username" type="text" class="form-control" id="username" placeholder="Username" required>
                                <div class="invalid-feedback">
                                    Please enter a username.
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Display Name</label>
                                <input name="displayname" type="text" class="form-control" id="displayname" placeholder="Display Name" required>
                                <div class="invalid-feedback">
                                    Please enter a display name.
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input name="email" type="email" class="form-control" id="email" placeholder="Email" required>
                                <div class="invalid-feedback">
                                    Please enter a valid email.
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input name="password" type="password" class="form-control" id="password" minlength="6" maxlength="20" placeholder="Password">
                                <small id="passwordHelpBlock" class="form-text text-muted">Your password must be between 6 and 20 characters.</small>
                                <div class="invalid-feedback">
                                    Please enter your password.
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input name="administrator" type="checkbox" class="custom-control-input" id="administrator">
                                    <label class="custom-control-label" for="administrator">Administrator</label>
                                </div>
                            </div>
                            <br>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn action" id="submit">Add User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="register-configuration" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Configuration Management</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form class="needs-validation" action="/utilities/configuration" method="post" novalidate>
                            <input name="action" type="hidden" id="action">
                            <input name="id" type="hidden" id="id">
                            <div class="form-group">
                                <label>Key</label>
                                <input name="key" type="text" class="form-control" id="key" placeholder="Key" required>
                                <div class="invalid-feedback">
                                    Please enter a value.
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Value</label>
                                <textarea name="value" class="form-control" id="value" placeholder="Value" required></textarea>
                                <div class="invalid-feedback">
                                    Please enter a value.
                                </div>
                            </div>
                            <br>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn action" id="submit">Add Configuration</button>
                        </form>
                    </div>
                </div>
            </div>
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
                ["misc", ["fullscreen"]],
                ["help", ["help"]]
            ],
            placeholder: "Write your article here.",
            codeviewFilter: true,
            codeviewIframeFilter: true
        });

        var hash = window.location.hash;
        hash && $('ul.nav a[href="' + hash + '"]').tab('show');

        $('.nav-pills a').click(function (e) {
            $(this).tab('show');
            var scrollmem = $('body').scrollTop();
            window.location.hash = this.hash;
            $('html,body').scrollTop(scrollmem);
        });
    });

    $('#register-member').on('shown.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const id = button.data("id");
        const name = button.data("name");
        const image = button.data("image-name");
        const website = button.data("website");
        const institution = button.data("institution");
        const institution_image = button.data("institution-image-name");
        const expertise = button.data("expertise");
        const instrumentation = button.data("instrumentation");
        const biography = button.data("biography");
        const approved = button.data("approved");

        const modal = $(this);
        modal.find("#id").val(id);
        modal.find("#name").val(name);
        modal.find("#image-name").val(image);
        modal.find("#website").val(website);
        modal.find("#institution").val(institution);
        modal.find("#institution-image-name").val(institution_image);
        modal.find("#expertise").val(expertise);
        modal.find("#instrumentation").val(instrumentation);
        modal.find("#biography").val(biography);
        modal.find("#approved").prop("checked", approved);
        modal.find("#action").attr("name", name ? "update" : "register");
        modal.find("#submit").html(name ? "Update Member" : "Add Member");
    })

    $('#register-user').on('shown.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const id = button.data("id");
        const username = button.data("username");
        const email = button.data("email");
        const displayname = button.data("displayname");
        const administrator = button.data("administrator") === 1;

        const modal = $(this);
        modal.find("#id").val(id);
        modal.find("#username").val(username);
        modal.find("#email").val(email);
        modal.find("#displayname").val(displayname);
        modal.find("#administrator").prop("checked", administrator);
        modal.find("#administrator").prop("disabled", !username);
        modal.find("#action").attr("name", username ? "update" : "register");
        modal.find("#submit").html(username ? "Update User" : "Add User");
    })

    $('#register-configuration').on('shown.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const key = button.data("key");
        const value = button.data("value");

        const modal = $(this);
        modal.find("#id").val(key);
        modal.find("#key").val(key);
        modal.find("#value").val(value);
        modal.find("#action").attr("name", key ? "update" : "register");
        modal.find("#submit").html(key ? "Update Configuration" : "Add Configuration");
    })
</script>