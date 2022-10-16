<?php
namespace App\Infrastructure\Filesystem;

use Illuminate\Support\Facades\Storage;

class AvatarStorage {

    const MINIO_ORIGINAL_PATH = 'avatar/original';

    public function upload($file){
        return Storage::disk('minio')->put(self::MINIO_ORIGINAL_PATH, $file);
    }

    public function download($filename){
        return Storage::disk('minio')->get($filepath);
    }

    public function delete($filename){
        return Storage::disk('minio')->delete($filename);
    }
}
