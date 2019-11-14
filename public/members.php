<?php
    session_start();
    require_once('../handlers/members.php');
?>

<!DOCTYPE html>

<html>
    <head>
        <?php include "../resources/templates/head.php"; ?>
        <title>Nano Cooperative</title>
    </head>
    <body>
        <?php include "../resources/templates/navbar.php"; ?>
        <div class="container-fluid members">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-text1">
                        <i class="fas fa-search" aria-hidden="true"></i>
                    </span>
                </div>
                <input class="form-control" type="text" onkeyup="searchMembers()" id="search-members" placeholder="Search by Name">
            </div>
            <div class="row no-gutters list">
                <?php
                    $result = select_members(true);
                    $i = 1;

                    while($row = $result->fetch_assoc()) { ?>
                        <div class="member col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3" id="member-<?php echo $i; ?>">
                            <div class="information">
                                <img src="/assets/images/members/<?php echo $row["image"]; ?>" />
                                <a class="field name" href="/member?id=<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></a>
                                <a class="field website" href="<?php echo $row["website"]; ?>">Website</a>
                                <p class="field institution">
                                    <img class="field institution-image" src="/assets/images/institutions/<?php echo $row["institution_image"]; ?>" />
                                    <?php echo $row["institution"]; ?>
                                </p>
                                <p class="field expertise"><?php echo $row["expertise"]; ?></p>
                                <p class="field instrumentation"><?php echo $row["instrumentation"]; ?></p>
                            </div>
                        </div>
                    <?php $i++; } ?>
            </div>
        </div>
    </body>
</html>