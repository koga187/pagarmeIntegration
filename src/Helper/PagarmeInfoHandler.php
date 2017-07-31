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
    private $apiKey = 'ak_test_DANlRep16K8gCymEJaSK8yuaHrafoQ';

    private $apiEncryption= 'ek_test_stUhVL7AKqyNfVoK56WAJjGQ3ZsyzU';

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