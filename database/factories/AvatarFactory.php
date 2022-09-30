<?php

namespace Database\Factories;

//use App\Models\Avatar;
//use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AvatarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $tempName = tempnam(sys_get_temp_dir(), 'response').'.jpg';
        Http::sink($tempName)->retry(3, 100)->get("https://loremflickr.com/640/480/abstract");
        $filename = Storage::putFile('/public/avatars', $tempName);
        return [
//            'user_id' => User::orderByRaw('RAND()')->whereNotIn('id', Avatar::all('id'))->first()->id,
            'filename' => $filename
        ];
    }
}
