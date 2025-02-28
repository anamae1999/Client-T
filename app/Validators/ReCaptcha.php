<?php

namespace App\Validators;

use GuzzleHttp\Client;

class ReCaptcha
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        $client = new Client;
        $response = $client->post('https://www.google.com/recaptcha/api/siteverify',
            [
                'form_params' =>
                    [
                        'secret' => config('services.google.captcha_secret'),
                        'response' => $value
                    ]
            ]
        );

        $body = json_decode((string)$response->getBody());

        // dd(config('services.google.captcha_secret'));
        return $body->success;
    }
}