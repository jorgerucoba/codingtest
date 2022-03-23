<?php

namespace App\Machine;

class CigarettePurchase implements PurchaseTransactionInterface
{
    /**
     * @var int
     */
    private $itemQuantity;

    /**
     * @var float
     */
    private $paidAmount;

    /**
     * @param int   $itemQuantity
     * @param float $paidAmount
     */
    public function __construct($itemQuantity, $paidAmount)
    {
        $this->itemQuantity = $itemQuantity;
        $this->paidAmount = $paidAmount;
    }

    public function getItemQuantity()
    {
        return $this->itemQuantity;
    }

    public function getPaidAmount()
    {
        return $this->paidAmount;
    }
}
