<?php

namespace App\Helper;

use DateTimeImmutable;

class UserHelper
{
    public function prepareUser(array $user): array
    {
        return [
            'id' => $user['id'],
            'type' => $user['type'],
            'login' => $user['login'],
            'phone' => $user['phone'],
            'date' => [
                'login' => $user['login_date'],
                'regin' => $user['reg_date']
            ],
            'balance' => $user['balance']
        ];
    }

    public function generateAuthHash(): string
    {
        return sha1(strtotime((new DateTimeImmutable())->format('YmdHis')));
    }

    public function loginUser(array $user): array
    {
       return [
           'id' => $user['id'],
           'type' => $user['type'],
           'login' => $user['login'],
           'hash' => $user['hash']
       ];
    }
}