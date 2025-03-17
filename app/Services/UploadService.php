<?php

namespace App\Services;

class UploadService
{
    public function upload($file)
    {
        $fileName = $file->getClientOriginalName();
        $file->storeAs('public', $fileName);
        return $fileName;
    }

    public function getFile($fileName)
    {
        $path = asset('storage/' . $fileName);

        return [
            'name' => $fileName,
            'path' => $path
        ];
    }
}
