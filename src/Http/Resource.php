<?php
declare(strict_types=1);

namespace Bimer\Http;

use Bimer\Exceptions\BimerApiException;
use Bimer\Exceptions\BimerParameterException;
use Bimer\Exceptions\BimerRequestException;

abstract class Resource
{
    abstract public static function endpoint(): string;

    /**
     * @throws BimerParameterException
     */
    public static function api(): Api
    {
        return new Api(static::endpoint());
    }

    /**
     * Get array of objects
     *
     * @throws BimerApiException
     * @throws BimerRequestException
     * @throws BimerParameterException
     */
    public static function all(array  $params = [],
                               string $endpoint = ''): array
    {
        return static::get($endpoint, $params, false);
    }

    /**
     * Get element by ID
     *
     * @throws BimerApiException
     * @throws BimerRequestException
     * @throws BimerParameterException
     */
    public static function find(string|int $id): ?object
    {
        return static::get((string)$id);
    }

    /**
     * Make a GET request, returning a single element or an array of elements
     *
     * @throws BimerApiException
     * @throws BimerRequestException
     * @throws BimerParameterException
     */
    public static function get(string $endpoint = '',
                               array  $params = [],
                               bool   $single = true): object|array|null
    {
        $data = static::api()->get($endpoint, ['query' => $params]);

        return static::normalizeData($data, $single);
    }

    /**
     * Create or Update element
     *
     * @throws BimerApiException
     * @throws BimerRequestException
     * @throws BimerParameterException
     */
    public static function save(array $params): ?object
    {
        if (!isset($params['Identificador'])) {
            return static::create($params);
        }

        return static::update((string)$params['Identificador'], $params);
    }

    /**
     * @throws BimerApiException
     * @throws BimerRequestException
     * @throws BimerParameterException
     */
    public static function create(array  $params,
                                  string $endpoint = ''): ?object
    {
        $data = static::api()->post($endpoint, ['json' => $params]);

        return static::normalizeData($data);
    }

    /**
     * @throws BimerApiException
     * @throws BimerRequestException
     * @throws BimerParameterException
     */
    public static function update(string $id, array $params): ?object
    {
        $data = static::api()->put($id, ['json' => $params]);

        return static::normalizeData($data);
    }

    /**
     * @throws BimerApiException
     * @throws BimerRequestException
     * @throws BimerParameterException
     */
    public static function delete(string $id,
                                  array  $params = []): ?object
    {
        $data = static::api()->delete($id, ['json' => $params]);

        return static::normalizeData($data);
    }

    /**
     * Normalize Response Data into an array of elements or a single element
     */
    private static function normalizeData(mixed $response,
                                          bool  $single = true): object|array|null
    {
        $list = $response->ListaObjetos ?? null;
        $array = is_array($list) ? $list : [];

        return $single ? ($array[0] ?? null) : $array;
    }
}
