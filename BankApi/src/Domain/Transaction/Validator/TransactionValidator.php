<?php

namespace Core\Domain\Transaction\Validator;

use Core\Domain\Shared\Entity\Entity;
use Core\Domain\Shared\Validator\ValidatorInterface;
use Rakit\Validation\Validator;

class TransactionValidator implements ValidatorInterface
{
    public const CONTEXT = 'transaction';

    public function validate(Entity $entity): void
    {
        $this->rakitValidator($entity);
        $this->amountValidator($entity);
    }

    protected function rakitValidator(Entity $entity): void
    {
        $data = $this->convertEntityForArray($entity);

        $validation = (new Validator())->validate($data, [
            'bank_account_from_id' => 'required',
            'pix_key_to_key' => 'required',
            'pix_key_to_kind' => 'required',
            'amount' => 'required|numeric',
            'description' => 'required',
            'operation' => 'required',
            'status' => 'required',
            'external_id' => 'required',
            'id' => 'required',
            'created_at' => 'required',
        ]);

        if ($validation->fails()) {
            foreach ($validation->errors()->all() as $error) {
                $entity->notification->addError([
                    'context' => self::CONTEXT,
                    'message' => $error,
                ]);
            }
        }
    }

    protected function convertEntityForArray(Entity $entity): array
    {
        return [
            'bank_account_from_id' => $entity->bankAccountFromId,
            'pix_key_to_key' => $entity->pixKeyTo,
            'pix_key_to_kind' => $entity->pixKindTo,
            'amount' => $entity->amount,
            'description' => $entity->description,
            'operation' => $entity->operation->value,
            'status' => $entity->status->value,
            'external_id' => $entity->externalId,
            'id' => $entity->id(),
            'created_at' => $entity->createdAt(),
        ];
    }

    protected function amountValidator(Entity $entity): void
    {
        if ($entity->amount < 0) {
            $entity->notification->addError([
                'context' => TransactionValidator::CONTEXT,
                'message' => 'the amount must be greater than 0',
            ]);
        }
    }
}
