<?php

namespace App\Machine;

/**
 * Class CigaretteMachine
 *
 * @package App\Machine
 */
class CigaretteMachine implements MachineInterface
{
    const ITEM_PRICE = 4.99;

    /**
     * @param PurchaseTransactionInterface $purchaseTransaction
     *
     * @return Cigarettes
     * @throws \Exception
     */
    public function execute(PurchaseTransactionInterface $purchaseTransaction)
    {
        return new Cigarettes($purchaseTransaction, self::ITEM_PRICE);
    }
}
