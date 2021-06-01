<?php

declare(strict_types=1);

namespace Bimer\Test;

use Bimer\Income;

class IncomeTest extends ResourceTest
{
    public function setUp(): void
    {
        $this->resource = Income::class;
    }

    /**
     * @dataProvider incomeData
     */
    public function testCreateIncome(array $incomeData)
    {
        $incomeId = Income::create($incomeData);

        $this->assertNotEmpty($incomeId);
    }

    /**
     * @dataProvider incomeData
     */
    public function testGetIncomeById(array $incomeData)
    {
        $incomeId = Income::create($incomeData);
        $income = $this->resource::find($incomeId);

        $this->assertObjectHasAttribute('Identificador', $income);
    }

    /**
     * @dataProvider batchData
     */
    public function testMakeIncomeBatch(array $incomeData, array $batchData)
    {
        $incomeId = Income::create($incomeData);

        $batchData["LoteAReceberItemBaixa"][0]->IdentificadorTituloAReceber = $incomeId;
        $batch = Income::makeBatch($batchData);

        $this->assertObjectHasAttribute('IdentificadorLoteAReceber', $batch);
    }

    /**
     * Data provider for Income Data
     */
    public function incomeData(): array
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
    public function batchData(): array
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
