<?php
/**
 * Created by PhpStorm.
 * User: koga
 * Date: 7/30/17
 * Time: 12:35 PM
 */

namespace TestPagarme\Helper;


class DataSource
{
    /**
     * @param $resources
     * @param string $sourceFile
     * @return mixed|\stdClass
     */
    public static function getResources($resources, $sourceFile = __DIR__ . '/../dataSource/dadosMarketPlace.json') {
        $resources = (is_null($resources)) ? null : explode('.', $resources);
        if (is_array($resources) && count($resources) > 0 || is_null($resources)) {

            $resourceData = self::getJson($sourceFile);
            $resourceData = self::getInfo($resourceData, $resources);

            return $resourceData;
        }
    }

    /**
     * @param $resources
     * @param $value
     * @param string $sourceFile
     * @return mixed
     */
    public static function setResource($resources = null, $value, $sourceFile = __DIR__ . '/../dataSource/dadosMarketPlace.json') {
        $resources = (is_null($resources)) ? null : explode('.', $resources);
        $resourceData = self::getJson($sourceFile);

        self::createResource($resourceData, $resources, $value);
        self::recordSourceFile(\GuzzleHttp\json_encode($resourceData, JSON_UNESCAPED_UNICODE), $sourceFile);

        return $resourceData;
    }

    /**
     * Função para pegar wildcards na chave.
     * @param \stdClass $resourceData
     * @param array $resources
     * @return \stdClass
     */
    protected static function getInfo(\stdClass $resourceData, $resources) {

        if (!is_null($resources)) {
            foreach ($resources as $resourceKey => $resouceValue) {
                if ($resources[$resourceKey] != '*') {
                    $resourceData = $resourceData->$resouceValue;
                } else {
                    return self::getWithWildCard($resourceData, $resourceKey, $resources);
                }
            }
        }

        return $resourceData;
    }

    /**
     * @param $resourceData
     * @param $resources
     * @param $values
     * @return mixed
     */
    protected static function createResource($resourceData, $resources, $values) {
        $tempResourceData = $resourceData;

        if (!is_null($resources)) {
            foreach ($resources as $resourceValue) {
                if (!isset($tempResourceData->{$resourceValue}) || is_null($tempResourceData->{$resourceValue})) {
                    $tempResourceData->{$resourceValue} = $values;
                } else {
                    $tempResourceData = $tempResourceData->$resourceValue;
                }
            }
        } else {
            foreach ($values as $key => $value) {
                $tempResourceData->$key = $value;
            }
        }

        return $tempResourceData;
    }

    /**
     * @param \stdClass $resourceData
     * @param $resourceKey
     * @param array $resources
     * @return \stdClass
     */
    protected static function getWithWildCard(\stdClass $resourceData, $resourceKey, array $resources) {

        $newResourceData = new \stdClass();
        $nextKeyName = (isset($resources[$resourceKey + 1])) ? $resources[$resourceKey + 1] : NULL;

        if ($nextKeyName == '*') {
            $newResourceData = self::getWithWildCard($resourceData, $resourceKey + 1, $resources);
        }

        foreach ($resourceData as $resourceWildCardKey => $resourceWildCardValue) {
            if (!is_null($nextKeyName)) {
                $newResourceData->$resourceWildCardKey = $resourceData->$resourceWildCardKey->$nextKeyName;
            } else {
                $newResourceData->$resourceWildCardKey = $resourceData->$resourceWildCardKey;
            }
        }

        return $newResourceData;
    }

    /**
     * @param $resourceJSONData
     * @param $sourceFile
     */
    protected static function recordSourceFile($resourceJSONData, $sourceFile) {
        $file = fopen($sourceFile, 'w');
        fwrite($file, $resourceJSONData);
        fclose($file);
    }

    /**
     * @param $resourceFile
     * @return bool|string
     */
    protected static function loadResource($resourceFile) {
        $dataSource = fopen($resourceFile, 'r');
        return fread($dataSource, filesize($resourceFile));
    }

    /**
     * @param $resourceFile
     * @return mixed
     */
    protected static function getJson($resourceFile)
    {
        return \GuzzleHttp\json_decode(self::loadResource($resourceFile));
    }
}