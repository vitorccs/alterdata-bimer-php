<?php

namespace Bimer\Http;

use Bimer\Exceptions\BimerApiException;
use Bimer\Exceptions\BimerParameterException;
use Bimer\Exceptions\BimerRequestException;

abstract class Resource
{
    /**
     * @return string
     */
    abstract public static function endpoint(): string;

    /**
     * @return Api
     */
    public static function api(): Api
    {
        return new Api(static::endpoint());
    }

    /**
     * Get array of objects
     *
     * @param array $params
     * @param string $endpoint
     * @return mixed
     * @throws BimerApiException
     * @throws BimerRequestException
     * @throws BimerParameterException
     */
    public static function all(array $params = [], string $endpoint = '')
    {
        return static::get($endpoint, $params, false);
    }

    /**
     * Get element by ID
     *
     * @param $id
     * @return mixed
     * @throws BimerApiException
     * @throws BimerRequestException
     * @throws BimerParameterException
     */
    public static function find($id)
    {
        return static::get($id);
    }

    /**
     * Make a GET connection
     *
     * @param string $endpoint
     * @param array $params
     * @param bool $single
     * @return mixed
     * @throws BimerApiException
     * @throws BimerRequestException
     * @throws BimerParameterException
     */
    public static function get(string $endpoint = '', array $params = [], bool $single = true)
    {
        $data = static::api()->get($endpoint, ['query' => $params]);

        return static::normalizeData($data, $single);
    }


    /**
     * Create or Update element
     *
     * @param array $params
     * @return mixed
     * @throws BimerApiException
     * @throws BimerRequestException
     * @throws BimerParameterException
     */
    public static function save(array $params)
    {
        if (!isset($params['Identificador'])) {
            return static::create($params);
        }

        return static::update($params['Identificador'], $params);
    }

    /**
     * Create element
     *
     * @param array $params
     * @param string $endpoint
     * @return mixed
     * @throws BimerApiException
     * @throws BimerRequestException
     * @throws BimerParameterException
     */
    public static function create(array $params, string $endpoint = '')
    {
        $data = static::api()->post($endpoint, ['json' => $params]);

        return static::normalizeData($data);
    }

    /**
     * Update element by ID
     *
     * @param string $id
     * @param array $params
     * @return mixed
     * @throws BimerApiException
     * @throws BimerRequestException
     * @throws BimerParameterException
     */
    public static function update(string $id, array $params)
    {
        $data = static::api()->put($id, ['json' => $params]);

        return static::normalizeData($data);
    }

    /**
     * Delete element by ID
     *
     * @param string $id
     * @param array $params
     * @return mixed
     * @throws BimerApiException
     * @throws BimerRequestException
     * @throws BimerParameterException
     */
    public static function delete(string $id, array $params = [])
    {
        $data = static::api()->delete($id, ['json' => $params]);

        return static::normalizeData($data);
    }

    /**
     * Normalize Response Data into an array of elements or a single element
     *
     * @param mixed $response
     * @param bool $single
     * @return mixed
     */
    private static function normalizeData($response, bool $single = true)
    {
        $isArray = isset($response->ListaObjetos) && is_array($response->ListaObjetos);

        $array = $isArray ? $response->ListaObjetos : [];
        $item = reset($array) ? reset($array) : null;

        return $single ? $item : $array;
    }
}
