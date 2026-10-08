<?php

declare(strict_types=1);

namespace Bimer\Test\Integration;

use PHPUnit\Framework\Attributes\DataProvider;
use Bimer\IncomeService;

class IncomeServiceTest extends IntegrationTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->resource = new IncomeService();
    }

    #[DataProvider('incomeData')]
    public function testCreateIncome(array $incomeData): void
    {
        $incomeId = $this->resource->create($incomeData);

        $this->assertNotEmpty($incomeId);
    }

    #[DataProvider('incomeData')]
    public function testGetIncomeById(array $incomeData): void
    {
        $incomeId = $this->resource->create($incomeData);
        $income = $this->resource->find($incomeId);

        $this->assertObjectHasProperty('Identificador', $income);
    }

    #[DataProvider('batchData')]
    public function testMakeIncomeBatch(array $incomeData, array $batchData): void
    {
        $incomeId = $this->resource->create($incomeData);

        $batchData["LoteAReceberItemBaixa"][0]->IdentificadorTituloAReceber = $incomeId;
        $batch = $this->resource->makeBatch($batchData);

        $this->assertObjectHasProperty('IdentificadorLoteAReceber', $batch);
    }

    /**
     * Data provider for Income Data
     */
    public static function incomeData(): array
    {
        $incomeData = array_merge((array)json_decode(getenv('DATA_INCOME')), [
            "NumeroTitulo" => random_int(10000, 999999),
            "ValorTitulo" => 100,
            "DataReferencia" => date('Y-m-d H:i:s'),
            "DataEmissao" => date('Y-m-d H:i:s'),
            "DataVencimento" => date('Y-m-d H:i:s', strtotime('+5 days')),
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
            "ValorTitulo" => 100,
            "DataReferencia" => date('Y-m-d H:i:s'),
            "DataEmissao" => date('Y-m-d H:i:s'),
            "DataVencimento" => date('Y-m-d H:i:s', strtotime('+5 days')),
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
