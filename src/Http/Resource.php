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

    public static function all($params = [], $endpoint = null)
    {
        static::setApi();

        $data = static::$api->get($endpoint, ['query' => $params]);

        return static::normalizeData($data, false);
    }

    public static function find($id)
    {
        static::setApi();

        $data = static::$api->get($id);

        return static::normalizeData($data);
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
