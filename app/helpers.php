<?php

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

//function getImage($imagePath)
//{
//    if (Storage::disk('s3')->exists($imagePath)) {
//        return Image::make(Storage::disk('s3')->get($imagePath))->response('jpg')
//            ->header('Content-Type', 'image/jpeg');
//    } else
//        return 'No Image';
//}