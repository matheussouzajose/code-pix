<?php

namespace Tests\Integration\UseCase\PixKey;

use App\Models\BankAccount as BankAccountModel;
use App\Models\PixKey as PixKeyModel;
use Core\Application\UseCase\PixKey\Create\CreatePixKeyInputDto;
use Core\Application\UseCase\PixKey\Create\CreatePixKeyOutputDto;
use Core\Application\UseCase\PixKey\Create\CreatePixKeyUseCase;
use Core\Domain\BankAccount\Repository\BankAccountRepositoryInterface;
use Core\Domain\PixKey\Enum\PixKeyKind;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Infrastructure\Http\Guzzle\GuzzleHttpIntegrationService;
use Core\Infrastructure\Persistence\Eloquent\Repository\BankAccountRepositoryDb;
use Core\Infrastructure\Persistence\Eloquent\Transaction\TransactionDb;
use Tests\TestCase;

class CreatePixKeyUseCaseTest extends TestCase
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
     * @throws \Throwable
     */
    public function test_create_pix_kind()
    {
        $bankAccount = BankAccountModel::factory()->create();
        $useCase = new CreatePixKeyUseCase(
            bankAccountRepository: $this->bankAccountRepository,
            transaction: new TransactionDb(),
            httpIntegrationService: new GuzzleHttpIntegrationService()
        );

        $result = ($useCase)(
            input: new CreatePixKeyInputDto(
                bankAccountId: $bankAccount->id,
                kind: PixKeyKind::email->value,
                key: 'matheus@gmail.com'
            )
        );

        $this->assertInstanceOf(CreatePixKeyOutputDto::class, $result);

        $this->assertNotEmpty($result->id);
        $this->assertNotEmpty($result->createdAt);

        $this->assertEquals($bankAccount->id, $result->bankAccount->id);
        $this->assertEquals(PixKeyKind::email->value, $result->kind);
        $this->assertEquals('matheus@gmail.com', $result->key);
    }
}
