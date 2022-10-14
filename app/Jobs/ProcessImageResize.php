<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProcessImageResize implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $avatar;
    public $sizes;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($avatar, $sizes)
    {
        $this->avatar = $avatar;
        $this->sizes = $sizes;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!(Storage::disk('minio')->exists($this->avatar->filename))) return;

        $originalImage = Storage::disk('minio')->get($this->avatar->filename);

        foreach ($this->sizes as $sizeName => $param){
            if (Storage::disk('minio')->exists(str_ireplace('original', $sizeName, $this->avatar->filename))){
                continue;
            }
            $sizeFile = Image::make($originalImage)->resize($param['width'], $param['height']);
            Storage::disk('minio')->put(str_ireplace('original', $sizeName, $this->avatar->filename), $originalImage);
            unset($sizeFile);
        }
    }
}
