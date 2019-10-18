<?php

namespace App\Service;

use League\Flysystem\Filesystem;

class ImageService
{

    const DEST_W = 376;
    const DEST_H = 512;

    /**
     * @var Filesystem
     */
    private $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function store($imageBase64, $resize = false, $shareImageVariation = null)
    {
        $ext = '';
        switch($imageBase64[0]) {
            case 'i':
                $ext = 'png';
                break;
            case 'R':
                $ext = 'gif';
                break;
            case 'U':
                $ext = 'webp';
                break;
            default:
                $ext = 'jpg';
        }
        $name = uniqid() . '-' . time() . '.' . $ext;

        $bin = base64_decode($imageBase64);
        if($resize) {
            $bin = $this->resize($bin);
        }

        $this->filesystem->put('images/' . $name, $bin);

        if(!is_null($shareImageVariation)) {
            $shareBin = $this->generateShareImage($bin, $shareImageVariation);
            $this->filesystem->put('images/sh-' . $name, $shareBin);
        }

        return $name;
    }

    public function resize($bin)
    {
        $cropped = imagecreatetruecolor(376, 512);
        $new = imagecreatetruecolor(512, 512);
        imagefill($cropped, 0, 0, imagecolorallocate($new, 0, 0, 0));
        $image = imagecreatefromstring($bin);
        $size = getimagesizefromstring($bin);

        $wDelta = self::DEST_W / $size[0];
        $hDelta = self::DEST_H / $size[1];
        $useDelta = $wDelta <= $hDelta ? $hDelta : $wDelta;
        $newSize['w'] = $size[0] * $useDelta;
        $newSize['h'] = $size[1] * $useDelta;

        imagecopyresampled(
            $cropped,
            $image,
            (($newSize['w'] - static::DEST_W) / 2) * -1,
            (($newSize['h'] - static::DEST_H) / 2) * -1,
            0,
            0,
            $newSize['w'],
            $newSize['h'],
            $size[0],
            $size[1]
        );
        imagecopyresampled($new, $cropped, 68, 0, 0, 0, 376, 512, 376, 512);
//        header('Content-Type: image/jpeg');
//        imagejpeg($new);
//        imagedestroy($new);
//        exit;
        ob_start();
        imagejpeg($new, null, 90);
        $data = ob_get_contents();
        ob_end_clean();
        imagedestroy($new);
        imagedestroy($cropped);
        if(empty($data)) {
            throw new \Exception('Image could not be resized');
        }
        return $data;
    }

    public function generateShareImage($bin, $type)
    {
        $f = __DIR__.'/../../public/static/image/sharetemplate_'.$type.'.png';
        if(!file_exists($f)) {
            throw new \Exception('Offer variation not found for share image');
        }


        $tpl = imagecreatefrompng($f);
        $face = imagecreatefromstring($bin);
        $tpl_size = getimagesize($f);
        $face_size = getimagesizefromstring($bin);

        $base = imagecreatetruecolor($tpl_size[0], $tpl_size[1]);
        imagefill($base, 0, 0, imagecolorallocate($base, 0, 0, 0));

        $new_face_size = [
            $face_size[0] / 1.33,
            $face_size[1] / 1.33
        ];
        imagecopyresampled(
            $base,
            $face,
            ($tpl_size[0] - $new_face_size[0]) / 2,
            (($tpl_size[1] - $new_face_size[1]) / 2) - 82,
            0,
            0,
            $new_face_size[0],
            $new_face_size[1],
            $face_size[0],
            $face_size[1]
        );

        imagecopyresampled(
            $base,
            $tpl,
            0,
            0,
            0,
            0,
            $tpl_size[0],
            $tpl_size[1],
            $tpl_size[0],
            $tpl_size[1]
        );

//        header('Content-Type: image/jpeg');
//        imagejpeg($base);
//        imagedestroy($base);
//        exit;
        ob_start();
        imagejpeg($base, null, 90);
        $data = ob_get_contents();
        ob_end_clean();
        imagedestroy($base);
        imagedestroy($tpl);
        imagedestroy($face);
        if(empty($data)) {
            throw new \Exception('Image could not be resized');
        }
        return $data;
    }

}