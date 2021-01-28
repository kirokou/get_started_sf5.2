<?php

declare(strict_types=1);

namespace App\Tests\Form;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegistrationFormTypeTest extends TypeTestCase
{
    public function testSubmitValidData(): void
    {
        $data = [
            'email' => 'test@example.com',
            'plainPassword' => [
                'first' => 'password',
                'second' => 'password',
            ],
            'agreeTerms' => true,
        ];

        $userForm = $this->factory->create(RegistrationFormType::class);
        $user = (new User())
            ->setEmail($data['email'])
            ->setPassword($data['plainPassword']['first'])
        ;

        $userForm->submit($data);

        self::assertTrue($userForm->isSynchronized());
        self::assertSame($user->getUsername(), $userForm->get('email')->getData());
        self::assertSame($user->getPassword(), $userForm->get('plainPassword')->getData());

        $view = $userForm->createView();
        $children = $view->children;

        foreach (array_keys($data) as $key) {
            self::assertArrayHasKey($key, $children);
        }
    }

    protected function getExtensions(): array
    {
        $validator = $this->createMock(ValidatorInterface::class);
        $validator->method('validate')->willReturn(new ConstraintViolationList());
        $validator->method('getMetadataFor')->willReturn(new ClassMetadata(Form::class));

        return [
            new ValidatorExtension($validator),
        ];
    }
}
