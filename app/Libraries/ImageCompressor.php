<?php
/*
 * Copyright (c) 2023. Yantodev - All Rights Reserved.
 * @Author  :  yantodev
 * mailto : ekocahyanto007@gmail.com
 * link : https://yantodev.my.id/
 */

namespace App\Libraries;
class ImageCompressor
{
    public function compress($sourcePath, $targetPath, $quality, $fileName)
    {
        $source = $sourcePath . "/" . $fileName;

        $filePath = WRITEPATH . "uploads/$fileName";
        if (file_exists($filePath)) {
            $info = getimagesize($source);
            if ($info['mime'] == 'image/jpeg') {
                $image = imagecreatefromjpeg($sourcePath);
                imagejpeg($image, $targetPath, $quality);
            } elseif ($info['mime'] == 'image/png') {
                $image = imagecreatefrompng($sourcePath);
                imagepng($image, $targetPath, round(9 - $quality / 10));
            }

            imagedestroy($image);
        }
    }

}