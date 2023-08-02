<?php

namespace Tests\Feature\Http\Controllers\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;

class RegisterTest extends TestCase
{

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRegisterPage()
    {
        $response = $this->get('/register');

        $response
        ->assertStatus(200)
        ->assertSee('Confirm Password');
    }

    public function testEmptyRegister() {
       
        $response= $this->post('/register', [
            'email' => '',
            'password' => '',
            'password_confirmation' => '',
            'name' => '']);
    
        $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['email', 'password', 'name']);


    }

    public function testSuccess() {

        $user = User::factory()->make([ 
            'status' => User::STATUS_WAIT]);
       
        $response= $this->post('/register', [
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
            'name' => $user->name]);
    
        $response
        ->assertStatus(302)
        ->assertRedirect('/login')
        ->assertSessionHas('success', __('auth.SuccessRegister'));
    }

    public function testIncorrectVerify () {
        $response = $this->get('/verify/'.Str::uuid());
        $response
        ->assertStatus(302)
        ->assertRedirect('/login')
        ->assertSessionHas('error', __('auth.VerifyError'));
    }

    public function testCorrectVerify() {
        $user = User::factory()->create(['status' => User::STATUS_WAIT]);

        $response = $this->get('/verify/'.$user->verify);

        $response
        ->assertStatus(302)
        ->assertSessionHas('success', __('auth.SuccessVerify'));
    }

}
