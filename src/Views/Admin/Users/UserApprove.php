<?php

namespace App\Views\Admin\Users;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use \App\Database\Connection;
use \App\Email\Mailer;

final class UserApprove
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        $con = new Connection();
        
        $user = $con->select_where("SELECT firstname,email,approved FROM users WHERE id=?", "i", $args["id"])->fetch_assoc();

        if (empty($user)) return $response->withHeader("Location", "/admin/users");
        if ($user["approved"] != 0) return $response->withHeader("Location", "/admin/users/{$args["id"]}");

        $req = $con->alter("UPDATE users SET approved=1, type=1 WHERE id=?", "i", $args["id"]);

        if ($req->affected_rows > 0) Mailer::send($user["email"], "Membership Request Approved", "{$user["firstname"]},<br><br>Welcome to PUNC!<br><br>Your membership request has been approved, and your account is now active.  You may update your profile at any time by using the username and password you were initially sent.  We look forward to having you as part of the cooperative, and hope this is the first step to many future collaborations with your fellow members.<br><br>Sincerely,<br>Steve Hughes<br><br>shughes@roanoke.edu<br><a href=\"https://nanocooperative.org/members/2\">Steve Hughes</a>");

        $con->done();

        return $response->withHeader("Location", "/admin/users/{$args["id"]}");
    }
}