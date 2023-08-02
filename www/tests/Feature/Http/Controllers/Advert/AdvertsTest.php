<?php

namespace Tests\Feature\Http\Controllers\Advert;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdvertsTest extends TestCase
{
    public $user;
    public $admin;

    use RefreshDatabase;

    public function __construct() {

    }
    



    public function testEditAttributes()
    {       
        $this->admin = User::create([
        'name' => "TestAdmin",
        'email' => "test@example.com",
        'status' =>User::STATUS_ACTIVE,
        'role' => User::ROLE_ADMIN
    ]);

        $response = $this->actingAs($this->admin)->get(route('manage.attributes.admin', [1]));

        $response->assertStatus(200);
    }
}
