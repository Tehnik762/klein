<?php

namespace Tests\Feature\Http\Controllers\Profil;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdvertsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test index page for User without phone
     *
     * @return void
     */
    public function testUserWithoutPhone()
    {
        $user = User::factory()->create([
            'phone' => '',
            'phone_verified' => false,
            'phone_verify_token' => null,
            'phone_verify_token_expiry' => null,
      ]);
 
        $response = $this->actingAs($user)
                         ->get('/profil/personal/adverts');


        $response->assertStatus(302)
        ->assertRedirect('/profil')
        ->assertSessionHas('error', __('admin.erroradverts'));
    }

    public function testUserWithPhone() {
        $user = User::factory()->create([
            'phone' => '123123',
            'phone_verified' => true,
      ]);
 
        $response = $this->actingAs($user)
                         ->get('/profil/personal/adverts');
        $response->assertStatus(200)
        ->assertSee("Adverts");
    }
}
