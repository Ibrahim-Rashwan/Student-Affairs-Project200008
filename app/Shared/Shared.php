<?php

namespace App\Shared;

class Shared
{

    const NAVBAR_INDEX_KEY = 'navbarIndex';
    const NAVBAR_POSTS_INDEX = 1;

    const SIDEBAR_INDEX_KEY = 'sidebarIndex';
    const NAVBAR_MEDIA_INDEX = 2;

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
