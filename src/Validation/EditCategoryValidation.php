<?php

namespace App\Validation;

use App\Component\Validation\AbstractValidation;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EditCategoryValidation extends AbstractValidation
{
    protected function getDefineRules()
    {
        return new Collection(
            [
                'name' => [
                    new NotBlank([
                        'message' => 'The name field can not be blank'
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'The name field must be at least 3 characters'
                    ])
                ],
                'slug' => [
                    new NotBlank([
                        'message' => 'The slug field can not be blank'
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'The slug field must be at least 3 characters'
                    ])
                ],
                'enabled' => [
                    new Type([
                        'type'    => 'bool',
                        'message' => 'This value is not valid'
                    ])
                ]
            ]
        );
    }
}
