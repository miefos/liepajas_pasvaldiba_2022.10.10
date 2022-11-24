<?php

namespace App\Exceptions;

use Exception;
use Inertia\Inertia;
use Throwable;

class CustomException extends Exception
{
    public function report() {

    }

    public function render() {
        die(view("error")->with(['msg' => $this->getMessage()]));
    }
}
