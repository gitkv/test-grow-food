<?php


namespace App\TestWork\Collections;


use Carbon\Carbon;

/**
 * Интефейс коллеции данных описывающий метод поиска цен
 * Interface DataCollectionInterface
 * @package App\TestWork\Collections
 */
interface DataCollectionInterface
{
    /**
     * @param int $positionId
     * @param Carbon $orderDate
     * @param Carbon $deliveryDate
     * @return $this
     */
    public function findPrice(int $positionId, Carbon $orderDate, Carbon $deliveryDate) : self;
}