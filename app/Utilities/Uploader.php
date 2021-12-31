<?php

namespace App\Utilities;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class Uploader  
{

    public static function all(array $images, string $path, string $disk = 'public_storage')
    {
        $returnedPath = [];

        foreach ($images as $name => $image) {

            $fullPath = $path . $name . '_' . $image->getClientOriginalName();
            Storage::disk($disk)->put($fullPath ,File::get($image));

            $returnedPath [$name] = $fullPath;
        }

        return $returnedPath;
    }

    public static function one(array|object $image, string $path, string $disk = 'public_storage')
    {
        Storage::disk($disk)->put($path ,File::get($image));
    }

}