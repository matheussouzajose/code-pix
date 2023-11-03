<?php

namespace Tests\Integration\Infrastructure\Persistence\Eloquent\Repository;

use App\Models\Account as AccountModel;
use App\Models\PixKey as PixKeyModel;
use App\Models\Transaction as TransactionModel;
use Core\Domain\Account\Entity\Account;
use Core\Domain\PixKey\Entity\PixKey;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Shared\ObjectValues\Uuid;
use Core\Domain\Transaction\Entity\Transaction;
use Core\Domain\Transaction\Enum\StatusTransactionType;
use Core\Domain\Transaction\Repository\TransactionRepositoryInterface;
use Core\Infrastructure\Exceptions\NotFoundException;
use Core\Infrastructure\Persistence\Eloquent\Factories\AccountFactory;
use Core\Infrastructure\Persistence\Eloquent\Factories\PixKeyFactory;
use Core\Ui\Factories\Repository\TransactionRepositoryFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionRepositoryDbTest extends TestCase
{
    use RefreshDatabase;

    protected TransactionRepositoryInterface $transactionRepository;

    public function setUp(): void
    {
        $this->transactionRepository = TransactionRepositoryFactory::create();

        parent::setUp();
    }

    /**
     * @throws NotificationException
     */
    public function test_register(): void
    {
        $account = AccountFactory::create(
            data: AccountModel::factory()->toTest()->create()
        );

        $pixKey = PixKeyFactory::create(
            data: PixKeyModel::factory()->toTest()->create()
        );

        $transaction = new Transaction(
            accountFrom: $account,
            amount: 1000,
            pixKeyTo: $pixKey,
            description: 'Pgto almoço',
        );

        $result = $this->transactionRepository->register($transaction);

        $this->assertNotEmpty($result->id());
        $this->assertEquals(1000, $result->amount);
        $this->assertEquals('Pgto almoço', $result->description);
        $this->assertInstanceOf(Account::class, $result->accountFrom());
        $this->assertInstanceOf(PixKey::class, $result->pixKeyTo());
    }


    /**
     * @throws NotificationException|NotFoundException
     */
    public function test_save(): void
    {
        $account = AccountFactory::create(
            data: AccountModel::factory()->toTest()->create()
        );

        $pixKey = PixKeyFactory::create(
            data: PixKeyModel::factory()->toTest()->create()
        );

        $transaction = TransactionModel::factory()->toTest()->create();

        $transaction = new Transaction(
            accountFrom: $account,
            amount: 1000,
            pixKeyTo: $pixKey,
            description: 'Pgto almoço',
            id: new Uuid($transaction->id),
        );

        $transaction->completed();

        $result = $this->transactionRepository->save(transaction: $transaction);

        $this->assertEquals($transaction->id, $result->id());
        $this->assertEquals(StatusTransactionType::Completed, $result->status());
        $this->assertNotEmpty($result->updatedAt());
    }


    /**
     * @throws NotificationException|NotFoundException
     */
    public function test_find_by_id(): void
    {
        $transaction = TransactionModel::factory()->toTest()->create();

        $result = $this->transactionRepository->findById(id: $transaction->id);

        $this->assertEquals($transaction->id, $result->id());

    }
}
