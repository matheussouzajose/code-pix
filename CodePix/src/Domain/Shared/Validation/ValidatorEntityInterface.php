<?php

namespace Core\Domain\Shared\Validation;

use Core\Domain\Shared\Entity\Entity;

interface ValidatorEntityInterface
{
    public function validate(Entity $entity): void;
}
