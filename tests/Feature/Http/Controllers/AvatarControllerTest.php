<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Avatar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


/**
 * @see \App\Http\Controllers\AvatarController
 */
class AvatarControllerTest extends ApiTestCase
{
    use RefreshDatabase, WithFaker;

    public function testUpload()
    {
        $this->actingAs($this->users->first());
        Storage::fake('minio');
        $response = $this->post(route('avatar.store'), [
            'avatar' => UploadedFile::fake()->image('avatar.png', 700, 700)
        ]);

        Storage::disk('minio')->assertExists($response['data']['filename']);

        $response->assertCreated();
        $avatars = Avatar::query()
            ->where('user_id', $response['data']['user_id'])
            ->get();
        $this->assertCount(1, $avatars);
    }

    public function testShow()
    {
        $this->actingAs($this->users->first());
        $avatar = Avatar::factory()->create();
        $response = $this->getJson(route('avatar.show',$avatar));
        $response->assertOk();
    }

    public function testDestroy()
    {
        $this->actingAs($this->users->first());
        $avatar = Avatar::factory()->create();
        $response = $this->delete(route('avatar.destroy',  $avatar));
        $response->assertNoContent();
        $this->assertDatabaseMissing(Avatar::class, $avatar->toArray());
    }
}
