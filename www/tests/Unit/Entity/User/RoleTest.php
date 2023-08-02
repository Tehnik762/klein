<?php

namespace Tests\Unit\Entity\User;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase;
use Tests\CreatesApplication;

class RoleTest extends TestCase
{
    use DatabaseTransactions, CreatesApplication;

   public function testChange() {

        $user = User::factory()->create();
        self::assertFalse($user->isAdmin());
        $user->changeRole(User::ROLE_ADMIN);
        self::assertTrue($user->isAdmin());
        $user->changeRole(User::ROLE_MODERATOR);
        self::assertTrue($user->isModerator());
   }

   public function testFakedRole() {
        $this->expectException(\InvalidArgumentException::class);
        $user = User::factory()->create();       
        $user->changeRole(127);
   }
}
