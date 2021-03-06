<?php

namespace Tests\Unit;

use App\TestWork\Collections\InputDataCollection;
use App\TestWork\Entities\InputData;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class InputDataCollectionTest extends TestCase
{
    /**
     * @var InputDataCollection
     */
    protected $inputDataCollection;

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
    }

    /**
     * @param Carbon $orderDate
     * @param Carbon $deliveryDate
     * @param float $price
     * @dataProvider providerFindData
     */
    public function testFindPrice(Carbon $orderDate, Carbon $deliveryDate, float $price)
    {
        $priceResult = $this->inputDataCollection->findPrice(1, $orderDate, $deliveryDate);

        $this->assertCount(1, $priceResult);
        $this->assertEquals($price, $priceResult->first()->getPrice());
    }

    public function providerFindData()
    {
        return [
            [
                Carbon::parse('2019-02-05'),
                Carbon::parse('2019-03-15'),
                100,
            ],
            [
                Carbon::parse('2019-02-15'),
                Carbon::parse('2019-03-15'),
                200,
            ],
            [
                Carbon::parse('2019-02-25'),
                Carbon::parse('2019-03-15'),
                200,
            ],
            [
                Carbon::parse('2019-02-25'),
                Carbon::parse('2019-03-05'),
                100,
            ],
            [
                Carbon::parse('2019-02-25'),
                Carbon::parse('2019-02-28'),
                130,
            ],
        ];
    }
}
