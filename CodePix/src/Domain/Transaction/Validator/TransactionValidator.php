<?php

namespace Core\Domain\Transaction\Validator;

use Core\Domain\Shared\Entity\Entity;
use Core\Domain\Shared\Validation\ValidatorEntityInterface;
use Rakit\Validation\Validator;

class TransactionValidator implements ValidatorEntityInterface
{
    public const CONTEXT = 'transaction';

    public function validate(Entity $entity): void
    {
        $this->rakitValidator($entity);
        $this->amountValidator($entity);
        $this->theSameAccountValidator($entity);
    }

    protected function rakitValidator(Entity $entity): void
    {
        $data = $this->convertEntityForArray($entity);

        $validation = (new Validator())->validate($data, [
            'account_id' => 'required',
            'pix_key_id' => 'required',
            'description' => 'required|min:0|max:255',
            'amount' => 'required|numeric',
            'status' => 'required|min:0|max:255',
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
            'account_id' => $entity->accountFromId(),
            'pix_key_id' => $entity->pixKeyToId(),
            'description' => $entity->description,
            'amount' => $entity->amount,
            'status' => $entity->status->value,
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

    protected function theSameAccountValidator(Entity $entity): void
    {
        if ($entity->pixKeyTo->accountId() === $entity->accountFrom->id()) {
            $entity->notification->addError([
                'context' => TransactionValidator::CONTEXT,
                'message' => 'the source and destination account cannot be the same',
            ]);
        }
    }
}
