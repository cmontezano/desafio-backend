<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Shopkeeper;
use App\Models\User;
use Cassandra\Custom;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_customer_with_enough_balance_can_send_money_to_shopkeeper()
    {
        $customer = Customer::factory()->create();
        $customer->user()->save(User::factory()->make(['balance' => $balance = 100]));

        $shopkeeper = Shopkeeper::factory()->create();
        $shopkeeper->user()->save(User::factory()->make());

        $response = $this->post(route('transactions.store'), $payload = [
            'payer_id' => $customer->user->id,
            'payee_id' => $shopkeeper->user->id,
            'amount' => $balance,
        ]);

        $response->assertStatus(201)->assertJson($payload);
        $this->assertDatabaseHas('transactions', $payload);
    }

    public function test_customer_with_enough_balance_can_send_money_to_another_customer()
    {
        $payer = Customer::factory()->create();
        $payer->user()->save(User::factory()->make(['balance' => $balance = 100]));

        $payee = Shopkeeper::factory()->create();
        $payee->user()->save(User::factory()->make(['balance' => 0]));

        $response = $this->post(route('transactions.store'), $payload = [
            'payer_id' => $payer->user->id,
            'payee_id' => $payee->user->id,
            'amount' => $balance,
        ]);

        $response->assertStatus(201)->assertJson($payload);
        $this->assertDatabaseHas('transactions', $payload);
        $this->assertDatabaseHas('users', [
            'id' => $payer->user->id,
            'balance' => 0,
        ]);
        $this->assertDatabaseHas('users', [
            'id' => $payee->user->id,
            'balance' => 100,
        ]);
    }

    public function test_customer_without_enough_balance_cannot_transfer_money()
    {
        $customer = Customer::factory()->create();
        $customer->user()->save(User::factory()->make(['balance' => 100]));

        $shopkeeper = Shopkeeper::factory()->create();
        $shopkeeper->user()->save(User::factory()->make());

        $response = $this->post(route('transactions.store'), $payload = [
            'payer_id' => $customer->user->id,
            'payee_id' => $shopkeeper->user->id,
            'amount' => 200,
        ]);

        $response->assertStatus(422)
            ->assertSeeText('User does not have enough balance.');
    }

    public function test_shopkeeper_cannot_send_money_to_anyone()
    {
        $customer = Customer::factory()->create();
        $customer->user()->save(User::factory()->make());

        $shopkeeper = Shopkeeper::factory()->create();
        $shopkeeper->user()->save(User::factory()->make(['balance' => 100]));

        $response = $this->post(route('transactions.store'), $payload = [
            'payer_id' => $shopkeeper->user->id,
            'payee_id' => $shopkeeper->user->id,
            'amount' => 100,
        ]);

        $response->assertStatus(422)
            ->assertSeeText('Only customers can send money.');
    }
}
