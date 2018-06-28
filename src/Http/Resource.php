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

				$data = static::$api->get(null, ['query' => $params]);

				return static::normalizeData($data, false);
		}

		public static function find($id)
		{
				static::setApi();

				$data = static::$api->get($id);

				return static::normalizeData($data, true);
		}

		public static function create(array $params)
		{
				static::setApi();

				$data = static::$api->post(null, ['json' => $params]);

				return static::normalizeData($data, true);
		}

		public static function update($id, $params)
		{
				static::setApi();

				$data = static::$api->put($id, ['json' => $params]);

				return static::normalizeData($data, true);
		}

		public static function delete($id, array $params = [])
		{
				static::setApi();

				return static::$api->delete($id, ['json' => $params]);
		}

		/*
				Some GET/resource/ID methods returns an empty array with a 400 error (!)
				and some returns an array with a NULL value inside with a 200 OK response (what?!)
		*/
		private static function normalizeData($response, $first = false)
		{
				$isArray		= isset($response->ListaObjetos) && is_array($response->ListaObjetos);

				$array 			= $isArray ? $response->ListaObjetos : [];
				$item				= reset($array) ? reset($array) : null;

				return $first ? $item : $array;
		}
}
