<?php

namespace App\JsonApi;

use Tobscure\JsonApi\Document;

class JsonApi1_0Document extends Document
{
    protected $jsonapi = ['version' => '1.0'];
    protected $errors;

    /*
     * Errors on Lumen's validate() format:
     * $errors = [
     *   'email' => [
     *     0 => 'The email must be a valid email address.',
     *     1 => 'The email "not.existing.email@test.test" does not exist.',
     *   ],
     *   'password' => [
     *     0 => 'The password field is required.',
     *   ],
     * ];
     */
    public function setErrorsFromKeyValueFormat($errorsOnKeyValueFormat)
    {
        $errorsOnJsonApiFormat = [];

        foreach ($errorsOnKeyValueFormat as $errorParameter => $errorMessages) {
            foreach ($errorMessages as $errorMessage) {
                $errorsOnJsonApiFormat[] = [
                    'source' => [
                        'parameter' => str_replace('data.attributes.', '', $errorParameter),
                    ],
                    'title' => sprintf('%s Error', ucwords(str_replace('data.attributes.', '', $errorParameter))),
                    'detail' => str_replace('data.attributes.', '', $errorMessage),
                ];
            }
        }

        $this->errors = $errorsOnJsonApiFormat;

        return $this;
    }
}
