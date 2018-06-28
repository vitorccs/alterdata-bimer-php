<?php
declare(strict_types=1);

namespace Bimer\Test;

class PersonCharacteristicTest extends ResourceTest
{
		public function setUp()
		{
				$this->resource = 'Bimer\PersonCharacteristic';
				$this->endpoint = 'pessoa/caracteristicas';
		}
}
