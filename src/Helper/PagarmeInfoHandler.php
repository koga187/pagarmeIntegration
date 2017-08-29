<?php
/**
 * Created by PhpStorm.
 * User: koga
 * Date: 7/30/17
 * Time: 12:30 PM
 */

namespace TestPagarme\Helper;


class PagarmeInfoHandler
{
    private $apiKey = '';

    private $apiEncryption= '';

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @return string
     */
    public function getApiEncryption()
    {
        return $this->apiEncryption;
    }
}
