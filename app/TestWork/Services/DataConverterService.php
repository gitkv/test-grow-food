<?php


namespace App\TestWork\Services;


use App\TestWork\Entities\InputData;
use App\TestWork\Entities\OutputData;
use Tightenco\Collect\Support\Collection;

class DataConverterService
{

    protected $inputDataCollection;

    /**
     * DataConverterService constructor.
     * @param Collection $inputDataCollection <InputData>
     */
    public function __construct(Collection $inputDataCollection)
    {
        $this->inputDataCollection = $inputDataCollection;
    }

    /**
     * @return Collection <OutputData>
     */
    public function convert()
    {
        $outputDataCollection = new Collection();

        foreach ($this->inputDataCollection as $inputData) {
            $outputDataCollection->push($this->outputDataBuilder($inputData));
        }

        return $outputDataCollection;
    }

    /**
     * @param InputData $inputData
     * @return OutputData
     */
    protected function outputDataBuilder(InputData $inputData)
    {
        return (new OutputData())
            ->setPositionId($inputData->getPositionId())
            ->setOrderDateFrom($inputData->getOrderDateFrom())
            ->setOrderDateTo()
            ->setDeliveryDateFrom($inputData->getDeliveryDateFrom())
            ->setDeliveryDateTo()
            ->setPrice($inputData->getPrice());
    }

}