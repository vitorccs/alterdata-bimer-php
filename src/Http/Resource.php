<?php
namespace Bimer\Http;

abstract class Resource
{
    protected static $api;

    abstract public static function endpoint();

    public static function setApi()
    {
        static::$api = new Api(static::endpoint());
    }

    // Alias for GET (with params)
    public static function all($params = [], $endpoint = null)
    {
        return static::get($endpoint, $params, false);
    }

    // Alias for GET (without params)
    public static function find($id)
    {
        return static::get($id);
    }

    public static function get($endpoint = null, $params = [], $single = true)
    {
        static::setApi();

        $data = static::$api->get($endpoint, ['query' => $params]);

        return static::normalizeData($data, $single);
    }

    // Alias for Create and Update methods
    public static function save(array $params)
    {
        if (isset($params['Identificador'])) {
            return static::create($params);
        }

        return static::update($params['Identificador'], $params);
    }

    public static function create(array $params)
    {
        static::setApi();

        $data = static::$api->post(null, ['json' => $params]);

        return static::normalizeData($data);
    }

    public static function update($id, $params)
    {
        static::setApi();

        $data = static::$api->put($id, ['json' => $params]);

        return static::normalizeData($data);
    }

    public static function delete($id, array $params = [])
    {
        static::setApi();

        $data = static::$api->delete($id, ['json' => $params]);

        return static::normalizeData($data);
    }

    /*
        Normalize Response Data so it will return an array for "all" method
        and a single object for all other methods
    */
    private static function normalizeData($response, $single = true)
    {
        $isArray    = isset($response->ListaObjetos) && is_array($response->ListaObjetos);

        $array      = $isArray ? $response->ListaObjetos : [];
        $item       = reset($array) ? reset($array) : null;

        return $single ? $item : $array;
    }
}
