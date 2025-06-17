<?php

namespace App\Contracts;

interface EmailInterface
{
    public function send(array $data);
}
