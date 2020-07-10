<?php

require_once ('./vendor/autoload.php');
require_once ('ILoginService.php');
require_once ('core.php');

use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;

class LoginService implements ILoginService {

    public function validate($jwt) {
        if (!$jwt) return false;
        try {
            global $signer, $key;
            $token = (new Parser())->parse($jwt);
            $time = time();
            $valid = $token->validate(new ValidationData($time));
            $verified = $token->verify($signer, $key);
            return $valid && $verified;
        } catch (Exception $e) {
            return false;
        } 
    }

    public function signIn($user, $password) {
        global $dataUser, $dataPassword, $iss, $aud, $signer, $key;
        if ($user != $dataUser || $password != $dataPassword) return NULL;
        $time = time();
        $token = (new Builder())->issuedBy($iss)
            ->permittedFor($aud)
            ->issuedAt($time)
            ->canOnlyBeUsedAfter($time)
            ->expiresAt($time + 3600)
            ->getToken($signer, $key);

        return $token;        
    }
}