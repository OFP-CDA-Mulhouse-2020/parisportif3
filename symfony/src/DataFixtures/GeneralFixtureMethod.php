<?php

namespace App\DataFixtures;

final class GeneralFixtureMethod
{
    private function __construct()
    {
    }

    public static function randomString(int $length = 10): string
    {
        return substr(
            str_shuffle(
                str_repeat(
                    $x = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
                    (int)ceil($length / strlen($x))
                )
            ),
            1,
            $length
        );
    }
}
