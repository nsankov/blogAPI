<?php

namespace App\Services;

use App\Models\Avatar;
use App\Models\User;
use \Illuminate\Http\Request;
use App\Events\CreateAvatar;
use App\Events\DeleteAvatar;
use App\Events\UpdateAvatar;
use Illuminate\Support\Facades\Storage;
use App\Jobs\ProcessImageResize;

class AvatarService
{

    const MINIO_ORIGINAL_PATH = 'avatar/original';

    // protected $sizes = ['small' => ['width' => 20, 'height' =>20], 'medium' => ['width' => 50, 'height' =>50], 'large' => ['width' => 120, 'height' =>120]];

    public function __construct(private Avatar $avatar)
    {
      $this->sizes = config('avatar.sizes');
      // code...
    }
    public function uploadToCloud($file, $userId){
      $filename = Storage::disk('minio')->put(self::MINIO_ORIGINAL_PATH, $file);
      $avatar = $this->avatar->create(['filename' => $filename, 'user_id' => $userId]);
      ProcessImageResize::dispatch($avatar, $this->sizes);
      return $avatar;
    }

    public function getByUserId($userId){
      $avatar = $this->avatar->whereUserId($userId)->first();
      foreach (array_keys($this->sizes) as $sizeName){
          $sizes[$sizeName] = str_ireplace('original', $sizeName, $avatar->filename);
      }
      $avatar->sizes =  $sizes;

      return $avatar;
    }

    public function delete(Avatar $avatar){

      foreach ($this->sizes as $sizeName => $param){
          Storage::disk('minio')->delete(str_ireplace('original', $sizeName, $avatar->filename));
        }
      Storage::disk('minio')->delete($avatar->filename);
      $avatar->delete();

    }
}
