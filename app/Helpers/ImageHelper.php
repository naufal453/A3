<?php

namespace App\Helpers;

class ImageHelper
{
    public static function profileImageUrl($path)
    {
        return asset(str_replace(' ', '%20', 'storage/'.$path));
    }
}
