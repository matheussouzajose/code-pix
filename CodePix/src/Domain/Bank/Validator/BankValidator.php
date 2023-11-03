<?php

namespace Core\Domain\Bank\Validator;

use Core\Domain\Shared\Entity\Entity;
use Core\Domain\Shared\Validation\ValidatorEntityInterface;
use Rakit\Validation\Validator;

class BankValidator implements ValidatorEntityInterface
{
    public function validate(Entity $entity): void
    {
        $data = $this->convertEntityForArray($entity);

        $validation = (new Validator())->validate($data, [
            'code' => 'required',
            'name' => 'required'
        ]);

        if ($validation->fails()) {
            foreach ($validation->errors()->all() as $error) {
                $entity->notification->addError([
                    'context' => 'bank',
                    'message' => $error,
                ]);
            }
        }
    }

    private function convertEntityForArray(Entity $entity): array
    {
        return [
            'name' => $entity->name,
            'code' => $entity->code,
        ];
    }
}
