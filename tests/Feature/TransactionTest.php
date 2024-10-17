<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Transaction;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_transaction()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/transactions/create', [
            'amount' => 100,
            'currency' => 'BTC',
            'bank_account' => '1234567890',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('transactions', [
            'user_id' => $user->id,
            'amount' => 100,
            'currency' => 'BTC',
            'status' => 'pending',
        ]);
    }

    // Add more tests...
}