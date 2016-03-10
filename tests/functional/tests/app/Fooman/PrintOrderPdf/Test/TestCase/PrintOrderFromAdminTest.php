<?php

namespace Fooman\PrintOrderPdf\Test\TestCase;

use Magento\Sales\Test\Fixture\OrderInjectable;
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
    public function test(OrderInjectable $order)
    {
        // Preconditions
        $order->persist();

        // Steps
        $this->orderIndex->open();
        $this->orderIndex->getSalesOrderGrid()->searchAndOpen(['id' => $order->getId()]);

        return ['url' => $this->salesOrderView->getPrintActions()->printUrl()];
    }
}
