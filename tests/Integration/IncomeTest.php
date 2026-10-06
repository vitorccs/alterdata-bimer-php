<?php

declare(strict_types=1);

namespace Bimer\Test\Integration;

use PHPUnit\Framework\Attributes\DataProvider;
use Bimer\Income;

class IncomeTest extends IntegrationTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->resource = Income::class;
    }

    #[DataProvider('incomeData')]
    public function testCreateIncome(array $incomeData)
    {
        $incomeId = Income::create($incomeData);

        $this->assertNotEmpty($incomeId);
    }

    #[DataProvider('incomeData')]
    public function testGetIncomeById(array $incomeData)
    {
        $incomeId = Income::create($incomeData);
        $income = $this->resource::find($incomeId);

        $this->assertObjectHasProperty('Identificador', $income);
    }

    #[DataProvider('batchData')]
    public function testMakeIncomeBatch(array $incomeData, array $batchData)
    {
        $incomeId = Income::create($incomeData);

        $batchData["LoteAReceberItemBaixa"][0]->IdentificadorTituloAReceber = $incomeId;
        $batch = Income::makeBatch($batchData);

        $this->assertObjectHasProperty('IdentificadorLoteAReceber', $batch);
    }

    /**
     * Data provider for Income Data
     */
    public static function incomeData(): array
    {
        $incomeData = array_merge((array)json_decode(getenv('DATA_INCOME')), [
            "NumeroTitulo" => random_int(10000, 999999),
            "ValorTitulo" => 100
        ]);

        return [
            [
                $incomeData
            ]
        ];
    }

    /**
     * Data provider for Batch Data
     */
    public static function batchData(): array
    {
        $incomeData = array_merge((array)json_decode(getenv('DATA_INCOME')), [
            "NumeroTitulo" => random_int(10000, 999999),
            "ValorTitulo" => 100
        ]);

        $batchData = (array)json_decode(getenv('DATA_INCOME_BATCH'));

        return [
            [
                $incomeData,
                $batchData
            ]
        ];
    }
}
