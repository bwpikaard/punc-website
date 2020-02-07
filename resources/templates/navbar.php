<?php $path = preg_replace('/\?.*/', '', $_SERVER['REQUEST_URI']); ?>
<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="/">
        <img class="navbar-brand-image" src="/assets/images/logo.png" />
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
            <?php if (isset($_SESSION["id"]) && $_SESSION["administrator"] == 1) { ?>
                <li class="nav-item <?php if ($path === "/admin") echo "active"; ?>">
                    <a class="nav-link" href="/admin" tabindex="-1">Admin</a>
                </li>
            <?php } ?>
            <li class="nav-item <?php if ($path === "/login") echo "active"; ?>">
                <?php if (isset($_SESSION["id"])) { ?>
                    <a class="nav-link" href="/logout" tabindex="-1">Logout</a>
                <?php } else { ?>
                    <a class="nav-link" href="/login" tabindex="-1">Login</a>
                <?php } ?>
            </li>
        </ul>
    </div>
</nav>