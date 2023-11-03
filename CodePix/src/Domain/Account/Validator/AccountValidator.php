<?php

namespace Core\Domain\Account\Validator;

use Core\Domain\Shared\Entity\Entity;
use Core\Domain\Shared\Validation\ValidatorEntityInterface;
use Rakit\Validation\Validator;

class AccountValidator implements ValidatorEntityInterface
{
    public function validate(Entity $entity): void
    {
        $data = $this->convertEntityForArray($entity);

        $validation = (new Validator())->validate($data, [
            'ownerName' => 'required',
            'number' => 'required',
            'bank_id' => 'required',
        ]);

        if ($validation->fails()) {
            foreach ($validation->errors()->all() as $error) {
                $entity->notification->addError([
                    'context' => 'account',
                    'message' => $error,
                ]);
            }
        }
    }

    private function convertEntityForArray(Entity $entity): array
    {
        return [
            'ownerName' => $entity->ownerName,
            'number' => $entity->number,
            'bank_id' => $entity->bankId(),
        ];
    }
}
