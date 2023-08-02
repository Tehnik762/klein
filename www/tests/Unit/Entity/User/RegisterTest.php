<?php

namespace Tests\Unit\Entity\User;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase;
use Tests\CreatesApplication;


class RegisterTest extends TestCase
{
    use DatabaseTransactions, CreatesApplication;

    public function testRequest() :void
    {
        $user = User::register(            
                $name = 'test',
                $email = 'test@test.com',
                $password = 'test',            
        );

        self::assertNotEmpty($user);
        
        self::assertEquals($name, $user->name);
        self::assertEquals($email, $user->email);
        
        self::assertNotEquals($password, $user->password);

        self::assertTrue($user->isWait());
        self::assertFalse($user->isActive());
        self::assertFalse($user->isAdmin());
    }

    public function testVerify() :void
    {
        $user = User::register('test','test@test.com','test');
        $user->makeVerified();
        self::assertFalse($user->isWait());
        self::assertTrue($user->isActive());    
    }

}
