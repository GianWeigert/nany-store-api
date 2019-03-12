<?php

namespace App\Component\Validation;

interface ValidationInterface
{
    public function isValid($data);
    public function getMessages();
}
