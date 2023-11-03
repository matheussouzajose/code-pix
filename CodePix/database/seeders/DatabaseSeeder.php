<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Account;
use App\Models\Bank;
use App\Models\PixKey;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $bbx = Bank::factory()->create([
            'name' => 'BBX',
            'code' => '001'
        ]);

        $cter = Bank::factory()->create([
            'name' => 'CTER',
            'code' => '002'
        ]);

        $account = Account::factory()->create([
            'id' => '6e4635ce-88d1-4e58-9597-d13fc446ee47',
            'owner_name' => 'User BBX 1',
            'number' => '1111',
            'bank_id' => $bbx->id
        ]);

        PixKey::factory()->create([
            'account_id' => $account->id,
            'kind' => 'email',
            'key' => 'user.bbx.1@mail.com',
        ]);

        Account::factory()->create([
            'id' => '51a720b2-5144-4d7f-921d-57023b1e24c1',
            'owner_name' => 'User BBX 2',
            'number' => '2222',
            'bank_id' => $bbx->id
        ]);

        Account::factory()->create([
            'id' => '103cc632-78e7-4476-ab63-d5ad3a562d26',
            'owner_name' => 'User CTER 1',
            'number' => '3333',
            'bank_id' => $cter->id
        ]);

        Account::factory()->create([
            'id' => '463b1b2a-b5fa-4b88-9c31-e5c894a20ae3',
            'owner_name' => 'User CTER 2',
            'number' => '4444',
            'bank_id' => $cter->id
        ]);
    }
}
