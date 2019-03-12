<?php

namespace App\Component\Validation;

use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractValidation implements ValidationInterface
{
    protected $validation;
    protected $validationMessages;

    public function __construct(ValidatorInterface $validation)
    {
        $this->validation = $validation;
    }

    public function isValid($data)
    {
        $rules = $this->getDefineRules();
        $errors = $this->validation->validate($data, $rules);

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $property = str_replace(["[", "]"], "", $error->getPropertyPath());
                $this->validationMessages[$property] = $error->getMessage();
            }

            return false;
        }

        return true;

    }

    public function getMessages()
    {
        return $this->validationMessages;
    }

    abstract protected function getDefineRules();
}
