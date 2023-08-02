<?php

namespace Tests\Unit\Entity\User;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PhoneTest extends TestCase
{
    use RefreshDatabase;
   
    public function test_default()
    {
        
        $user = User::factory()->create([
            'phone' => null,
            'phone_verified' => false,
            'phone_verify_token' => null
        ]);

        self::assertFalse($user->isPhoneVerified());
    
    }

    public function test_request_empty_phone() {
        $user = User::factory()->create([
            'phone' => null,
            'phone_verified' => false,
            'phone_verify_token' => null
        ]);

        $this->expectExceptionMessage(__('admin.phoneempty'));
        $user->requestPhoneVerification(Carbon::now());
    }

    public function test_request() {
        $user = User::factory()->create([
            'phone' => '490000000000000',
            'phone_verified' => false,
            'phone_verify_token' => null
        ]);

        $token = $user->requestPhoneVerification(Carbon::now());

        self::assertFalse($user->isPhoneVerified());
        self::assertNotEmpty($token);

    }

    public function test_request_with_old_phone() {

        $user = User::factory()->create([
            'phone' => '490000000000000',
            'phone_verified' => true,
            'phone_verify_token' => null
        ]);

        $user->requestPhoneVerification(Carbon::now());

        self::assertFalse($user->isPhoneVerified());
        self::assertNotEmpty($user->phone_verify_token);

    }

    public function test_request_already_sent_timeout() {
        $user = User::factory()->create([
            'phone' => '490000000000000',
            'phone_verified' => true,
            'phone_verify_token' => null
        ]);

        $user->requestPhoneVerification($now = Carbon::now());
        $user->requestPhoneVerification($now->copy()->addSeconds(500));

        self::assertFalse($user->isPhoneVerified());
    }

    public function test_request_already_sent() {
        
        $user = User::factory()->create([
            'phone' => '490000000000000',
            'phone_verified' => false,
            'phone_verify_token' => null
        ]);

        $user->requestPhoneVerification($now = Carbon::now());

        $this->expectExceptionMessage(__('admin.already'));

        $user->requestPhoneVerification($now->copy()->addSeconds(15));

    }

    public function test_verify() {
        $now =Carbon::now();
        $expire = $now->copy()->addSeconds(User::VERIFY_TIME);
        $now = $now->copy()->addSeconds(15);
        $user = User::factory()->create([
            'phone' => '490000000000000',
            'phone_verified' => false,
            'phone_verify_token' => $token = 'token',
            'phone_verify_token_expiry' => $expire,
        ]);

        self::assertFalse($user->isPhoneVerified());

        $user->verifyToken($token, $now);

        self::assertTrue($user->isPhoneVerified());
    }

    public function test_incorrect_token() {
        $expire = Carbon::now()->copy()->addSeconds(User::VERIFY_TIME);
        $now = Carbon::now()->addSeconds(15);

        $user = User::factory()->create([
            'phone' => '490000000000000',
            'phone_verified' => false,
            'phone_verify_token' => 'token',
            'phone_verify_token_expiry' => $expire,
        ]);

        $this->expectExceptionMessage(__('admin.incorrect_token'));

        $user->verifyToken('incorrect', $now);
    }

    public function test_verify_expired_token() {
        $user = User::factory()->create([
            'phone' => '490000000000000',
            'phone_verified' => false,
            'phone_verify_token' => $token = 'token',
            'phone_verify_token_expiry' => $now =Carbon::now(),
        ]);

        $this->expectExceptionMessage(__('admin.expired_token'));

        $user->verifyToken($token, $now->copy()->addSeconds(1000));

    }

    






}
