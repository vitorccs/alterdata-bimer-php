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

		public static function all($params = [])
		{
				static::setApi();

				$collection = static::$api->get(null, ['query' => $params]);

				return isset($collection->ListaObjetos) ? $collection->ListaObjetos : [];
		}

		public static function find($id)
		{
				static::setApi();

				$collection = static::$api->get($id);

				return $collection->ListaObjetos ? reset($collection->ListaObjetos) : null;
		}

		public static function create(array $params)
		{
				static::setApi();

				return static::$api->post(null, ['json' => $params]);
		}

		public static function update($id, $params)
		{
				static::setApi();

				return static::$api->put($id, ['json' => $params]);
		}

		public static function delete($id, array $params = [])
		{
				static::setApi();

				return static::$api->delete($id, ['json' => $params]);
		}
}
