<?php


namespace App\TestWork\Services;


use App\TestWork\Entities\InputData;
use App\TestWork\Entities\OutputData;
use Carbon\Carbon;
use Tightenco\Collect\Support\Collection;

class DataConverterService
{
    /**
     * @var Collection
     */
    protected $inputDataCollection;

    /**
     * @var Collection
     */
    protected $outputDataCollection;

    /**
     * DataConverterService constructor.
     * @param Collection $inputDataCollection
     */
    public function __construct(Collection $inputDataCollection)
    {
        $this->inputDataCollection = $inputDataCollection;
        $this->outputDataCollection = new Collection();
    }

    /**
     * @return Collection <OutputData>
     */
    public function convert()
    {
        foreach ($this->inputDataCollection as $index => $inputData) {
            $this->calculate($inputData, $this->inputDataCollection->get(++$index));
        }
        var_dump($this->outputDataCollection);
        die;

        return $this->outputDataCollection;
    }

    /**
     * @param InputData $inputData
     * @param InputData|null $nexInputData
     */
    protected function calculate(InputData $inputData, ?InputData $nexInputData)
    {
        //если элемен не последний
        if ($nexInputData) {
            //если дата заказа и дата доставки следующей позиции больше предидущей
            //берем пересечение этих дат как две позиции
            if (
                $inputData->getOrderDateFrom()->lessThan($nexInputData->getOrderDateFrom())
                && $inputData->getDeliveryDateFrom()->lessThan($nexInputData->getDeliveryDateFrom())
            ) {
                $this->outputDataCollection->push($this->outputDataBuilder(
                    $inputData->getPositionId(),
                    $inputData->getOrderDateFrom(),
                    $inputData->getOrderDateFrom()->max($nexInputData->getOrderDateFrom())->copy()->addDays(-1),
                    $inputData->getDeliveryDateFrom()->max($nexInputData->getDeliveryDateFrom()),
                    null,
                    $inputData->getPrice()
                ));

                $this->outputDataCollection->push($this->outputDataBuilder(
                    $inputData->getPositionId(),
                    $inputData->getOrderDateFrom(),
                    null,
                    $inputData->getDeliveryDateFrom()->min($nexInputData->getDeliveryDateFrom()),
                    $inputData->getDeliveryDateFrom()->max($nexInputData->getDeliveryDateFrom())->copy()->addDays(-1),
                    $inputData->getPrice()
                ));
            }
            //если дата заказа и дата доставки следующей позиции не больше предидущей
            //берем как есть
            else {
                $this->outputDataCollection->push($this->outputDataBuilder(
                    $inputData->getPositionId(),
                    $inputData->getOrderDateFrom(),
                    null,
                    $inputData->getDeliveryDateFrom(),
                    null,
                    $inputData->getPrice()
                ));
            }
        }
        //если элемент последний
        //добавляем дату окончания доставки равную концу месяца
        //может быть там надо оталкиватся от самой последней даты всех позиций, незнаю...
        else {
            $this->outputDataCollection->push($this->outputDataBuilder(
                $inputData->getPositionId(),
                $inputData->getOrderDateFrom(),
                null,
                $inputData->getDeliveryDateFrom(),
                $inputData->getDeliveryDateFrom()->copy()->endOfMonth(),
                $inputData->getPrice()
            ));
        }
    }

    /**
     * @param int $positionId
     * @param Carbon $orderDateFrom
     * @param Carbon|null $orderDateTo
     * @param Carbon $deliveryDateFrom
     * @param Carbon|null $deliveryDateTo
     * @param float $price
     * @return OutputData
     */
    protected function outputDataBuilder(
        int $positionId,
        Carbon $orderDateFrom,
        ?Carbon $orderDateTo,
        Carbon $deliveryDateFrom,
        ?Carbon $deliveryDateTo,
        float $price
    ) : OutputData
    {
        return (new OutputData())
            ->setPositionId($positionId)
            ->setOrderDateFrom($orderDateFrom)
            ->setOrderDateTo($orderDateTo)
            ->setDeliveryDateFrom($deliveryDateFrom)
            ->setDeliveryDateTo($deliveryDateTo)
            ->setPrice($price);
    }

}