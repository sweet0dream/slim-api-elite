<?php

namespace App\Helper;

use DateTimeImmutable;

class UserHelper
{
    public const array FIELD_LOGIN = [
        'login',
        'password'
    ];
    public const array FIELD_REGIN = [
        'login',
        'password',
        'phone',
        'code'
    ];

    public function validateField(array $data, array $validate): ?string
    {
        $validData = array_filter(
            array_diff(
                $validate,
                array_keys($data)
            ),
            fn($v) => in_array($v, $validate)
        );

        if (!empty($validData)) {
            foreach ($validData as $field) {
                return 'Need parameter {' . $field . '}.';
            }
        }

        foreach ($data as $k => $v) {
            if (empty($v) && in_array($k, $validate)) {
                return 'Parameter {' . $k . '} must not empty.';
            }
        }

        return null;
    }

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