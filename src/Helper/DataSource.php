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
    public static function getResources($resources, $sourceFile = __DIR__ . '/../dataSource/dadosMarketPlace.json') {
        $resources = explode('.', $resources);
        if (is_array($resources) && count($resources) > 0) {

            $resourceData = self::getJson($sourceFile);
            $resourceData = self::getInfo($resourceData, $resources);

            return $resourceData;
        }
    }

    private static function loadResource($resourceFile) {
        $dataSource = fopen($resourceFile, 'r');
        return fread($dataSource, filesize($resourceFile));
    }

    private static function getJson($resourceFile)
    {
        return \GuzzleHttp\json_decode(self::loadResource($resourceFile));
    }

    /**
     * Função para pegar wildcards na chave.
     * @param \stdClass $resourceData
     * @param array $resources
     * @return \stdClass
     */
    public static function getInfo(\stdClass $resourceData, array $resources) {

        foreach ($resources as $resourceKey => $resouceValue) {
            if ($resources[$resourceKey] != '*') {
                $resourceData = $resourceData->$resouceValue;
            } else {
                return self::getWithWildCard($resourceData, $resourceKey, $resources);
            }
        }

        return $resourceData;
    }

    /**
     * @param \stdClass $resourceData
     * @param $resourceKey
     * @param array $resources
     * @return \stdClass
     */
    public static function getWithWildCard(\stdClass $resourceData, $resourceKey, array $resources) {

        $newResourceData = new \stdClass();
        $nextKeyName = $resources[$resourceKey + 1];

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
     * @param $resources
     * @param $value
     * @param string $sourceFile
     * @return mixed
     */
    public static function setResource($resources, $value, $sourceFile = __DIR__ . '/../dataSource/dadosMarketPlace.json') {
        $resources = explode('.', $resources);
        $resourceData = self::getJson($sourceFile);

        self::createResource($resourceData, $resources, $value);
        self::recordSourceFile(\GuzzleHttp\json_encode($resourceData, JSON_UNESCAPED_UNICODE), $sourceFile);

        return $resourceData;
    }

    public static function createResource($resourceData, $resources, $value) {
        $tempResourceData = $resourceData;

        foreach ($resources as $resourceValue) {
            if (!isset($tempResourceData->{$resourceValue}) || is_null($tempResourceData->{$resourceValue})) {
                $tempResourceData->{$resourceValue} = $value;
            } else {
                $tempResourceData = $tempResourceData->$resourceValue;
            }
        }

        return $tempResourceData;
    }

    public static function recordSourceFile($resourceJSONData, $sourceFile) {
        $file = fopen($sourceFile, 'w');
        fwrite($file, $resourceJSONData);
        fclose($file);
    }
}