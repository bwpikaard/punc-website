<?php

namespace App\Views\Admin\Users;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use \App\Database\Connection;
use \App\Email\Mailer;

final class UserPassword
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        $con = new Connection();
        
        $user = $con->select_where("SELECT email, username, firstname FROM user WHERE id=?", "i", $args["id"])->fetch_assoc();

        if (is_null($user)) return $response->withHeader("Location", "/admin/users");

        $password = bin2hex(openssl_random_pseudo_bytes(4));
        $hpassword = password_hash($password, PASSWORD_DEFAULT);
                
        $con->alter("UPDATE user SET password=?", "s", $hpassword);

        Mailer::send($user["email"], "Password Reset", "{$user["firstname"]},<br><br>A PUNC Administrator has generated a new password for you.<br><br>Username: {$user["username"]}<br>New Password: $password<br><br>Thanks,<br>PUNC Administrators");

        $con->done();
        
        return $response->withHeader("Location", "/admin/users/{$args["id"]}");
    }
}