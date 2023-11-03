<?php

namespace Core\Domain\Shared\Validator;

use Core\Domain\Shared\Entity\Entity;

interface ValidatorInterface
{
    public function validate(Entity $entity): void;
}
