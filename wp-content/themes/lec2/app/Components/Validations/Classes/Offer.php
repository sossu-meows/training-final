<?php


namespace App\Components\Validations\Classes;


use App\Components\Validations\Abstracts\AbstractValidation;

class Offer extends AbstractValidation
{
    protected $validatedFields = [
        'to_email'         => [
            'required'  => 'Please insert email address',
            'email'     => 'Please insert a valid email address',
        ],
    ];
}