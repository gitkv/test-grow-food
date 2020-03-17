<?php


namespace App\TestWork\Services;


use App\TestWork\Entities\InputData;
use App\TestWork\Entities\OutputData;
use App\TestWork\Collections\InputDataCollection;
use App\TestWork\Collections\OutputDataCollection;
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
     * @param InputDataCollection $inputDataCollection
     */
    public function __construct(InputDataCollection $inputDataCollection)
    {
        $this->inputDataCollection = $inputDataCollection;
        $this->outputDataCollection = new OutputDataCollection();
    }

    /**
     * @return Collection <OutputData>
     */
    public function convert()
    {
        foreach ($this->inputDataCollection as $index => $inputData) {
            $this->calculate($inputData, $this->inputDataCollection->get(++$index));
        }

        return $this->outputDataCollection;
    }

    /**
     * Денормализация входящих данных
     * В ТЗ отсутствуют моменты как именно необходимо денормализовать данные, тут реализовано то, как я понял это,
     * Я почти уверен что реализация не правильная
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
        //может быть там надо оталкиватся от самой первой (ближайшей) даты доставки всех позиций, незнаю...
        else {
            $this->outputDataCollection->push($this->outputDataBuilder(
                $inputData->getPositionId(),
                $inputData->getOrderDateFrom(),
                null,
                $inputData->getDeliveryDateFrom(),
                $inputData->getDeliveryDateFrom()->copy()->endOfMonth()->startOfDay(),
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