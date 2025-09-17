<?php

namespace App\Exceptions;

use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class InvalidTransitionException extends HttpException
{
    protected $message = 'Invalid transition';

    protected $code = Response::HTTP_UNPROCESSABLE_ENTITY;

    public function __construct()
    {
        parent::__construct($this->code, $this->message);
    }
}