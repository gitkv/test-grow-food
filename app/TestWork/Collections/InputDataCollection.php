<?php


namespace App\TestWork\Collections;


use Carbon\Carbon;
use Tightenco\Collect\Support\Collection;

class InputDataCollection extends Collection implements DataCollectionInterface
{

    public function findPrice(int $positionId, Carbon $orderDate, Carbon $deliveryDate) : DataCollectionInterface
    {
        $price = $this
            ->filter(function ($obj) use ($orderDate, $deliveryDate) {
                return $obj->getDeliveryDateFrom()->timestamp <= $deliveryDate->timestamp
                    && $obj->getOrderDateFrom()->timestamp <= $orderDate->timestamp;
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

