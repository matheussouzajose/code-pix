<?php

namespace Tests\Integration\Application\UseCase\PixKey;

use App\Models\Account as AccountModel;
use Core\Application\UseCase\PixKey\Create\CreatePixKeyInputDto;
use Core\Application\UseCase\PixKey\Create\CreatePixKeyUseCase;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Ui\Factories\Repository\PixKeyRepositoryFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreatePixKeyUseCaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @throws NotificationException
     */
    public function test_create_pix_key()
    {
        $pixKeyUseCase = new CreatePixKeyUseCase(
            pixKeyRepository: PixKeyRepositoryFactory::create()
        );

        $account = AccountModel::factory()->toTest()->create();

        $input = new CreatePixKeyInputDto(
            accountId: $account->id,
            key: 'matheus.jose@gmail.com',
            kind: 'email'
        );

        $result = ($pixKeyUseCase)(input: $input);

        $this->assertDatabaseCount('pix_keys', 1);
        $this->assertDatabaseHas('pix_keys', [
           'id' =>  $result->id,
           'status' =>  $result->status,
        ]);
    }
}
