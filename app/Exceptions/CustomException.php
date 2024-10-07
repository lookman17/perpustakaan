<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



class CustomException extends Exception
{
    //
public function render($request, Exception $exception)
{

    if ($exception instanceof NotFoundHttpException) {
        return response()->view('errors.404', [], 404);
    }
}

}
