<?php

namespace Tests\Feature\Subscription;

use App\Plan;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResumeSubscriptionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_resume_canceled_subscription()
    {
        $user = factory(User::class)->create();

        $user->createAsStripeCustomer();

        $paymentMethod = $user->updateDefaultPaymentMethod('pm_card_visa');

        $user->newSubscription(Plan::first()->id)->create($paymentMethod->id);

        $subscription = $user->fresh()->subscription()->cancel();

        $this->assertTrue($subscription->onGracePeriod());

        $this->actingAs($user, 'api')
            ->postJson(route('resume-subscription.store'))
            ->assertSuccessful();

        $subscription = $user->fresh()->subscription();

        $this->assertFalse($subscription->onGracePeriod());
        $this->assertTrue($subscription->active());
    }
}
