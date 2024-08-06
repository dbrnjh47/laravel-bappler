<?php

namespace App\Http\Services;

//composer require intervention/image
// use Image;
use Illuminate\Support\Facades\Storage;

class SaveFileServices
{
    public function convertBytes($bytes)
    {
        $imageData = base64_decode($bytes);

        return $imageData;
    }

    public function saveOne($file, $url, $watermark = false, $is_bytes = false)
    {
        $name = time() . rand(-10000, -100000);
        $type = ($is_bytes ? "jpg" : $file->getClientOriginalExtension());
        $newName = $name . "." . $type;

        $fullPath = public_path() . $url . $newName;

        if(!$is_bytes)
        {
            $file->storeAs($url, $newName, 'public_user');
            // $file->move(public_path() . $url, $newName);
        } else
        {
            $directory = dirname($fullPath);

            if (!is_dir($directory)) {
                mkdir($directory, 0777, true);
            }

            file_put_contents($fullPath, $file);
        }

        //

        // $link = $url.$name.".".$type;
        if ($watermark === true || $watermark === "true") {
            $this->addWatermark($url, $newName);
        }

        return $newName;
    }

    public function resize($path, $imgName, $width, $height, $convertFormat = null)
    {
        $path = $this->path($path);

        $newName = "1-{$width}-{$height}-" . $imgName;
        $img = Image::make($path . $imgName)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });

        if ($convertFormat) {
            $newName = strstr($newName, '.', true);
            $newName = $newName . "." . $convertFormat;
            $img->save($path . $newName, 60, $convertFormat);
        } else {
            $img->save($path . $newName, 60);
        }

        $this->distroy($path, $imgName);
        return $newName;
    }

    public function addWatermark($path, $name)
    {
        $path = $this->path($path);

        $imagePath = $path . $name;
        $watermarkPath = public_path('temple/watermark/header_logo_black.png');

        $image = Image::make($imagePath);
        $watermark = Image::make($watermarkPath);

        // изменить прозрачность вотермарки
        $watermark->opacity(40);

        // вотермарку сделать на ширину и высоту картинки
        $watermark->resize(($image->width() - ($image->width() / 1.2)), ($image->height() - ($image->height() / 1.05)));

        $image->insert($watermark, 'center');

        // Сохраняем измененное изображение
        $image->save($imagePath);
    }

    public function distroy($path, $name)
    {
        $filePath = public_path($this->path($path) . $name);

        if (file_exists($filePath)) {
            unlink($filePath);
        }
        return;
    }

    public function path($path)
    {
        if ($path[0] === "/") {
            $path = substr($path, 1);
        }
        return $path;
    }
}
