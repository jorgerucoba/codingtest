<?php

namespace App\Machine;

class Cigarettes implements PurchasedItemInterface
{
    const COINS = [500, 200, 100, 50, 20, 10, 5, 1];

    /**
     * @var int
     */
    private $itemQuantity;

    /**
     * @var int
     */
    private $paidAmount;

    /**
     * @var array<string, int>
     */
    private $change = [];

    /**
     * @var int
     */
    private $totalAmount;

    /**
     * @param PurchaseTransactionInterface $transaction
     * @param float                        $price
     *
     * @throws \Exception
     */
    public function __construct($transaction, $price)
    {
        $this->itemQuantity = $transaction->getItemQuantity();
        $this->paidAmount = $transaction->getPaidAmount() * 100;
        $this->totalAmount = intval($price * 100) * $this->itemQuantity;

        if ($this->paidAmount < $this->totalAmount) {
            throw new \Exception(
                sprintf(
                    'The amount of money you gave is not enough to pay this amount of cigarettes. Please be sure to give more than EUR %.2f',
                    $this->getTotalAmount()
                )
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function getTotalAmount()
    {
        return $this->totalAmount / 100;
    }

    /**
     * @inheritDoc
     */
    public function getItemQuantity()
    {
        return $this->itemQuantity;
    }

    /**
     * @inheritDoc
     */
    public function getChange()
    {
        $remaining = intval($this->paidAmount - $this->totalAmount);

        foreach (self::COINS as $value) {
            $amountCoins = intval($remaining / $value);
            $remaining -= ($amountCoins * $value);

            if ($amountCoins != 0) {
                array_push($this->change, [sprintf('%.2f', $value / 100), $amountCoins]);
            }

            if ($remaining === 0) {
                break;
            }
        }

        return $this->change;
    }
}
