<?php

namespace App\Entity;

class User
{
    public $login;
    public $id;

    public static function create(array $data)
    {
        $user = new self();

        $user->id = $data['id'];
        $user->login = $data['login'];

        return $user;
    }
}
