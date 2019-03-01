<?php
/**
 * Created by PhpStorm.
 * User: finatoros
 * Date: 27.02.19
 * Time: 16:09
 */

namespace App\Services;


/**
 * Abstract layer class
 *
 * Class AbstractService
 * @package App\Services
 */
class AbstractService
{
    /**
     * @var array
     */
    protected $defaultHeaders;

    /**
     * AbstractService constructor.
     */
    public function __construct()
    {
        $this->defaultHeaders = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Basic ' . config('auth.api.user.hash')
        ];
    }

}