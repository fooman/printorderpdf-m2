<?php

namespace Fooman\PrintOrderPdf\Test\TestCase;

/**
 * Class PrintOrderFromAdmin
 *
 * @group   Fooman
 * @package Fooman\PrintOrderPdf\Test\TestCase
 */
class PrintOrderFromAdminTest extends Common
{
    /**
     * Steps:
     *
     * 1. Create Order
     * 2. Find Order in Grid and open
     * 3. Print Order
     *
     * @return array
     */
    public function testPrint()
    {
        // Preconditions
        $order = $this->createOrder();

        // Steps
        $this->orderIndex->open();
        $this->orderIndex->getSalesOrderGrid()->searchAndOpen(['id' => $order->getId()]);

        return ['url' => $this->salesOrderView->getPrintActions()->printUrl()];
    }
}
