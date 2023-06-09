<?php
namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class CustomException extends Exception
{
    public function render($request)
    {
        if ($request->expectsJson()) {
            return new JsonResponse([
                'error' => 'Custom Error Message',
            ], 400);
        }
        if ($this->getCode() === 404) {
            return new RedirectResponse('/404');
        }
        if ($this instanceof ValidationException) {
            return parent::render($request);
        }
        return view('errors.custom', ['exception' => $this]);
    }
}
