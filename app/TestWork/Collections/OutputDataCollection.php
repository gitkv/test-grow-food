<?php


namespace App\TestWork\Collections;


use Carbon\Carbon;
use Tightenco\Collect\Support\Collection;

class OutputDataCollection extends Collection implements DataCollectionInterface
{
    public function findPrice(int $positionId, Carbon $orderDate, Carbon $deliveryDate) : DataCollectionInterface
    {
        // TODO: Implement findPrice() method.
    }
}