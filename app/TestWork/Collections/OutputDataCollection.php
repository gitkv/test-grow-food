<?php


namespace App\TestWork\Collections;


use Carbon\Carbon;
use Tightenco\Collect\Support\Collection;

/**
 * Коллекция исходящих данных
 * Class OutputDataCollection
 * @package App\TestWork\Collections
 */
class OutputDataCollection extends Collection implements DataCollectionInterface
{
    /**
     * @inheritDoc
     */
    public function findPrice(int $positionId, Carbon $orderDate, Carbon $deliveryDate) : DataCollectionInterface
    {
        $price = $this
            ->filter(function ($obj) use ($orderDate, $deliveryDate) {

                $orderDateCondition = $obj->getOrderDateFrom()->timestamp <= $orderDate->timestamp;

                $deliveryDateCondition = $obj->getDeliveryDateFrom()->timestamp <= $deliveryDate->timestamp;

                if ($orderDateTo = $obj->getOrderDateTo()) {
                    $orderDateCondition = $orderDateCondition && $obj->getOrderDateTo()->timestamp >= $orderDate->timestamp;
                }

                if ($deliveryDateTo = $obj->getDeliveryDateTo()) {
                    $deliveryDateCondition = $deliveryDateCondition && $obj->getDeliveryDateTo()->timestamp >= $deliveryDate->timestamp;
                }

                return $orderDateCondition && $deliveryDateCondition;
            })
            ->sortByDesc(function ($obj) {
                return $obj->getOrderDateFrom()->timestamp;
            })
            ->sortByDesc(function ($obj) {
                return $obj->getDeliveryDateFrom()->timestamp;
            });

        return $price->take(1);
    }
}