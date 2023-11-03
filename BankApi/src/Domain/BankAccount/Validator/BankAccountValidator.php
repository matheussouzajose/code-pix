<?php

namespace Core\Domain\BankAccount\Validator;

use Core\Domain\Shared\Entity\Entity;
use Core\Domain\Shared\Validator\ValidatorInterface;
use Rakit\Validation\Validator;

class BankAccountValidator implements ValidatorInterface
{
    public const CONTEXT = 'pix-key';

    public function validate(Entity $entity): void
    {
        $data = $this->convertEntityForArray($entity);

        $validation = (new Validator())->validate($data, [
            'number' => 'required|min:0|max:255',
            'ownerName' => 'required|min:0|max:255',
            'balance' => 'required|numeric',
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

    private function convertEntityForArray(Entity $entity): array
    {
        return [
            'number' => $entity->number,
            'ownerName' => $entity->ownerName,
            'balance' => $entity->balance,
        ];
    }
}
