<?php

namespace App\Views;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class Deploy
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $body = $request->getBody();
        $parsedBody = $request->getParsedBody();
        $hash = "sha1=" . hash_hmac("sha1", $body, GITHUB_SECRET);

        if (!$request->hasHeader("X-Hub-Signature") || !hash_equals($hash, $request->getHeaderLine("X-Hub-Signature")))
            return $response->withStatus(403);

        if ($parsedBody["ref"] != "refs/heads/main") {
            $response->getBody()->write("Branch is not being watched.");
            return $response->withStatus(200);
        }

        $result = array();

        exec("cd /var/www/realityrl.com && git reset --hard && git pull", $result);
        
        foreach ($result as $line)
            $response->getBody()->write("$line\n");

        return $response->withStatus(200);
    }
}