<?php

namespace Tests\Unit;

use App\TestWork\Entities\InputData;
use App\TestWork\Collections\InputDataCollection;
use App\TestWork\Services\DataConverterService;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class DataConverterServiceTest extends TestCase
{

    /**
     * @var InputDataCollection
     */
    protected $inputDataCollection;

    /**
     * @var DataConverterService
     */
    protected $dataConverterService;


    protected function setUp() : void
    {

        $this->inputDataCollection = new InputDataCollection([

            (new InputData())
                ->setPositionId(1)
                ->setOrderDateFrom(Carbon::parse('2019-02-01'))
                ->setDeliveryDateFrom(Carbon::parse('2019-03-01'))
                ->setPrice(100),

            (new InputData())
                ->setPositionId(1)
                ->setOrderDateFrom(Carbon::parse('2019-02-10'))
                ->setDeliveryDateFrom(Carbon::parse('2019-03-10'))
                ->setPrice(200),

            (new InputData())
                ->setPositionId(1)
                ->setOrderDateFrom(Carbon::parse('2019-02-20'))
                ->setDeliveryDateFrom(Carbon::parse('2019-02-25'))
                ->setPrice(130),
        ]);

        $this->dataConverterService = new DataConverterService($this->inputDataCollection);

    }

    public function testConvert()
    {

        $outputDataCollection = $this->dataConverterService->convert();

        $this->assertCount(4, $outputDataCollection);

        foreach ($outputDataCollection as $index => $outputData) {
            $this->assertEquals($this->getExpectData($index)['positionId'], $outputData->getPositionId());
            $this->assertEquals($this->getExpectData($index)['orderDateFrom'], $outputData->getOrderDateFrom());
            $this->assertEquals($this->getExpectData($index)['orderDateTo'], $outputData->getOrderDateTo());
            $this->assertEquals($this->getExpectData($index)['deliveryDateFrom'], $outputData->getDeliveryDateFrom());
            $this->assertEquals($this->getExpectData($index)['deliveryDateTo'], $outputData->getDeliveryDateTo());
            $this->assertEquals($this->getExpectData($index)['price'], $outputData->getPrice());
        }

    }

    protected function getExpectData(int $index)
    {
        $expectedData = [
            [
                'positionId'       => 1,
                'orderDateFrom'    => Carbon::parse('2019-02-01'),
                'orderDateTo'      => Carbon::parse('2019-02-09'),
                'deliveryDateFrom' => Carbon::parse('2019-03-10'),
                'deliveryDateTo'   => null,
                'price'            => '100',
            ],
            [
                'positionId'       => 1,
                'orderDateFrom'    => Carbon::parse('2019-02-01'),
                'orderDateTo'      => null,
                'deliveryDateFrom' => Carbon::parse('2019-03-01'),
                'deliveryDateTo'   => Carbon::parse('2019-03-09'),
                'price'            => '100',
            ],
            [
                'positionId'       => 1,
                'orderDateFrom'    => Carbon::parse('2019-02-10'),
                'orderDateTo'      => null,
                'deliveryDateFrom' => Carbon::parse('2019-03-10'),
                'deliveryDateTo'   => null,
                'price'            => '200',
            ],
            [
                'positionId'       => 1,
                'orderDateFrom'    => Carbon::parse('2019-02-20'),
                'orderDateTo'      => null,
                'deliveryDateFrom' => Carbon::parse('2019-02-25'),
                'deliveryDateTo'   => Carbon::parse('2019-02-28'),
                'price'            => '130',
            ],
        ];

        return $expectedData[$index];
    }
}
