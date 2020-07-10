<?php

interface ILoginService {
    public function validate($token);
    public function signIn($user, $password);
}