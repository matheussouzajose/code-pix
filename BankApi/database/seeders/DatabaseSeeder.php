<?php

namespace Database\Seeders;

use App\Models\BankAccount;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        BankAccount::factory()->create([
            'id' => '6e4635ce-88d1-4e58-9597-d13fc446ee47',
            'number' => '1111',
            'owner_name' => 'User BBX 1',
        ]);

        BankAccount::factory()->create([
            'id' => '51a720b2-5144-4d7f-921d-57023b1e24c1',
            'number' => '2222',
            'owner_name' => 'User BBX 2',
        ]);
    }
}
