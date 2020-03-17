<?php


namespace App\TestWork\Entities;


use Carbon\Carbon;

class OutputData
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
    protected $orderDateTo;

    /**
     * @var Carbon
     */
    protected $deliveryDateFrom;

    /**
     * @var Carbon
     */
    protected $deliveryDateTo;

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
     * @return OutputData
     */
    public function setPositionId(int $positionId) : OutputData
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
     * @return OutputData
     */
    public function setOrderDateFrom(Carbon $orderDateFrom) : OutputData
    {
        $this->orderDateFrom = $orderDateFrom;

        return $this;
    }

    /**
     * @return Carbon|null
     */
    public function getOrderDateTo() : ?Carbon
    {
        return $this->orderDateTo;
    }

    /**
     * @param Carbon $orderDateTo
     * @return OutputData
     */
    public function setOrderDateTo(?Carbon $orderDateTo) : OutputData
    {
        $this->orderDateTo = $orderDateTo;

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
     * @return OutputData
     */
    public function setDeliveryDateFrom(Carbon $deliveryDateFrom) : OutputData
    {
        $this->deliveryDateFrom = $deliveryDateFrom;

        return $this;
    }

    /**
     * @return Carbon|null
     */
    public function getDeliveryDateTo() : ?Carbon
    {
        return $this->deliveryDateTo;
    }

    /**
     * @param Carbon $deliveryDateTo
     * @return OutputData
     */
    public function setDeliveryDateTo(?Carbon $deliveryDateTo) : OutputData
    {
        $this->deliveryDateTo = $deliveryDateTo;

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
     * @return OutputData
     */
    public function setPrice(float $price) : OutputData
    {
        $this->price = $price;

        return $this;
    }

}