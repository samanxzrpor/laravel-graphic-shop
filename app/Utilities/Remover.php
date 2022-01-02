<?php

namespace App\Utilities;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class Remover  
{

    public static function deleteAll(array $files)
    {
        foreach ($files as $file) {
            
            File::deleteDirectory($file);
        }
    }

}