<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as IlluminateRequest;
use Illuminate\Validation\ValidationException;

class FormRequest extends IlluminateRequest
{
    /* Decide if the request should throw ValidationException immediately upon validation failed
    Default to true */
    public $throwWhenFailed = true;
    public $errors;
    public $validator;

    /**
     * Handle a failed validation attempt.
     * Override to control the 422 redirection upon validation failure
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        if ($this->throwWhenFailed) {
            $this->throwValidationException();
        }
        $this->validator = $validator;
        $this->errors = $validator->errors();
    }

    /* Support for throwing ValidationException the same as original FormRequest implementation */
    public function throwValidationException()
    {
        // throw (new ValidationException($this->validator))
        //     ->errorBag($this->errorBag)
        //     ->redirectTo($this->getRedirectUrl());
        return res(400, 'Validation failed.', $this->errors);
    }
}
