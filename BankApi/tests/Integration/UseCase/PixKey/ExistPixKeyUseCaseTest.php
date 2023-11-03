<?php

namespace Tests\Integration\UseCase\PixKey;

use App\Models\BankAccount as BankAccountModel;
use App\Models\PixKey as PixKeyModel;
use Core\Application\UseCase\PixKey\Exist\ExistPixKeyInputDto;
use Core\Application\UseCase\PixKey\Exist\ExistPixKeyOutputDto;
use Core\Application\UseCase\PixKey\Exist\ExistPixKeyUseCase;
use Core\Domain\BankAccount\Repository\BankAccountRepositoryInterface;
use Core\Infrastructure\Persistence\Eloquent\Repository\BankAccountRepositoryDb;
use Tests\TestCase;

class ExistPixKeyUseCaseTest extends TestCase
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

    public function test_exist_pix_key_account()
    {
        $bankAccount = BankAccountModel::factory()->create();
        $pixKey = PixKeyModel::factory()->create([
            'bank_account_id' => $bankAccount->id,
        ]);

        $useCase = new ExistPixKeyUseCase(bankAccountRepository: $this->bankAccountRepository);
        $result = ($useCase)(
            input: new ExistPixKeyInputDto(
                bankAccountId: $bankAccount->id,
                kind: $pixKey->kind,
                key: $pixKey->key
            )
        );

        $this->assertInstanceOf(ExistPixKeyOutputDto::class, $result);
        $this->assertTrue($result->exist);
    }
}
