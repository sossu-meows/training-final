<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-21
 * Time: 10:32
 */

namespace App\Components\Validations\Classes;

use App\Components\Validations\Abstracts\AbstractValidation;

/**
 * Class Contact - This is used for validating contact request
 * @package App\Components\Validations\Classes
 */
class Contact extends AbstractValidation
{

    /**
     * Validate these fields below
     *
     * @var array
     */
    protected $validatedFields = [
        'salutation'        => ['required' => 'Please insert your salutation'],
        'firstname'         => ['required' => 'Please insert firstname'],
        'lastname'          => ['required' => 'Please insert lastname'],
        'street'            => ['required' => 'Please insert street'],
        'postcode'          => ['required' => 'Please insert postcode'],
        'city'              => ['required' => 'Please insert city'],
        'email'             => [
            'required'  => 'Please insert email address',
            'email'     => 'Please insert a valid email address',
        ],
        'country'           => ['required' => 'Please insert country'],
        'message'           => ['required' => 'Please insert message']
    ];

}