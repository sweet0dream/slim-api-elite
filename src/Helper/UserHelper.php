<?php

namespace App\Helper;

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
}