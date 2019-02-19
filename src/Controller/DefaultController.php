<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class DefaultController
{
    public function index() : Response
    {
        return new Response('Primeiro retorno com symfony 4');
    }
}