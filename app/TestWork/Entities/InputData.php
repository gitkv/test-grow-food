<?php


namespace App\TestWork\Entities;


use Carbon\Carbon;
use Tightenco\Collect\Contracts\Support\Arrayable;

/**
 * Входящие данные
 * Class InputData
 * @package App\TestWork\Entities
 */
class InputData implements Arrayable
{
    /**
     * @var int
     */
    protected $positionId;

    /**
     * @var Carbon
     */
    protected $orderDateFrom;

    /**
     * @var Carbon
     */
    protected $deliveryDateFrom;

    /**
     * @var float
     */
    protected $price;

    /**
     * @return int
     */
    public function getPositionId() : int
    {
        return $this->positionId;
    }

    /**
     * @param int $positionId
     * @return InputData
     */
    public function setPositionId(int $positionId) : InputData
    {
        $this->positionId = $positionId;

        return $this;
    }

    /**
     * @return Carbon
     */
    public function getOrderDateFrom() : Carbon
    {
        return $this->orderDateFrom;
    }

    /**
     * @param Carbon $orderDateFrom
     * @return InputData
     */
    public function setOrderDateFrom(Carbon $orderDateFrom) : InputData
    {
        $this->orderDateFrom = $orderDateFrom;

        return $this;
    }

    /**
     * @return Carbon
     */
    public function getDeliveryDateFrom() : Carbon
    {
        return $this->deliveryDateFrom;
    }

    /**
     * @param Carbon $deliveryDateFrom
     * @return InputData
     */
    public function setDeliveryDateFrom(Carbon $deliveryDateFrom) : InputData
    {
        $this->deliveryDateFrom = $deliveryDateFrom;

        return $this;
    }

    /**
     * @return float
     */
    public function getPrice() : float
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return InputData
     */
    public function setPrice(float $price) : InputData
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'positionId'       => $this->getPositionId(),
            'orderDateFrom'    => $this->getOrderDateFrom()->format('Y-m-d'),
            'deliveryDateFrom' => $this->getDeliveryDateFrom()->format('Y-m-d'),
            'price'            => $this->getPrice(),
        ];
    }
}
