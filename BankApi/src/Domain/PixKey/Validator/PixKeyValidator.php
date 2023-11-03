<?php

namespace Core\Domain\PixKey\Validator;

use Core\Domain\Shared\Entity\Entity;
use Core\Domain\Shared\Validator\ValidatorInterface;
use Rakit\Validation\Validator;

class PixKeyValidator implements ValidatorInterface
{
    public const CONTEXT = 'pix-key';

    public function validate(Entity $entity): void
    {
        $data = $this->convertEntityForArray($entity);

        $validation = (new Validator())->validate($data, [
            'kind' => 'required',
            'key' => 'required',
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
            'kind' => $entity->kind,
            'key' => $entity->key,
        ];
    }
}
