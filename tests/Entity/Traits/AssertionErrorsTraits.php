<?php

declare(strict_types=1);

namespace App\Tests\Entity\Traits;

use Symfony\Component\Validator\Validator\ValidatorInterface;

trait AssertionErrorsTraits
{
    public function assertHasErrors(object $entity, int $nbError = 0): void
    {
        /** @var ValidatorInterface $validator */
        $validator = self::$container->get(ValidatorInterface::class);
        $errors = $validator->validate($entity);

        $messages = [];
        foreach ($errors as $error) {
            $messages[] = $error->getPropertyPath().' => '.$error->getMessage();
        }

        self::assertCount($nbError, $errors, implode(', ', $messages));
    }
}
