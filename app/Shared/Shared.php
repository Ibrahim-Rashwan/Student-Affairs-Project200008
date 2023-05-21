<?php

namespace App\Shared;
use Illuminate\Support\Facades\Auth;

class Shared
{

    public const PASS_MARK = 50;

    public const USER_RULES = [
        'email' => 'required',
        'name' => 'required',
        'national_number' => 'required',
        'phone' => 'required',
        'age' => 'required',
        'gender' => 'required'
    ];

    public static function getActiveUserTypedId()
    {
        $user = Auth::getUser();
        $id = $user->id;

        if (isset($user->admin)) {
            $id = $user->admin->id;
        } else if (isset($user->doctor)) {
            $id = $user->doctor->id;
        } else if (isset($user->student)) {
            $id = $user->student->id;
        }

        return $id;
    }

    public static function isAdmin()
    {
        return isset(Auth::user()->admin);
    }

    public static function isDoctor()
    {
        return isset(Auth::user()->doctor);
    }

    public static function isStudent()
    {
        return isset(Auth::user()->student);
    }

    public static function getActiveUserType()
    {
        $user = Auth::getUser();
        $type = "User";

        if (isset($user->admin)) {
            $type = "Admin";
        } else if (isset($user->doctor)) {
            $type = "Doctor";
        } else if (isset($user->student)) {
            $type = "Student";
        }

        return $type;
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
