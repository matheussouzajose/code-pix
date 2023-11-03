<?php

namespace Tests\Integration\UseCase\Transaction;

use App\Models\BankAccount as BankAccountModel;
use App\Models\PixKey as PixKeyModel;
use Core\Application\UseCase\Transaction\Create\CreateTransactionInputDto;
use Core\Application\UseCase\Transaction\Create\CreateTransactionUseCase;
use Core\Domain\BankAccount\Repository\BankAccountRepositoryInterface;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Infrastructure\Persistence\Eloquent\Repository\BankAccountRepositoryDb;
use Tests\TestCase;

class CreateTransactionUseCaseTest extends TestCase
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
     */
    public function test_create_transaction()
    {
        $bankAccount = BankAccountModel::factory()->create();
        $pixKey = PixKeyModel::factory()->toTest()->create();

        $useCase = new CreateTransactionUseCase(bankAccountRepository: $this->bankAccountRepository);
        $result = ($useCase)(
            input: new CreateTransactionInputDto(
                bankAccountId: $bankAccount->id,
                pixKeyTo: $pixKey->key,
                pixKindTo: $pixKey->kind,
                amount: 2000,
                description: 'Descrição do pagamento'
            )
        );

        $this->assertNotEmpty($result->id);
        $this->assertNotEmpty($result->externalId);
        $this->assertNotEmpty($result->createdAt);

        $this->assertEquals($bankAccount->id, $result->bankAccountFrom->id());
        $this->assertEquals($pixKey->key, $result->pixKeyTo->key);
        $this->assertEquals($pixKey->kind, $result->pixKeyTo->kind->value);
        $this->assertEquals(2000, $result->amount);
        $this->assertEquals('Descrição do pagamento', $result->description);
        $this->assertEquals('pending', $result->status);
        $this->assertEquals('debit', $result->operation);
    }
}
