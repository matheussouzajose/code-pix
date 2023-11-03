<?php

namespace Tests\Feature\Api;

use App\Models\BankAccount;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class BankAccountApiTest extends TestCase
{
    protected string $endpoint = 'api';

    public function test_find_by_id(): void
    {
        $bank = BankAccount::factory()->create();

        $response = $this->getJson("{$this->endpoint}/bank-accounts/$bank->id");

        $response->assertStatus(Response::HTTP_OK);

        $this->assertEquals($response['data']['id'], $bank->id);
        $this->assertEquals($response['data']['number'], $bank->number);
        $this->assertEquals($response['data']['owner_name'], $bank->owner_name);
        $this->assertEquals($response['data']['balance'], $bank->balance);
        $this->assertEquals($response['data']['created_at'], $bank->created_at);
    }

    public function test_paginate(): void
    {
        $bank = BankAccount::factory()->count(20)->create();

        $response = $this->getJson("{$this->endpoint}/bank-accounts");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'meta' => [
                'total',
                'current_page',
                'last_page',
                'first_page',
                'per_page',
                'to',
                'from',
            ],
        ]);
        $response->assertJsonCount(15, 'data');
    }
}
