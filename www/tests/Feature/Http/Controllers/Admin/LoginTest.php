<?php

namespace Tests\Feature\Http\Controllers\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLoginPage()
    {
        $response = $this->get('/login');

        $response
        ->assertStatus(200)
        ->assertSee('Forgot Your Password?');
    }

    public function testEmptyLogin() {
       
        $response= $this->post('/login', [
            'email' => '',
            'password' => '']);
    
        $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['email', 'password']);


    }

    public function testWait() {

        $user = User::factory()->create([ 
            'status' => User::STATUS_WAIT]);
       
        $response= $this->post('/login', [
            'email' => $user->email,
            'password' => 'password']);
    
        $response
        ->assertStatus(302)
        ->assertRedirect('/')
        ->assertSessionHas('error', __('auth.NotActive'));


    }

    public function testActive() {

        $user = User::factory()->create([ 
            'status' => User::STATUS_ACTIVE]);
       
        $response= $this->post('/login', [
            'email' => $user->email,
            'password' => 'password']);
    
        $response
        ->assertStatus(302)
        ->assertRedirect('/profil');

        $this->assertAuthenticated();
    }
}
