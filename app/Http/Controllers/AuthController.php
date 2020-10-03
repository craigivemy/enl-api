<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Psr\Http\Message\ServerRequestInterface;

class AuthController extends AccessTokenController
{
    public function auth(ServerRequestInterface $request)
    {
        $tokenResponse = parent::issueToken($request);
        $token = $tokenResponse->getContent();

        // $tokenInfo will contain the usual Laravel Passort token response.
        $tokenInfo = json_decode($token, true);

        // Then we just add the user to the response before returning it.
        $username = $request->getParsedBody()['username'];
        $user = User::whereEmail($username)->first();
        $tokenInfo = collect($tokenInfo);
        $tokenInfo->put('current_user', $user);

        return $tokenInfo;
    }
}
