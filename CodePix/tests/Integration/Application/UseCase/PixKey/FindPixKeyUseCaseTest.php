<?php

namespace Tests\Integration\Application\UseCase\PixKey;

use App\Models\PixKey as PixKey;
use Core\Application\UseCase\PixKey\Find\FindKeyUseCase;
use Core\Application\UseCase\PixKey\Find\FindKeyInputDto;
use Core\Ui\Factories\Repository\PixKeyRepositoryFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FindPixKeyUseCaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_find_pix_key()
    {
        $pixKeyUseCase = new FindKeyUseCase(
            pixKeyRepository: PixKeyRepositoryFactory::create()
        );

        $pixKey = PixKey::factory()->toTest()->create();
        $input = new FindKeyInputDto(
            key: $pixKey->key,
            kind: $pixKey->kind,
        );

        $result = ($pixKeyUseCase)(input: $input);

        $this->assertEquals($pixKey->id, $result->id);
        $this->assertEquals($pixKey->account->id, $result->account->id());
        $this->assertEquals($pixKey->kind, $result->kind);
        $this->assertEquals($pixKey->status, $result->status);
        $this->assertEquals($pixKey->created_at, $result->createdAt);
    }
}
