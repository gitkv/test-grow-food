<?php


namespace App\TestWork\Collections;


use Carbon\Carbon;
use Tightenco\Collect\Support\Collection;

class InputDataCollection extends Collection implements DataCollectionInterface
{

    public function findPrice(int $positionId, Carbon $orderDate, Carbon $deliveryDate) : DataCollectionInterface
    {
        $price = $this
            ->sortByDesc(function ($obj) {
                return $obj->deliveryDateFrom;
            })
            ->sortBy(function ($obj) {
                return $obj->orderDateFrom;
            })
            ->filter(function ($obj) use ($orderDate, $deliveryDate) {
                return $obj->deliveryDateFrom->timestamp <= $deliveryDate->timestamp
                    && $obj->orderDateFrom->timestamp <= $orderDate->timestamp;
            });

        return $price->take(1);
    }

}

