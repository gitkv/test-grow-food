<?php


namespace App\TestWork\Collections;


use Carbon\Carbon;

interface DataCollectionInterface
{
    public function findPrice(int $positionId, Carbon $orderDate, Carbon $deliveryDate) : self;
}