<?php

namespace Tests\Integration\Infrastructure\Persistence\Eloquent\Repository;

use App\Models\BankAccount as BankAccountModel;
use App\Models\PixKey as PixKeyModel;
use App\Models\Transaction as TransactionModel;
use Core\Domain\BankAccount\Repository\BankAccountRepositoryInterface;
use Core\Domain\PixKey\Entity\PixKey;
use Core\Domain\PixKey\Enum\PixKeyKind;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Shared\Repository\PaginationInterface;
use Core\Domain\Transaction\Entity\Transaction;
use Core\Infrastructure\Exceptions\NotFoundException;
use Core\Infrastructure\Persistence\Eloquent\Factories\BankAccountFactory;
use Core\Infrastructure\Persistence\Eloquent\Factories\PixKeyFactory;
use Core\Infrastructure\Persistence\Eloquent\Repository\BankAccountRepositoryDb;
use Tests\TestCase;

class BankAccountRepositoryTest extends TestCase
{
    protected BankAccountRepositoryInterface $bankAccountRepository;

    protected function setUp(): void
    {
        $this->bankAccountRepository = new BankAccountRepositoryDb(
            bankAccountModel: new BankAccountModel(),
            pixKeyModel: new PixKeyModel()
        );

        parent::setUp();
    }

    /**
     * @throws NotificationException
     * @throws NotFoundException
     */
    public function test_throws_error_find_by_id()
    {
        $this->expectExceptionObject(NotFoundException::itemNotFound(''));

        $this->bankAccountRepository->findById('');
    }

    /**
     * @throws NotificationException
     * @throws NotFoundException
     */
    public function test_find_by_id()
    {
        $bankAccount = BankAccountModel::factory()->create();

        $result = $this->bankAccountRepository->findById($bankAccount->id);

        $this->assertEquals($bankAccount->id, $result->id());
        $this->assertEquals($bankAccount->number, $result->number);
        $this->assertEquals($bankAccount->owner_name, $result->ownerName);
        $this->assertEquals($bankAccount->balance, $result->balance);
        $this->assertEquals($bankAccount->created_at, $result->createdAt());
    }

    public function test_empty_paginate()
    {
        $result = $this->bankAccountRepository->paginate();

        $this->assertInstanceOf(PaginationInterface::class, $result);
        $this->assertCount(0, $result->items());
    }

    public function test_paginate()
    {
        BankAccountModel::factory()->count(20)->create();

        $result = $this->bankAccountRepository->paginate();

        $this->assertInstanceOf(PaginationInterface::class, $result);
        $this->assertCount(15, $result->items());
    }

    /**
     * @throws NotFoundException
     */
    public function test_empty_paginate_pix_key()
    {
        $bankAccount = BankAccountModel::factory()->create();

        $result = $this->bankAccountRepository->paginatePixKey(bankAccountId: $bankAccount->id);

        $this->assertInstanceOf(PaginationInterface::class, $result);
        $this->assertCount(0, $result->items());
    }

    /**
     * @throws NotFoundException
     */
    public function test_paginate_pix_key()
    {
        $bankAccount = BankAccountModel::factory()->create();
        PixKeyModel::factory()->count(15)->create([
            'bank_account_id' => $bankAccount->id,
        ]);

        $result = $this->bankAccountRepository->paginatePixKey(bankAccountId: $bankAccount->id);

        $this->assertInstanceOf(PaginationInterface::class, $result);
        $this->assertCount(15, $result->items());
    }

    /**
     * @throws NotFoundException|NotificationException
     */
    public function test_create_pix_key()
    {
        $bankAccount = BankAccountModel::factory()->create();

        $pixKey = new PixKey(
            key: 'matheus@mail.com',
            kind: PixKeyKind::email,
            bankAccount: BankAccountFactory::create($bankAccount)
        );
        $result = $this->bankAccountRepository->createPixKey(data: $pixKey);

        $this->assertNotEmpty($result->id());
        $this->assertNotEmpty($result->createdAt());
        $this->assertNotEmpty($result->bankAccountId());

        $this->assertEquals('matheus@mail.com', $result->key);
        $this->assertEquals(PixKeyKind::email, $result->kind);
    }

    public function test_pix_key_exists()
    {
        $bankAccount = BankAccountModel::factory()->create();
        $pixKey = PixKeyModel::factory()->create([
            'bank_account_id' => $bankAccount->id,
        ]);

        $result = $this->bankAccountRepository->existPixKey(
            bankAccountId: $bankAccount->id,
            kind: $pixKey->kind,
            key: $pixKey->key
        );
        $this->assertTrue($result);
    }

    /**
     * @throws NotFoundException
     */
    public function test_paginate_transaction_empty()
    {
        $bankAccount = BankAccountModel::factory()->create();
        $result = $this->bankAccountRepository->paginateTransaction(bankAccountId: $bankAccount->id);

        $this->assertInstanceOf(PaginationInterface::class, $result);
        $this->assertCount(0, $result->items());
    }

    /**
     * @throws NotFoundException
     */
    public function test_paginate_transaction()
    {
        $bankAccount = BankAccountModel::factory()->create();
        TransactionModel::factory()->toTest()->count(20)->create([
            'bank_account_from_id' => $bankAccount->id,
        ]);

        $result = $this->bankAccountRepository->paginateTransaction(bankAccountId: $bankAccount->id);

        $this->assertInstanceOf(PaginationInterface::class, $result);
        $this->assertCount(15, $result->items());
    }

    /**
     * @throws NotificationException|NotFoundException
     */
    public function test_transaction_create()
    {
        $bankAccount = BankAccountModel::factory()->create();
        $transaction = new Transaction(
            bankAccountFrom: BankAccountFactory::create(model: $bankAccount),
            pixKeyTo: PixKeyFactory::create(model: PixKeyModel::factory()->toTest()->create()),
            amount: 1000,
            description: 'Descrição do pagamento',
        );

        $result = $this->bankAccountRepository->createTransaction(data: $transaction);

        $this->assertNotEmpty($result->id());
        $this->assertNotEmpty($result->createdAt());
        $this->assertNotEmpty($result->bankAccountId());
        $this->assertNotEmpty($result->pixKeyToKind());
        $this->assertNotEmpty($result->pixKeyToKey());
    }
}
