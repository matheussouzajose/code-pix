<?php

namespace Core\Domain\PixKey\Validator;

use Core\Domain\Shared\Entity\Entity;
use Core\Domain\Shared\Validation\ValidatorEntityInterface;
use Rakit\Validation\Validator;

class PixKeyValidator implements ValidatorEntityInterface
{
    public function validate(Entity $entity): void
    {
        $data = $this->convertEntityForArray($entity);

        $validation = (new Validator())->validate($data, [
            'kind' => 'required',
            'key' => 'required',
            'accountId' => 'required',
            'status' => 'required',
        ]);

        if ($validation->fails()) {
            foreach ($validation->errors()->all() as $error) {
                $entity->notification->addError([
                    'context' => 'pix_key',
                    'message' => $error,
                ]);
            }
        }
    }

    private function convertEntityForArray(Entity $entity): array
    {
        return [
            'kind' => $entity->kind,
            'key' => $entity->key,
            'accountId' => $entity->accountId(),
            'status' => $entity->status,
        ];
    }
}
