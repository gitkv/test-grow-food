<?php

namespace Tests\Feature;

use App\TestWork\Entities\InputData;
use App\TestWork\Services\DataConverterService;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Tightenco\Collect\Support\Collection;

class DataConverterServiceTest extends TestCase
{


    /*protected function setUp():void
    {

    }*/

    public function testConvert()
    {
        $inputDataCollection = new Collection([

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

        $dataConverterService = new DataConverterService($inputDataCollection);

        $dataConverterService->convert();
    }
}
