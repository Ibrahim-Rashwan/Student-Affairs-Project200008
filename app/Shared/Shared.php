<?php

namespace App\Shared;

class Shared
{

    public const USER_RULES = [
        'email' => 'required',
        'password' => 'required',
        'name' => 'required',
        'national_number' => 'required',
        'phone' => 'required',
        'age' => 'required',
        'gender' => 'required'
    ];

    public static function getActiveUserId()
    {
        return 17;
    }

    public static function getDisplayName(string $filename)
    {
        $index = strpos($filename, '_');
        return substr($filename, $index+1);
    }

    public static function replaceBaseName(string $oldFilename, string $basename)
    {
        $index = strpos($oldFilename, '_');
        $prefix = substr($oldFilename, 0, $index+1);

        return $prefix . $basename . Shared::getExtension($oldFilename);
    }

    public static function getBaseName(string $filename)
    {
        return pathinfo($filename, PATHINFO_FILENAME);
    }

    public static function getExtension(string $filename)
    {
        return '.' . pathinfo($filename, PATHINFO_EXTENSION);
    }

}
