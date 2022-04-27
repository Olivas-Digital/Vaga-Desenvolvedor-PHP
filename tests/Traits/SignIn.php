<?php

namespace Tests\Traits;

use App\Models\User;

trait SignIn
{
    /**
     * Create a user and sign in as that user. If a user object is passed, then sign in as that user.
     *
     * @param User|null $user
     * @return User|null
     */
    public function signIn(User $user = null): ?User
    {
        if (is_null($user)) {
            $user = User::factory()->create();
        }

        $this->actingAs($user);

        return $user;
    }
}
