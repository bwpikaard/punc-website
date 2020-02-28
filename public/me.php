<?php
    session_start();
    require_once('../handlers/accounts.php');
    require_once("../handlers/authorization.php");

    not_logged();
    
    $id = $_GET["id"];
    $logged_id = $_SESSION["id"];

    $admin = is_administrator();

    if (!isset($id)) {
        $id = $logged_id;
    } else if ($id !== $logged_id && !$admin) {
        header("Location: /?access-denied");
    }

    $user = select_account_by_id($id)->fetch_assoc();
?>

<!DOCTYPE html>

<html>
    <head>
        <?php include "../resources/templates/head.php"; ?>
        <title>Nano Cooperative</title>
    </head>
    <body>
        <?php include "../resources/templates/navbar.php"; ?>
        <div class="container profile">
            <div class="content">
                <button class="atn atn-sm mb-3 disabled" data-toggle="modal" data-target="#update-password">Update Password</button>
                <form class="needs-validation" action="/utilities/accounts" method="post" enctype="multipart/form-data" novalidate>
                    <input name="id" type="hidden" value="<?php echo $user["id"]; ?>">
                    <?php if ($admin) { ?>
                        <input name="update-admin" type="hidden">
                        <div class="form-group">
                            <label>Type</label>
                            <select name="type">
                                <option <?php if ($user["type"] == 0) echo "selected" ?> value="0">Regular Account</option>
                                <option <?php if ($user["type"] == 1) echo "selected" ?> value="1">Listed Member</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Active</label>
                            <select name="active">
                                <option <?php if ($user["active"] == 0) echo "selected" ?> value="0">Disabled</option>
                                <option <?php if ($user["active"] == 1) echo "selected" ?> value="1">Enabled</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Permission Level</label>
                            <select name="administrator">
                                <option <?php if ($user["administrator"] == 0) echo "selected" ?> value="0">User</option>
                                <option <?php if ($user["administrator"] == 1) echo "selected" ?> value="1">Administrator</option>
                            </select>
                        </div>
                    <?php } else {?>
                        <input name="update" type="hidden">
                    <?php } ?>
                    <div class="form-group">
                        <label>Username</label>
                        <input name="username" type="text" class="form-control" value="<?php echo $user["username"]; ?>" <?php if (!$admin) echo "readonly='readonly'"; ?> required>
                        <div class="invalid-feedback">
                            Please enter a value.
                        </div>
                    </div>
                    <div class="form-group">
                        <label>First Name</label>
                        <input name="firstname" type="text" class="form-control" value="<?php echo $user["firstname"]; ?>" required>
                        <div class="invalid-feedback">
                            Please enter a value.
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input name="lastname" type="text" class="form-control" value="<?php echo $user["lastname"]; ?>" required>
                        <div class="invalid-feedback">
                            Please enter a value.
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input name="email" type="text" class="form-control" value="<?php echo $user["email"]; ?>" required>
                        <div class="invalid-feedback">
                            Please enter a value.
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Website URL</label>
                        <input name="website" type="text" class="form-control" value="<?php echo $user["website"]; ?>">
                        <div class="invalid-feedback">
                            Please enter a value.
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Institution</label>
                        <input name="institution" type="text" class="form-control" value="<?php echo $user["institution"]; ?>">
                        <div class="invalid-feedback">
                            Please enter a value.
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Expertise</label>
                        <textarea name="expertise" class="form-control"><?php echo $user["expertise"]; ?></textarea>
                        <div class="invalid-feedback">
                            Please enter a value.
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Institution's Instrumentation</label>
                        <textarea name="instrumentation" class="form-control"><?php echo $user["instrumentation"]; ?></textarea>
                        <div class="invalid-feedback">
                            Please enter a value.
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Background & Research Interests</label>
                        <textarea name="biography" class="form-control"><?php echo $user["biography"]; ?></textarea>
                        <div class="invalid-feedback">
                            Please enter a value.
                        </div>
                    </div>
                    <button type="submit" class="atn" id="submit">Update Information</button>
                </form>
            </div>
        </div>
        <?php include "../resources/templates/foot.php"; ?>
        <div class="modal fade" id="update-password" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update <?php echo $user["firstname"]; ?>'s Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form class="needs-validation" action="/utilities/configuration" method="post" novalidate>
                            <input name="update-password" type="hidden">
                            <input name="id" type="hidden" id="id">
                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input name="password" type="password" class="form-control" id="password" required>
                                <div class="invalid-feedback">
                                    Please enter a password.
                                </div>
                            </div>
                            <br>
                            <button type="button" class="atn atn-light" data-dismiss="modal">Close</button>
                            <button type="submit" class="atn" id="submit">Update Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>