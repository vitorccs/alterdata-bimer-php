<?php
declare(strict_types=1);

namespace Bimer\Http;

use Bimer\Exceptions\BimerApiException;
use Bimer\Exceptions\BimerParameterException;
use Bimer\Exceptions\BimerRequestException;

abstract class Resource
{
    abstract public function endpoint(): string;

    /**
     * @throws BimerParameterException
     */
    public function api(): Api
    {
        return new Api($this->endpoint());
    }

    /**
     * Get array of objects
     *
     * This method attempts to normalize response to array format
     *
     * @throws BimerApiException
     * @throws BimerRequestException
     * @throws BimerParameterException
     */
    public function all(array  $params = [],
                        string $endpoint = ''): mixed
    {
        return $this->get($endpoint, $params, false);
    }

    /**
     * Get element by ID
     *
     * This method attempts to normalize response to object format
     *
     * @throws BimerApiException
     * @throws BimerRequestException
     * @throws BimerParameterException
     */
    public function find(string|int $id): mixed
    {
        return $this->get((string)$id);
    }

    /**
     * This method attempts to normalize response to object array
     * format (multiple items found) or object format (one item found)
     *
     * @throws BimerApiException
     * @throws BimerRequestException
     * @throws BimerParameterException
     */
    public function get(string $endpoint = '',
                        array  $params = [],
                        bool   $single = true): mixed
    {
        $data = $this->api()->get($endpoint, ['query' => $params]);

        return $this->normalizeData($data, $single);
    }

    /**
     * Create or Update element
     *
     * This method attempts to normalize response to object format
     *
     * @throws BimerApiException
     * @throws BimerRequestException
     * @throws BimerParameterException
     */
    public function save(array $params): mixed
    {
        if (!isset($params['Identificador'])) {
            return $this->create($params);
        }

        return $this->update((string)$params['Identificador'], $params);
    }

    /**
     * @throws BimerApiException
     * @throws BimerRequestException
     * @throws BimerParameterException
     *
     * This method attempts to normalize response to object format
     *
     * NOTE: some endpoints like IncomeService (titulosAReceber) returns
     * the object ID (string) instead of the object (!)
     */
    public function create(array  $params,
                           string $endpoint = ''): mixed
    {
        $data = $this->api()->post($endpoint, ['json' => $params]);

        return $this->normalizeData($data);
    }

    /**
     * @throws BimerApiException
     * @throws BimerRequestException
     * @throws BimerParameterException
     *
     * This method attempts to normalize response to object format
     *
     * NOTE: some endpoints like IncomeService (titulosAReceber) returns
     * the object ID (string) instead of the object (!)
     */
    public function update(string $id,
                           array  $params): mixed
    {
        $data = $this->api()->put($id, ['json' => $params]);

        return $this->normalizeData($data);
    }

    /**
     * @throws BimerApiException
     * @throws BimerRequestException
     * @throws BimerParameterException
     *
     * This method attempts to normalize response to object format
     */
    public function delete(string $id,
                           array  $params = []): mixed
    {
        $data = $this->api()->delete($id, ['json' => $params]);

        return $this->normalizeData($data);
    }

    /**
     * Normalize Response Data into an array of elements or a single element
     */
    private function normalizeData(mixed $response,
                                   bool  $single = true): mixed
    {
        $list = $response->ListaObjetos ?? null;
        $array = is_array($list) ? $list : [];

        return $single ? ($array[0] ?? null) : $array;
    }
}
