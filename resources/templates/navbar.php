<?php
    require_once("../app/authorization.php");

    $path = preg_replace('/\?.*/', '', $_SERVER['REQUEST_URI']);
?>
<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="/">
        <!--<img class="navbar-brand-image" src="/assets/images/logo.png" />-->
        Nano Cooperative
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item <?php if ($path === "/") echo "active"; ?>">
                <a class="nav-link" href="/">Home</a>
            </li>
            <li class="nav-item <?php if ($path === "/conference") echo "active"; ?>">
                <a class="nav-link" href="/conference">Conference</a>
            </li>
            <li class="nav-item <?php if ($path === "/members") echo "active"; ?>">
                <a class="nav-link" href="/members">Members</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <?php if (has_session()) { ?>
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle <?php if ($path === "/user") echo "active"; ?>" href="#" data-toggle="dropdown"><?php echo $_SESSION["user"]["firstname"]; ?></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item dropdown-tab" data-tab="users" href="/me">My Profile</a>
                        <div class="dropdown-divider"></div>
                        <?php if (admin_panel()) { ?>
                            <a class="dropdown-item dropdown-tab" data-tab="users" href="/admin">Admin Panel</a>
                        <?php } ?>
                        <a class="dropdown-item" href="/logout">Logout</a>
                    </div>
                </div>
            <?php } else { ?>
                <li class="nav-item <?php if ($path === "/login") echo "active"; ?>">
                    <a class="nav-link" href="/login" tabindex="-1">Login</a>
                </li>
            <?php } ?>
        </ul>
    </div>
</nav>