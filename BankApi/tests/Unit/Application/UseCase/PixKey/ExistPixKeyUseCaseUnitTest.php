<?php

namespace Tests\Unit\Application\UseCase\PixKey;

use Core\Application\UseCase\PixKey\Exist\ExistPixKeyInputDto;
use Core\Application\UseCase\PixKey\Exist\ExistPixKeyOutputDto;
use Core\Application\UseCase\PixKey\Exist\ExistPixKeyUseCase;
use Core\Domain\BankAccount\Repository\BankAccountRepositoryInterface;
use Tests\TestCase;

class ExistPixKeyUseCaseUnitTest extends TestCase
{
    public function test_exist_pix_kind_true()
    {
        $bankAccountRepository = \Mockery::mock(\stdClass::class, BankAccountRepositoryInterface::class);
        $bankAccountRepository->shouldReceive('existPixKey')->andReturn(true);

        $useCase = new ExistPixKeyUseCase($bankAccountRepository);
        $result = ($useCase)(input: new ExistPixKeyInputDto(
            bankAccountId: 'uuid',
            kind: 'email',
            key: 'matheus@gmail.com'
        ));

        $this->assertInstanceOf(ExistPixKeyOutputDto::class, $result);
        $this->assertTrue($result->exist);
    }

    public function test_exist_pix_kind_false()
    {
        $bankAccountRepository = \Mockery::mock(\stdClass::class, BankAccountRepositoryInterface::class);
        $bankAccountRepository->shouldReceive('existPixKey')->andReturn(false);

        $useCase = new ExistPixKeyUseCase($bankAccountRepository);
        $result = ($useCase)(input: new ExistPixKeyInputDto(
            bankAccountId: 'uuid',
            kind: 'email',
            key: 'jhuana@mail.com'
        ));

        $this->assertInstanceOf(ExistPixKeyOutputDto::class, $result);
        $this->assertFalse($result->exist);
    }
}
