<?php

namespace Tests\Integration\UseCase\BankAccount;

use App\Models\BankAccount as BankAccountModel;
use App\Models\PixKey as PixKeyModel;
use Core\Application\UseCase\BankAccount\Show\ShowBankAccountInputDto;
use Core\Application\UseCase\BankAccount\Show\ShowBankAccountOutputDto;
use Core\Application\UseCase\BankAccount\Show\ShowBankAccountUseCase;
use Core\Domain\BankAccount\Repository\BankAccountRepositoryInterface;
use Core\Domain\Shared\ObjectValues\Uuid;
use Core\Infrastructure\Exceptions\NotFoundException;
use Core\Infrastructure\Persistence\Eloquent\Repository\BankAccountRepositoryDb;
use Tests\TestCase;

class ShowAccountBankUseCaseTest extends TestCase
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

    public function test_throws_error_account()
    {
        $id = Uuid::random();
        $this->expectExceptionObject(NotFoundException::itemNotFound($id));

        $useCase = new ShowBankAccountUseCase(bankAccountRepository: $this->bankAccountRepository);
        ($useCase)(
            input: new ShowBankAccountInputDto(
                id: $id
            )
        );
    }

    public function test_show_bank_account()
    {
        $bankAccountModel = BankAccountModel::factory()->create();
        $useCase = new ShowBankAccountUseCase(bankAccountRepository: $this->bankAccountRepository);
        $result = ($useCase)(
            input: new ShowBankAccountInputDto(
                id: $bankAccountModel->id
            )
        );

        $this->assertInstanceOf(ShowBankAccountOutputDto::class, $result);
    }
}
