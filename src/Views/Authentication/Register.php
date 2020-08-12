<?php

namespace App\Views\Authentication;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use \App\Database\Connection;
use \App\Email\Mailer;

final class Register
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $view = Twig::fromRequest($request);

        if ($request->getMethod() == "GET") {
            return $view->render($response, 'auth/register.twig', [
                "user" => isset($_SESSION["user"]) ? $_SESSION["user"] : null,
                "path" => $request->getUri()->getPath()
            ]);
        } else if ($request->getMethod() == "POST") {
            $body = $request->getParsedBody();

            if (empty($body["g-recaptcha-response"]))
                return $view->render($response, 'auth/register.twig', [
                    "user" => isset($_SESSION["user"]) ? $_SESSION["user"] : null,
                    "path" => $request->getUri()->getPath(),
                    "data" => $body,
                    "error" => "Please complete the captcha."
                ]);

            $ip = $_SERVER['REMOTE_ADDR'];
            $captchaResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . RECAPTCHA_KEY . "&response=" . $body["g-recaptcha-response"] . "&remoteip=" . $ip);
            $captchaResponseKeys = json_decode($captchaResponse,true);

            if (intval($captchaResponseKeys["success"]) !== 1)
                return $view->render($response, 'auth/register.twig', [
                    "user" => isset($_SESSION["user"]) ? $_SESSION["user"] : null,
                    "path" => $request->getUri()->getPath(),
                    "data" => $body,
                    "error" => "Please complete the captcha."
                ]);

            $con = new Connection();

            $user = $con->select_where("SELECT * FROM users WHERE username=?", "s", $body["username"])->fetch_assoc();

            if (isset($user))
                return $view->render($response, 'auth/register.twig', [
                    "user" => isset($_SESSION["user"]) ? $_SESSION["user"] : null,
                    "path" => $request->getUri()->getPath(),
                    "data" => $body,
                    "error" => "An account with that username already exists."
                ]);

            $date = date("Y-m-d H:i:s");
            $password = bin2hex(openssl_random_pseudo_bytes(4));
            $hpassword = password_hash($password, PASSWORD_DEFAULT);

            $req = $con->alter("INSERT INTO users (type, status, approved, role_id, username, password, firstname, lastname, email, website, institution, expertise, instrumentation, biography, created) VALUES (0, 0, 0, 1, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '$date')", "ssssssssss", $body["username"], $hpassword, $body["firstname"], $body["lastname"], $body["email"], $body["website"], $body["institution"], $body["expertise"], $body["instrumentation"], $body["biography"]);

            Mailer::send($body["email"], "Membership Request", "{$body["firstname"]},<br><br>Thank you for submitting your membership request with PUNC!<br><br>After your request has been carefully reviewed and accepted, you will be able to use the password below with your account to modify your member page at any time.  This review process may take some time, so we thank you in advance for your patience.  If you are concerned that your request was missed, or you encountered an error in the request process, please email shughes@nanocooperative.org.<br><br>Username: {$body["username"]}<br>Password: $password");
            Mailer::send("shughes@nanocooperative.org", "New Membership Request", "{$body["firstname"]} {$body["lastname"]} submitted a new membership request. <a href=\"https://nanocooperative.org/admin/users/{$req->insert_id}\">View Request</a>");

            $con->done();

            return $response->withHeader("Location", "/?requested");
        }
    }
}