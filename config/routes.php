<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteCollectorProxy;
use Slim\App;

return function (App $app) {
    $app->map(["POST"], "/deploy", \App\Views\Deploy::class);
    
    $app->map(["GET"], "/", \App\Views\Home::class)
        ->setName("home");

    $app->map(["GET"], "/me[/]", \App\Views\Me::class)
        ->setName("me");

    $app->map(["POST"], "/me[/]", \App\Views\MeManage::class)
        ->setName("me");

    $app->map(["POST"], "/me/image[/]", \App\Views\MeImage::class)
        ->setName("me.image");

    $app->map(["GET"], "/members[/]", \App\Views\Members\Members::class)
        ->setName("members");

    $app->map(["GET"], "/members/{id}[/]", \App\Views\Members\Member::class)
        ->setName("member");

    $app->map(["GET"], "/conference[/]", \App\Views\Conference::class)
        ->setName("conference");

    $app->group("/auth", function (RouteCollectorProxy $group) {
        $group->map(["GET", "POST"], "/login", \App\Views\Authentication\Login::class)
            ->setName("auth.login");

        $group->map(["GET", "POST"], "/register", \App\Views\Authentication\Register::class)
            ->setName("auth.register");

        $group->map(["GET"], "/logout", \App\Views\Authentication\Logout::class)
            ->setName("auth.logout");

        $group->map(["GET", "POST"], "/reset", \App\Views\Authentication\EmailReset::class)
            ->setName("auth.reset");
    });

    $app->group("/admin", function (RouteCollectorProxy $group) {
        $group->redirect("[/]", "/admin/users", 301);

        $group->group("/posts", function (RouteCollectorProxy $group2) {
            $group2->map(["GET"], "[/]", \App\Views\Admin\Posts\Posts::class)
                ->setName("admin.posts");

            $group2->map(["GET"], "/{id}[/]", \App\Views\Admin\Posts\Post::class)
                ->setName("admin.posts.post");

            $group2->map(["POST"], "/{id}[/]", \App\Views\Admin\Posts\PostManage::class)
                ->setName("admin.posts.post.manage");

            $group2->map(["GET"], "/{id}/publish", \App\Views\Admin\Posts\PostTogglePublish::class)
                ->setName("admin.posts.post.togglepublish");

            $group2->map(["GET"], "/{id}/delete[/]", \App\Views\Admin\Posts\PostDelete::class)
                ->setName("admin.posts.post.delete");
        });

        $group->map(["GET"], "/configuration[/]", \App\Views\Admin\Configuration::class)
            ->setName("admin.configuration");

        $group->group("/users", function (RouteCollectorProxy $group2) {
            $group2->map(["GET"], "[/]", \App\Views\Admin\Users\Users::class)
                ->setName("admin.users");

            $group2->map(["GET"], "/{id}[/]", \App\Views\Admin\Users\User::class)
                ->setName("admin.users.user");

            $group2->map(["POST"], "/{id}[/]", \App\Views\Admin\Users\UserManage::class)
                ->setName("admin.users.user");

            $group2->map(["POST"], "/{id}/image[/]", \App\Views\Admin\Users\UserImage::class)
                ->setName("admin.users.user.image");

            $group2->map(["GET"], "/{id}/approve[/]", \App\Views\Admin\Users\UserApprove::class)
                ->setName("admin.users.user.approve");

            $group2->map(["GET"], "/{id}/delete[/]", \App\Views\Admin\Users\UserDelete::class)
                ->setName("admin.users.user.delete");
        });
    })->add(new \App\Authentication\Admin());
};
