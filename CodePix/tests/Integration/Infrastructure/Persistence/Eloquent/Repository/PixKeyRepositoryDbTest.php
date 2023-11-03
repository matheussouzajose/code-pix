<?php

namespace Tests\Integration\Infrastructure\Persistence\Eloquent\Repository;

use App\Models\Account as AccountModel;
use App\Models\Bank as BankModel;
use App\Models\PixKey as PixKeyModel;
use Core\Domain\Account\Entity\Account;
use Core\Domain\Bank\Entity\Bank;
use Core\Domain\PixKey\Entity\PixKey;
use Core\Domain\PixKey\Enum\KindType;
use Core\Domain\PixKey\Enum\StatusType;
use Core\Domain\PixKey\Repository\PixKeyRepositoryInterface;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Infrastructure\Exceptions\NotFoundException;
use Core\Infrastructure\Persistence\Eloquent\Factories\AccountFactory;
use Core\Infrastructure\Persistence\Eloquent\Factories\BankFactory;
use Core\Ui\Factories\Repository\PixKeyRepositoryFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PixKeyRepositoryDbTest extends TestCase
{
    use RefreshDatabase;

    protected PixKeyRepositoryInterface $pixKeyRepositoryDb;

    public function setUp(): void
    {
        $this->pixKeyRepositoryDb = PixKeyRepositoryFactory::create();

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

        $pixKey = new PixKey(
            kind: KindType::Email,
            key: 'matheus.jose@gmail.com',
            account: $account,
            status: StatusType::Active
        );

        $result = $this->pixKeyRepositoryDb->register($pixKey);

        $this->assertEquals($pixKey->id(), $result->id());
        $this->assertEquals(KindType::Email->value, $result->kind->value);
        $this->assertEquals('matheus.jose@gmail.com', $result->key);
        $this->assertEquals(StatusType::Active->value, $result->status->value);
    }

    /**
     * @throws NotificationException|NotFoundException
     */
    public function test_find_key_by_kind(): void
    {
        $pixKey = PixKeyModel::factory()->toTest()->create();

        $result = $this->pixKeyRepositoryDb->findByKeyAndByKind(
            key: $pixKey->key,
            kind: $pixKey->kind
        );

        $this->assertNotEmpty($result->id());
        $this->assertEquals($pixKey->key, $result->key);
        $this->assertEquals($pixKey->kind, $result->kind->value);

    }

    /**
     * @throws NotificationException
     */
    public function test_add_bank()
    {
        $bank = new Bank(
            code: '001',
            name: 'CodeBank'
        );
        $result = $this->pixKeyRepositoryDb->addBank($bank);

        $this->assertEquals($bank->id(), $result->id());
        $this->assertEquals('001', $result->code);
        $this->assertEquals('CodeBank', $result->name);
    }

    /**
     * @throws NotificationException
     */
    public function test_add_account()
    {
        $bank = BankFactory::create(
            data: BankModel::factory()->create()
        );

        $account = new Account(
            ownerName: 'Matheus Souza',
            number: '123456',
            bank: $bank,
        );

        $result = $this->pixKeyRepositoryDb->addAccount($account);

        $this->assertEquals($account->id(), $result->id());
        $this->assertEquals('Matheus Souza', $result->ownerName);
        $this->assertEquals('123456', $result->number);
        $this->assertEquals($bank->id(), $result->bank()->id());
    }

    /**
     * @throws NotificationException|NotFoundException
     */
    public function test_find_account_by_id()
    {
        $account = AccountModel::factory()->toTest()->create();

        $result = $this->pixKeyRepositoryDb->findAccountById($account->id);

        $this->assertEquals($account->id, $result->id());
        $this->assertEquals($account->owner_name, $result->ownerName);
        $this->assertEquals($account->number, $result->number);
        $this->assertEquals($account->bank->id, $result->bank()->id());
    }
}
