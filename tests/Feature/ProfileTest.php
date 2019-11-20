<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guest_cant_update_profile()
    {
        $this->putJson(route('profile'))
            ->assertUnauthorized();
    }

    /** @test */
    public function user_can_update_own_profile()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user, 'api')
            ->putJson(route('profile'), $userData = [
                'name' => $this->faker->name,
                'email' => $this->faker->unique()->safeEmail,
            ])->assertSuccessful()
            ->assertJson($user->toArray());

        $this->assertDatabaseHas('users', $userData);
    }

    /** @test */
    public function name_is_required()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user, 'api')
            ->putJson(route('profile'), [
                'email' => $this->faker->unique()->safeEmail,
            ])->assertJsonValidationErrors('name');
    }

    /** @test */
    public function email_is_required()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user, 'api')
            ->putJson(route('profile'), [
                'name' => $this->faker->name,
            ])->assertJsonValidationErrors('email');
    }

    /** @test */
    public function email_should_be_valid()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user, 'api')
            ->putJson(route('profile'), [
                'email' => 'invalid',
            ])->assertJsonValidationErrors('email');
    }

    /** @test */
    public function email_should_be_unique()
    {
        $user = factory(User::class)->create();
        $existingUser = factory(User::class)->create();

        $this->actingAs($user, 'api')
            ->putJson(route('profile'), [
                'email' => $existingUser->email,
            ])->assertJsonValidationErrors('email');
    }

    /** @test */
    public function email_should_be_unique_except_itself()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user, 'api')
            ->putJson(route('profile'), [
                'name' => $user->name,
                'email' => $user->email,
            ])->assertSuccessful();
    }
}
