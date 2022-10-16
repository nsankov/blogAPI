<?php

namespace App\Services;

use App\Models\Avatar;
use App\Models\User;
use \Illuminate\Http\Request;
use App\Events\UploadAvatar;

use App\Infrastructure\Filesystem\AvatarStorage;

class AvatarService
{

    public function __construct(public Avatar $avatar, public AvatarStorage $storage)
    {
      $this->sizes = config('avatar.sizes');
    }

    public function uploadToCloud($file, $userId){
      $filename = $this->storage->upload($file);
      $avatar = $this->avatar->create(['filename' => $filename, 'user_id' => $userId]);
      event(new UploadAvatar($avatar));
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
          $this->storage->delete(str_ireplace('original', $sizeName, $avatar->filename));
        }
      $this->storage->delete($avatar->filename);
      $avatar->delete();
    }
}
