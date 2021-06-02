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
 * Class WriteUsContact - This is used for validating contact request
 * @package App\Components\Validations\Classes
 */
class RequestACall extends AbstractValidation
{

    /**
     * Validate these fields below
     *
     * @var array
     */
    protected $validatedFields = [
        'firstname'     => ['required' => 'Please insert first name'],
        'lastname'      => ['required' => 'Please insert last name'],
        'message'       => ['required' => 'Please insert message']
    ];

}